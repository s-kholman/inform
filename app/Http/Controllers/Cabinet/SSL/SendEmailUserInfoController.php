<?php

namespace App\Http\Controllers\cabinet\ssl;

use App\Http\Controllers\Controller;
use App\Jobs\VPNFileClear;
use App\Jobs\VPNSendEmailAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class SendEmailUserInfoController extends Controller
{
    use TempDir;
    /**
     * Handle the incoming request.
     */
    private array $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function __invoke($fileName)
    {
        Bus::chain([
            new VPNSendEmailAccess($this->user['email'], $this->user['full_name'], $this->pathTemp() .$fileName.'.zip'),
            new VPNFileClear($this->pathTemp(), $fileName),
        ])->dispatch();
    }
}
