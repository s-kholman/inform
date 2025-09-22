<?php

namespace App\Http\Controllers;

use App\Models\filial;
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
                            order by date desc", ['id' => $storage_name_id, 'year_id' => $year_id]
        )
        ;
        if (empty($group_monitoring)){
            return redirect()->back();
        }
        $filial_id = StorageName::query()
            ->find($storage_name_id);

        $oneAvgTemp = collect($group_monitoring)->where('avg_temperature_point_one', '<>', null)->sortBy('date')->pluck('avg_temperature_point_one');
        $oneAvgTempDate = collect($group_monitoring)->where('avg_temperature_point_one', '<>', null)->sortBy('date')->pluck('date')->toArray();

        $oneAvgTempDateFormat = collect($oneAvgTempDate)->map(function (?string $date) {
            return Carbon::parse($date)->format('d.m.Y');
        })->reject(function (string $date) {
            return empty($date);
        });
        //dump($temp);
        //dd($oneAvgTempDateFormat);
        /*$chart_options_one = [
            'chart_title' => 'Средняя температура бурт',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\ProductMonitoringDevice',
            'conditions'            => [
                ['name' => 'В бурте', 'condition' => 'storage_name_id = '.$storage_name_id . 'and harvest_year_id = ' .$year_id , 'color' => 'blue', 'fill' => true],
            ],
            'aggregate_function' => 'avg',
            'aggregate_field' => 'temperature_point_one',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_days' => 30,
            'date_format ' => 'd.m.Y',
            'chart_height' => 100,
        ];

        $chart_options_two = [
            'chart_title' => 'Средняя температура шахта',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\ProductMonitoringDevice',
            'conditions'            => [
                ['name' => 'В бурте', 'condition' => 'storage_name_id = '.$storage_name_id . 'and harvest_year_id = ' .$year_id , 'color' => 'green', 'fill' => true],
            ],
            'aggregate_function' => 'avg',
            'aggregate_field' => 'temperature_point_two',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'chart_type' => 'line',
            'filter_field' => 'created_at',
            'filter_days' => 30,

        ];


        $chart1 = new LaravelChart($chart_options_one, $chart_options_two);*/

        $chart = Chartjs::build()
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($oneAvgTempDateFormat->toArray())
            ->datasets([
                [
                    "label" => "Температура в бурте",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => 'red',//"rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => 'blue',//"rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => 'yellow',//"rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $oneAvgTemp,
                    "fill" => false,
                ],
/*                [
                    "label" => "My Second dataset",
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    "data" => $temp,
                    "fill" => false,
                ]*/
            ])
            ->options([]);

        return response()->view('production_monitoring.device.show',
            [
                'filial_id' => $filial_id['filial_id'],
                'year_id' => $year_id,
                'storage_name_id' => $storage_name_id,
                'group_monitoring' => collect($group_monitoring),
                //'chart1' => $chart1,
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

}
