<?php

namespace App\Http\Controllers;

use App\Models\filial;
use App\Models\ProductMonitoring;
use App\Models\ProductMonitoringDevice;
use App\Models\StorageName;
use IcehouseVentures\LaravelChartjs\Facades\Chartjs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class ProductMonitoringDeviceController extends Controller
{
    public function show(): Response
    {
        dd('Не используем метод');
        $monitoring = ProductMonitoringDevice::query()
            ->orderBy('created_at')
            ->get()
        ;
//$dailyEvents = Event::selectRaw('DATE(created_at) as date, COUNT(*) as count') -> groupBy('date') -> get();
        $group_monitoring = DB::select(
            "select DATE(created_at) as date,
    AVG (temperature_point_one) as avg_temperature_point_one,
    MAX (temperature_point_one) as max_temperature_point_one,
    MIN (temperature_point_one) as min_temperature_point_one,
    AVG (temperature_point_two) as avg_temperature_point_two,
    MAX (temperature_point_two) as max_temperature_point_two,
    MIN (temperature_point_two) as min_temperature_point_two,
    AVG (temperature_point_three) as avg_temperature_point_three,
    MAX (temperature_point_three) as max_temperature_point_three,
    MIN (temperature_point_three) as min_temperature_point_three,
    AVG (temperature_point_four) as avg_temperature_point_four,
    MAX (temperature_point_four) as max_temperature_point_four,
    MIN (temperature_point_four) as min_temperature_point_four,
    AVG (temperature_point_five) as avg_temperature_point_five,
    MAX (temperature_point_five) as max_temperature_point_five,
    MIN (temperature_point_five) as min_temperature_point_five,
    AVG (temperature_point_six) as avg_temperature_point_six,
    MAX (temperature_point_six) as max_temperature_point_six,
    MIN (temperature_point_six) as min_temperature_point_six
                    from product_monitoring_devices
                        group by date
                            order by date"
        )
            ;
dump($group_monitoring);
        return response()->view('production_monitoring.device.show',
            [
                'monitoring' => $monitoring,
                'group_monitoring' => collect($group_monitoring),
            ]);
    }

    public function showStorage($storage_name_id, $year_id)
    {

        $group_monitoring = DB::select(
            "select DATE(created_at) as date,
    ROUND(AVG (temperature_point_one)::numeric, 2) as avg_temperature_point_one,
    MAX (temperature_point_one) as max_temperature_point_one,
    MIN (temperature_point_one) as min_temperature_point_one,
    ROUND(AVG (temperature_point_two)::numeric, 2) as avg_temperature_point_two,
    MAX (temperature_point_two) as max_temperature_point_two,
    MIN (temperature_point_two) as min_temperature_point_two,
    AVG (temperature_point_three) as avg_temperature_point_three,
    MAX (temperature_point_three) as max_temperature_point_three,
    MIN (temperature_point_three) as min_temperature_point_three,
    AVG (temperature_point_four) as avg_temperature_point_four,
    MAX (temperature_point_four) as max_temperature_point_four,
    MIN (temperature_point_four) as min_temperature_point_four,
    AVG (temperature_point_five) as avg_temperature_point_five,
    MAX (temperature_point_five) as max_temperature_point_five,
    MIN (temperature_point_five) as min_temperature_point_five,
    AVG (temperature_point_six) as avg_temperature_point_six,
    MAX (temperature_point_six) as max_temperature_point_six,
    MIN (temperature_point_six) as min_temperature_point_six,
    AVG (temperature_point_seven) as avg_temperature_point_seven,
    MAX (temperature_point_seven) as max_temperature_point_seven,
    MIN (temperature_point_seven) as min_temperature_point_seven,
    AVG (temperature_point_eight) as avg_temperature_point_eight,
    MAX (temperature_point_eight) as max_temperature_point_eight,
    MIN (temperature_point_eight) as min_temperature_point_eight,
    AVG (temperature_point_nine) as avg_temperature_point_nine,
    MAX (temperature_point_nine) as max_temperature_point_nine,
    MIN (temperature_point_nine) as min_temperature_point_nine,
    AVG (temperature_point_ten) as avg_temperature_point_ten,
    MAX (temperature_point_ten) as max_temperature_point_ten,
    MIN (temperature_point_ten) as min_temperature_point_ten,
    AVG (temperature_point_eleven) as avg_temperature_point_eleven,
    MAX (temperature_point_eleven) as max_temperature_point_eleven,
    MIN (temperature_point_eleven) as min_temperature_point_eleven,
    AVG (temperature_point_twelve) as avg_temperature_point_twelve,
    MAX (temperature_point_twelve) as max_temperature_point_twelve,
    MIN (temperature_point_twelve) as min_temperature_point_twelve,
    AVG (temperature_humidity) as avg_temperature_humidity,
    MAX (temperature_humidity) as max_temperature_humidity,
    MIN (temperature_humidity) as min_temperature_humidity,
    AVG (humidity) as avg_humidity,
    MAX (humidity) as max_humidity,
    MIN (humidity) as min_humidity
                    from product_monitoring_devices
                    where storage_name_id = :id and harvest_year_id = :year_id
                        group by date
                           order by date desc
                           limit 90
                           ", ['id' => $storage_name_id, 'year_id' => $year_id]
        );

        if (empty($group_monitoring)){
            //return redirect()->back();
            return \response()->redirectToRoute('monitoring.index', ['year' => $year_id]);
        }

        $line_query_group_monitoring = $group_monitoring;
        $line_query = ProductMonitoring::query()
            ->with('phase.StoragePhaseTemperature')
            ->whereDate('date', '>=', array_pop($line_query_group_monitoring)->date)
            ->where('storage_name_id', $storage_name_id)
            ->where('harvest_year_id', $year_id)
            ->distinct('storage_phase_id')
            ->get()
            //->groupBy('date');
        ;

        $step = 0;
        $line_min = [];
        $count = true;
        $data = '';
        $t = collect($group_monitoring);

        foreach ($line_query->sortBy('date') as $value){

            if (count($line_query) > 1 && $count){
                $count = false;
            } elseif(!$count) {
               foreach ($t->whereBetween('date', [$data->date, Carbon::parse($value->date)->subDay()->format('Y-m-d')]) as $r){
                   $line_min [] = $data->phase->StoragePhaseTemperature->temperature_min ?? null;
               }
                }

            $data = $value;
            $step++;

                if (count($line_query) == $step){
                    foreach ($t->whereBetween('date', [$data->date, now()]) as $o){
                        $line_min [] = $value->phase->StoragePhaseTemperature->temperature_min ?? null;
                    }
                }
            }


        $filial_id = StorageName::query()
            ->find($storage_name_id);

        $oneAvgData = $this->renderDataChart('one', $group_monitoring);
        $twoAvgData = $this->renderDataChart('two', $group_monitoring);

        $chart = Chartjs::build()
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($oneAvgData['avgDateFormat']->toArray())
            ->datasets([
                [
                    "label" => "Температура в бурте",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => 'blue',//"rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => 'blue',//"rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $oneAvgData['avg'],
                    "fill" => false,
                ],
                [
                    "label" => "Температура в шахте",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $twoAvgData['avg'],
                    "fill" => false,
                ],
                [
                    "label" => "Температура по инструкции минимум",
                    'backgroundColor' => "#541010",
                    'borderColor' => '#541010',
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "#541010",
                    "pointHoverBackgroundColor" => "#541010",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $line_min,
                    "fill" => false,
                ]
            ])
            ->options([]);

        return response()->view('production_monitoring.device.show',
            [
                'filial_id' => $filial_id['filial_id'],
                'year_id' => $year_id,
                'storage_name_id' => $storage_name_id,
                'group_monitoring' => collect($group_monitoring),
                'chart' => $chart,
            ]);

    }

    public function showDay($storage_name_id, $year_id, $date)
    {
        $monitoring = ProductMonitoringDevice::query()
            ->whereDate('product_monitoring_devices.created_at', $date)
            ->where('storage_name_id', $storage_name_id)
            ->where('harvest_year_id', $year_id)
            ->orderByDesc('created_at')
            ->get()
        ;
        return response()->view('production_monitoring.device.show_day',
            [
                'monitoring' => $monitoring,
                'storage_name_id' => $storage_name_id,
            ]);
    }

    public function destroy(ProductMonitoringDevice $productMonitoringDevice): \Illuminate\Http\RedirectResponse
    {
        try {
            $productMonitoringDevice->delete();

        } catch (\Illuminate\Database\QueryException $e) {
            return \response()->redirectToRoute('monitoring.show.filial.all', ['storage_name_id' => $productMonitoringDevice->storage_name_id, 'harvest_year_id' => $productMonitoringDevice->harvest_year_id]);
        }
        //<a class="btn btn-secondary " href="{{route('monitoring.show.filial', ['filial_id' => $filial_id, 'harvest_year_id' => $year_id])}}">Назад</a>
        return \response()->redirectToRoute('product.monitoring.devices.show.storage', ['id' => $productMonitoringDevice->storage_name_id, 'year' => $productMonitoringDevice->harvest_year_id]);
    }

    private function renderDataChart(string $namePoint, $dataMonitoring): array
    {
        $avg = collect($dataMonitoring)->where('avg_temperature_point_' . $namePoint, '<>', null)->sortBy('date')->pluck('avg_temperature_point_' . $namePoint);
        $avgDate = collect($dataMonitoring)->where('avg_temperature_point_' . $namePoint, '<>', null)->sortBy('date')->pluck('date')->toArray();

        $avgDateFormat = collect($avgDate)->map(function (?string $date) {
            return Carbon::parse($date)->format('d.m.Y');
        })->reject(function (string $date) {
            return empty($date);
        });
        return ['avg' => $avg, 'avgDateFormat' => $avgDateFormat];
    }

}
