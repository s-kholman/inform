<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

use App\Events\ApplicationEvent;
use App\Models\Application\Application;
use App\Models\Application\ApplicationName;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IKEv2AccessRequestToCabinet
{
    public function __invoke()
    {

        Application::query()
            ->create(
                [
                    'user_id' => Auth::user()->id,
                    'application_name_id' => ApplicationName::query()->where('factory_name', 'IKEv2AccessRequestType')->first('id')->id,
                    'application_status_id' => 1,
                    'identification' => Str::uuid(),
                ]
            );

        /*
         * Управление передается мониторингу состояния модели, смотри модель Application
         * */

        return redirect()->route('vpn.index');

    }
}
