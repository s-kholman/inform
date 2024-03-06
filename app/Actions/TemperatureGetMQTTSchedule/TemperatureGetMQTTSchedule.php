<?php

namespace App\Actions\TemperatureGetMQTTSchedule;

use App\Jobs\TemperatureAlice;

class TemperatureGetMQTTSchedule
{
public function __invoke()
{
    dispatch(new TemperatureAlice());
}
}
