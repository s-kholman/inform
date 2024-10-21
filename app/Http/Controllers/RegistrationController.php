<?php

namespace App\Http\Controllers;


use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use App\Models\Sms;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class RegistrationController extends Controller
{
    /**
     * Выносим в Policy в контроллере только вызываем
     */
    public function index(){

        if(User::with('Registration')->findOrFail(Auth::user()->id))
        {
            return view('profile.index', ['user_reg' => Auth::user()->registration] );
        } else
        {
            return view('profile.index', ['user_reg' => false]);
        }


    }

    /**
     * Выносим в отдельный класс только сохранение, валидация вынесена в Request
    */
    public function store(RegistrationRequest $request){

        $validated = $request->validated();
        Registration::updateOrCreate([
            'user_id' => auth()->user()->id
        ],[
            'last_name' => $validated['last_name'],
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'filial_id' => $validated['filial_name'],
            'post_id' => $validated['post_name'],
            'phone' => $validated['phone'],
            'infoFull' => true
        ]);
        /**
         * Создание записи для SMS оповещения выносим в слушателя
         */
        $middle = !is_null($validated['middle_name']) ? Str::substr($validated['middle_name'], 0, 1) . '.' : '';
        try
        {

            Sms::create([
                'smsText' =>
                    'Заполненна информация по '
                    . $validated['last_name']
                    . ' '
                    .Str::substr($validated['first_name'], 0, 1)
                    .'. '
                    .$middle,
                'phone' => '+79026223673',
                'smsType' => 1,
                'smsActive' => true
            ]);

        } catch (QueryException $e)
        {

        }

        return redirect()->route('/');
    }

    public function show(Request $request)
    {

        $profile = Registration::query()
            ->with(['filial', 'Post', 'User'])
            ->where('id',$request->profile)
            ->first();

        $userRole = implode(',', $profile->user->getRolenames()->toArray());

        $rolesUser = Role::whereNotIn('name', [$userRole])->get();;


            return view('profile.show', ['profile' => $profile, 'rolesUser' => $rolesUser]);
    }

}
