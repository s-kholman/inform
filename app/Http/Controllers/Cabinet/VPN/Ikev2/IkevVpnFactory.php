<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

use Exception;

abstract class IkevVpnFactory
{

    private MikrotikController $mikrotikController;

    private IkeReport $report;

    private UserVPN $userVPN;

    public function __construct($userID)
    {
        $this->report = new IkeReport();

        try {
            $this->userVPN = new UserVPN($userID);
        } catch (Exception $exception) {
            $this->report->set('error', $exception->getMessage());
        }

        $this->mikrotikController = new MikrotikController($this->userVPN);
    }

    public function render(): array
    {
            try {
                $service = $this->run();
                $service->action($this->mikrotikController, $this->report);
                $service->fileDownload($this->mikrotikController);
                $service->archive($this->mikrotikController, $this->report);
                $service->emailSend($this->userVPN, $this->mikrotikController);
            }
            catch (ExceptionInform $exceptionInform){
                $this->report->set('message', $exceptionInform->getMessage());
            }
            catch (Exception $exception){
                $this->report->set('error', $exception->getMessage());
            }
            finally {
                return $this->report->getMessage();
            }

    }

    abstract function run():IkeVpnMikrotikInterface;

}
