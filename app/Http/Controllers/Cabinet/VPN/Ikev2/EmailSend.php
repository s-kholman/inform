<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

use App\Actions\TempDir\TempDir;
use App\Http\Controllers\Controller;
use App\Jobs\VPNFileClear;
use App\Jobs\VPNSendEmailAccess;
use Illuminate\Support\Facades\Bus;

class EmailSend extends Controller
{
    use TempDir;
    /**
     * Handle the incoming request.
     */

    public function __invoke(UserVPN $user, MikrotikController $mikrotikController)
    {
        Bus::chain([
            new VPNSendEmailAccess($user->email(), $user->full_name(), $this->pathGet() .$mikrotikController->sslActive[0]['name'].'.zip'),
            new VPNFileClear($this->pathGet(), $mikrotikController->sslActive[0]['name']),
        ])->dispatch();
    }
}
