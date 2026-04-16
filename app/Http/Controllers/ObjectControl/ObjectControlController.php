<?php

namespace App\Http\Controllers\ObjectControl;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MaxBot\MaxBotSendMessageController;
use App\Http\Requests\ObjectControlRequest;
use App\Models\ObjectControl\ObjectControl;
use App\Models\ObjectControl\ObjectControlImportance;
use App\Models\ObjectControl\ObjectControlPoint;
use App\Models\ObjectControl\ObjectName;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ObjectControlController extends Controller
{
    protected array $objectControlImportance = [4, 5];

    public function index(Request $request): Response
    {

        $dates = explode(' — ', $request->date_range);

        if (!empty($dates[0])) {
            $startDate = Carbon::parse($dates[0])->format('d.m.Y');
        } else {
            $startDate = Carbon::parse(now())->format('d.m.Y');
        }

        if (!empty($dates[1])) {
            $endDate = Carbon::parse($dates[1])->format('d.m.Y');
        } elseif (!empty($dates[0])) {
            $endDate = $startDate;
        } else {
            $endDate = Carbon::parse(now())->subMonths()->format('d.m.Y');
        }

        $filial_id = $request->filial ?? 0;
        $pole_id = $request->pole_id ?? 0;

        $query = ObjectControl::query()
            ->with(['objectName.PoleName', 'objectName.ObjectType', 'filial', 'objectControlPoint', 'objectControlImportance', 'User.Registration']);

        if (!empty($request->filial)) {
            $query->where('filial_id', $request->filial);
        }

        if (!empty($request->pole_id)) {
            $query->where('pole_id', $request->pole_id);
        }

        $query->whereBetween('date', [$startDate, $endDate]);

        $objectControl = $query
            ->orderByDesc('date')
            ->orderBy('object_control_point_id')
            ->get()
            ->sortBy('filial.name')
            ->sortByDesc('created_at');

        $filials = ObjectControl::query()
            ->with('filial')
            ->distinct()
            ->get('filial_id')
            ->sortBy('filial.name');

        $poles = ObjectControl::query()
            ->with('objectName.PoleName')
            ->whereNotNull('pole_id')
            ->distinct('pole_id')
            ->get()
            ->groupBy('filial_id');

        return response()->view('objectControl.index',
            [
                'objectControl' => $objectControl,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'filials' => $filials,
                'filial_id' => $filial_id,
                'pole_id' => $pole_id,
                'poles' => $poles,
            ]
        );
    }

    public function create(): Response
    {

        $objectControl = ObjectName::query()
            ->with(['FilialName', 'ObjectType', 'PoleName'])
            ->get()
            ->sortBy('name');

        $objectControlPoint = ObjectControlPoint::query()
            ->get()
            ->groupBy('object_type_id');

        $objectControlImportances = ObjectControlImportance::query()
            ->orderBy('id')
            ->get();

        $filialObjectControl = collect($objectControl)->sortBy('FilialName.name')->groupBy(['filial_id', 'object_type_id']);

        return response()->view('objectControl.create',
            [
                'filialObjectControl' => $filialObjectControl,
                'objectControlPoint' => $objectControlPoint,
                'objectControlImportances' => $objectControlImportances,

            ]
        );
    }

    public function store(Request $request): RedirectResponse
        //public function store(ObjectControlRequest $request): RedirectResponse

    {
        // dd($request->post());
        foreach ($request->post() as $key => $value) {

            if (str_contains($key, 'verified_')) {

                $objectControl = ObjectControl::query()
                    ->create(
                        [
                            'object_name_id' => $request->objectName,
                            'filial_id' => $request->filial,
                            'object_control_point_id' => $request['objectControlPoint_' . filter_var($key, 519)],
                            'object_control_importance_id' => $request['selectImportances_' . filter_var($key, 519)],
                            'user_id' => Auth::id(),
                            'pole_id' => $request->pole_id,
                            'messages' => $request['message_' . filter_var($key, 519)],
                            'date' => $request->date,
                        ]
                    );

                if ($this->objectControlImportance[0] == $objectControl->object_control_importance_id || $this->objectControlImportance[1] == $objectControl->object_control_importance_id) {
                    $this->messageAlarm($objectControl);
                }

            }

        }

        return response()->redirectToRoute('object.control.create');

    }

    private function messageAlarm(ObjectControl $objectControl): void
    {

        $full = ObjectControl::query()
            ->with(['filial', 'objectName', 'Pole', 'objectControlPoint'])
            ->where('id', $objectControl->id)
            ->first()
        ;

        $users = User::with(['roles', 'Registration.MaxBotUser'])
            ->get()
            ->filter(fn($user) => $user->roles->where('name', '=', 'objectControllAlarmMessageWater.user')
                ->toArray());

        $message = 'Оповещение по объектам контроля: ' . PHP_EOL;
        $message .= 'Филиал - **' . $full->filial->name .'**'. PHP_EOL;
        $message .= 'Объект: ' . $full->objectName->name;
        if (!empty($full->Pole)){
            $message .= ' (' . $full->Pole->name. ')' . PHP_EOL;
        } else {
            $message .= PHP_EOL;
        }
        $message .= 'Точка контроля: ' . $full->objectControlPoint->name . PHP_EOL;
        $message .= 'Сообщение : ' . $full->messages . PHP_EOL;
        $message .= 'Дата: ' . Carbon::parse($full->date)->format('d.m.Y');

        foreach ($users as $user) {

            if ($users->isNotEmpty()) {

                $maxBotSendMessage = new MaxBotSendMessageController();

                try {
                    $maxBotSendMessage($user->Registration->MaxBotUser, $message);
                } catch (\Throwable $exception) {
                    Log::warning('Error send "Water" message MAX: ' . $exception);
                }
            }
        }

    }
}
