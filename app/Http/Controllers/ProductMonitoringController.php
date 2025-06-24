<?php

namespace App\Http\Controllers;

use App\Actions\harvest\HarvestAction;
use App\Http\Requests\ProductMonitoringRequest;
use App\Http\Requests\ProductMonitoringUpdateRequest;
use App\Models\ProductMonitoring;
use App\Models\ProductMonitoringControl;
use App\Models\StorageMode;
use App\Models\StorageName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductMonitoringController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(ProductMonitoring::class, 'monitoring');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $year = ProductMonitoring::query()
            ->with('harvestYear')
            ->distinct('harvest_year_id')
            ->limit(4)
            ->get()
            ->sortByDesc('harvestYear.name')
            ->groupBy('harvestYear.name');


        if (empty($request->year)) {
            if ($year->isNotEmpty()) {
                foreach ($year as $value) {
                    $harvest_year_id = $value[0]->harvestYear->id;
                    break;
                }
            }
        } else {
            $harvest_year_id = $request->year;
        }


        $filial = ProductMonitoring::query()
            ->select('filials.name as filial_name', 'filials.id as filial_id', 'harvest_year_id')
            ->join('storage_names', 'storage_names.id', 'product_monitorings.storage_name_id')
            ->join('filials', 'filials.id', 'filial_id')
            ->where('harvest_year_id', $harvest_year_id)
            ->distinct('filial_id')
            ->get()
            ->sortBy('filial_name')
            ->groupBy('filial_name')
        ;

        return view('production_monitoring.index', ['filial' => $filial, 'year' => $year]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('production_monitoring.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductMonitoringRequest $request, HarvestAction $harvestAction, ProductMonitoringControlController $controlController)
    {
        $store = $request->validated();
        $insertToManager = collect();

        if (!array_key_exists('storage_phase_id',$store)) {
            $insertToManager = ProductMonitoring::query()
                ->where('storage_name_id', $store['storage'])
                ->where('harvest_year_id', $harvestAction->HarvestYear(now(), 7))
                ->where('storage_phase_id', '<>', null)
                ->whereDate('date', '<=', $store['date'])
                ->orderByDesc('date')
                ->limit(1)
                ->get();
            if ($insertToManager->isNotEmpty()) {
                $store['storage_phase_id'] = $insertToManager[0]->storage_phase_id;
                $store['temperature_keeping'] = $insertToManager[0]->temperature_keeping;
                $store['humidity_keeping'] = $insertToManager[0]->humidity_keeping;
            }
        }

        unset($store['storage']);
        unset($store['date']);
        $store ['harvest_year_id'] = $harvestAction->HarvestYear(now(), 7);

        /**
         * При наличии поля "tuberTemperatureMorning"
         * добавляем поле "condensate" в любом случае.
         * При других условиях происходит затирание данных
        **/
        if (array_key_exists('tuberTemperatureMorning', $store)){
            $store ['condensate'] = boolval($request['condensate']);
        }

        $modelCreateOrUpdate = ProductMonitoring::query()->updateOrCreate(
            [
                'storage_name_id' => $request['storage'],
                'date' => $request['date'],
            ],
                $store
        );

        //Контроль директора и зам. генерального
        $controlController($modelCreateOrUpdate, $store);

        if ($request['timeUp'] <> null && $request['timeDown'] <> null) {
            StorageMode::query()
                ->create([
                    'timeUp' => $request['timeUp'],
                    'timeDown' => $request['timeDown'],
                    'product_monitoring_id' => $modelCreateOrUpdate->id,
                ]);
        } else
            if ($insertToManager->isNotEmpty()) {
            $StorageMode = StorageMode::query()
                ->where('product_monitoring_id', $insertToManager[0]->id)
                ->get()
            ;
            if ($StorageMode->isNotEmpty()){
                foreach ($StorageMode as $value){
                    StorageMode::query()->updateOrCreate([
                        'timeUp' => $value->timeUp,
                        'timeDown' => $value->timeDown,
                        'product_monitoring_id' => $modelCreateOrUpdate->id
                        ]);
                }
            }
        }



        return redirect()->route('monitoring.show.filial.all',
            ['storage_name_id' => $request['storage'],
             'harvest_year_id' => $harvestAction->HarvestYear(now(), 7)
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductMonitoring $monitoring)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductMonitoring $monitoring)
    {

        return view('production_monitoring.edit', ['monitoring' => $monitoring]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductMonitoringUpdateRequest $request, ProductMonitoring $monitoring)
    {
        $update = $request->validated();
        unset($update['timeUp']);
        unset($update['timeDown']);

        ProductMonitoring::query()->
                where('id', $monitoring->id)->
                update($update
        );

        if ($request['timeUp'] <> null && $request['timeDown'] <> null) {
            StorageMode::create([
                'timeUp' => $request['timeUp'],
                'timeDown' => $request['timeDown'],
                'product_monitoring_id' => $monitoring->id,
            ]);
        }
        return redirect()->route('monitoring.show.filial.all', ['storage_name_id' => $monitoring->storage_name_id, 'harvest_year_id' => $monitoring->harvest_year_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductMonitoring $monitoring)
    {
        $monitoring->delete();
        return response()->json(['status' => true, "redirect_url" => url(route('monitoring.show.filial.all', ['storage_name_id' => $monitoring->storage_name_id, 'harvest_year_id' => $monitoring->harvest_year_id]))]);

    }

    public function showFilial($filial_id, $harvest_year_id)
    {
        $monitoring = ProductMonitoring::query()
            ->join('storage_names', 'storage_names.id', 'product_monitorings.storage_name_id')
            ->where('harvest_year_id', $harvest_year_id)
            ->where('filial_id', $filial_id)
            ->distinct('storage_name_id')
            ->get()
            ->sortBy('name')
        ;
//dd($monitoring);
        return view('production_monitoring.show_filial', ['monitoring' => $monitoring]);
    }

    public function showFilialMonitoring($storage_id, $harvest_year_id)
    {
        $var = ProductMonitoring::query()
            ->with(['phase.StoragePhaseTemperature', 'productMonitoringControl'])
            ->where('storage_name_id', $storage_id)
            ->where('harvest_year_id', $harvest_year_id)
            ->orderBy('date', 'desc')
            ->paginate(25)
        ;

        if ($var->isNotEmpty()) {
            return view('production_monitoring.showFilialMonitoringTable', ['monitoring' => $var]);
        } else {
            return redirect()->route('monitoring.index');
        }
    }

    public function controlStorage(Request $request)
    {

        $storage_model = StorageName::query()->findOrFail($request->storage_id);

        return view('production_monitoring.control', ['storage_model' => $storage_model]);
    }

}
