<?php

namespace App\Http\Controllers\Cabinet\VPN\Ikev2;

class IkeReport
{
    private array $report;

    public function __construct()
    {
        $this->report ['message'] =  'Значение по умолчанию';
    }

    public function set($key, $message): void
    {
        $this->report[$key] = $message;

    }

    public function getMessage(): array
    {
        return $this->report;
    }
}
