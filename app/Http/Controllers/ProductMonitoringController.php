<?php

namespace App\Http\Controllers;

use App\Actions\Acronym\AcronymFullNameUser;
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
            ->with('Storagefilial')
            ->where('harvest_year_id', $harvest_year_id)
            ->get()
            ->unique('Storagefilial.nameFilial.name')
            ->sortBy('Storagefilial.nameFilial.name')
            ->groupBy('Storagefilial.nameFilial.name');



        return view('production_monitoring.index', ['filial' => $filial, 'year' => $year]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $post = json_decode(env('POST_ADD_MONITORING', '{"DIRECTOR":0,"DEPUTY":0,"TEMPERATURE:0"}'),true);

        $post_name = '';
        foreach ($post as $name => $key) {
            if ($key === Auth::user()->registration->post_id) {
                $post_name =  json_encode($name);
            }
        }

        return view('production_monitoring.create', ['post_name' => $post_name]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductMonitoringRequest $request, HarvestAction $harvestAction, AcronymFullNameUser $acronymFullNameUser)
    {
        $store = $request->validated();
        //Тестовое. Заполнение реквизитов по прошлому периоду
        $insertToManager = collect();





        if ($this->getPost() == '"TEMPERATURE"' && !array_key_exists('storage_phase_id',$store)) {
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
        $store ['condensate'] = boolval($request['condensate']);

        $date = ProductMonitoring::query()->updateOrCreate(
            [
                'storage_name_id' => $request['storage'],
                'date' => $request['date'],
            ],
                $store
        );

        if ($this->getPost() == '"DIRECTOR"' && array_key_exists('control_manager',$store)) {
            ProductMonitoringControl::query()
                ->create([
                    'product_monitoring_id' => $date->id,
                    'user_id' => Auth::user()->id,
                    'level' => 1,
                    'text' => $store['control_manager']
                ]);
            //DIRECTOR = 1; DEPUTY = 2;
        } elseif ($this->getPost() == '"DEPUTY"' && array_key_exists('control_director',$store)) {
            ProductMonitoringControl::query()
                ->create([
                    'product_monitoring_id' => $date->id,
                    'user_id' => Auth::user()->id,
                    'level' => 2,
                    'text' => $store['control_director']
                ]);
        }

        if ($request['timeUp'] <> null && $request['timeDown'] <> null) {
            StorageMode::create([
                'timeUp' => $request['timeUp'],
                'timeDown' => $request['timeDown'],
                'product_monitoring_id' => $date->id,
            ]);
        } elseif ($insertToManager->isNotEmpty()) {
            $StorageMode = StorageMode::query()
                ->where('product_monitoring_id', $insertToManager[0]->id)
                ->get()
            ;
            if ($StorageMode->isNotEmpty()){
                foreach ($StorageMode as $value){
                    StorageMode::query()->updateOrCreate([
                        'timeUp' => $value->timeUp,
                        'timeDown' => $value->timeDown,
                        'product_monitoring_id' => $date->id
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
        $post_name = $this->getPost();
        return view('production_monitoring.edit', ['monitoring' => $monitoring, 'post_name' => $post_name]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductMonitoringUpdateRequest $request, ProductMonitoring $monitoring)
    {
       // dd($request->validated());

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
                ->with('storageName')
                ->where('harvest_year_id', $harvest_year_id)
                ->get()
                ->where('storageName.filial_id', $filial_id)
                ->unique('storage_name_id')
                ->sortBy('storageName.name')
        ;


        return view('production_monitoring.show_filial', ['monitoring' => $monitoring]);
    }

    public function showFilialMonitoring($storage_id, $harvest_year_id)
    {
        $var = ProductMonitoring::query()
            ->with(['phase.StoragePhaseTemperature', 'productMonitoringControl.userName'])
            ->where('storage_name_id', $storage_id)
            ->where('harvest_year_id', $harvest_year_id)
            ->orderBy('date', 'desc')
            ->paginate(25)
        ;

        //dd($var);
        if ($var->isNotEmpty()) {
            return view('production_monitoring.show_filial_monitoring', ['monitoring' => $var, 'post_name' => $this->getPost()]);
        } else {
            return redirect()->route('monitoring.index');
        }
    }

    public function controlStorage(Request $request)
    {

        $post_name = $this->getPost();
        $storage_model = StorageName::query()->findOrFail($request->storage_id);
        //dd($storage_model);

        return view('production_monitoring.control', ['post_name' => $post_name, 'storage_model' => $storage_model]);
    }

    public function getPost(){
        $post = json_decode(env('POST_ADD_MONITORING', '{"DIRECTOR":0,"DEPUTY":0,"TEMPERATURE":0}'),true);

        $post_name = '';
        foreach ($post as $name => $key) {
            if ($key === Auth::user()->registration->post_id) {
                $post_name =  json_encode($name);
            }
        }
        return $post_name;
    }
}
