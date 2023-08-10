<?php

namespace App\Http\Controllers;

use App\Models\CurrentStatus;
use App\Models\DailyUse;
use App\Models\Life;
use App\Models\Rashod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LifeController extends Controller
{
    public function life ()
    {
        $life = Life::all();

        foreach ($life as $item) {
            $lifeToCurrentStatus [$item->id] = [
                'device_id' => $item->id_deviceprint,
                'hostname' => $item->hostname,
                'ip' => $item->ip,
                'filial_id' => $this->toId($item->id_filial),
                'status_id' => $item->id_sostoyanie,
                'date' => $item->date
                ];
        }

        foreach ($lifeToCurrentStatus as $id => $item){
            DB::table('current_statuses')->insert([
                'id' => $id,
                'device_id' => $item['device_id'],
                'hostname' => $item['hostname'],
                'ip' => $item['ip'],
                'filial_id' => $item['filial_id'],
                'status_id' => $item['status_id'],
                'date' => $item['date']
            ]);
        }

        return view('export.life');
    }

    public function rashod ()
    {
        foreach (Rashod::all() as $value)
        {
            DailyUse::create([
                'device_id' => $value->id_print,
                'toner' => $value->toner,
                'count' => $value->stranica,
                'date' => $value->rashod_date
            ]);
        }
        return view('export.life');
    }



    private function toId ($id)
    {

        switch ($id)
        {
            case 0:
                return 80;
            case 1:
                return 1;
            case 2:
                return 2;
            case 3:
                return 68;
            case 4:
                return 69;
            case 5:
                return 70;
            case 6:
                return 4;
            case 7:
                return 71;
            case 8:
                return 72;
            case 9:
                return 73;
            case 10:
                return 74;
            case 11:
                return 75;
            case 12:
                return 76;
            case 13:
                return 77;
            case 14:
                return 78;
            case 15:
                return 79;
            case 16:
                return 80;
            case 17:
                return 3;
            case 18:
                return 81;
            case 19:
                return 82;
            case 20:
                return 83;
            case 21:
                return 86;
            case 22:
                return 84;
            case 23:
                return 85;
            case 24:
                return 87;
            case 25:
                return 5;
            case 26:
                return 88;


        }
    }
}
