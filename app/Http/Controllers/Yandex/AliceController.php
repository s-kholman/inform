<?php

namespace App\Http\Controllers\Yandex;

use App\Http\Controllers\Controller;
use App\Models\Yandex\Temperature;


class AliceController extends Controller
{

    public function temperature(): bool|string
    {
        $tmp = Temperature::query()
            ->where('thermometerName', 'sarai')
            ->orderBy('date', 'desc')
            ->limit(1)
            ->value('temperature');

        return json_encode(['value' => (float)$tmp]);
    }

}
