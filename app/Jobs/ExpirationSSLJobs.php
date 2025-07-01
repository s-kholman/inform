<?php

namespace App\Jobs;

use App\Actions\Acronym\AcronymFullNameUser;
use App\Actions\Declension\DeclensionWord;
use App\Actions\VPN\SSLInfo;
use App\Mail\ExpirationSSLMail;
use App\Models\Sms;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ExpirationSSLJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $userExpiration;

    public function __construct($userExpiration)
    {
        $this->userExpiration = $userExpiration;
    }

    /**
     * Execute the job.
     */
    public function handle(SSLInfo $info, DeclensionWord $declensionWord, AcronymFullNameUser $fullNameUser): void
    {
        $sslInfo = $info($this->userExpiration->Registration->User);

        Mail::to($this->userExpiration->Registration->User->email, $fullNameUser->Acronym($this->userExpiration->Registration))
            ->bcc('s-kholman@ya.ru')
            ->cc($this->userExpiration->mail_send)
            ->send(new ExpirationSSLMail($declensionWord($sslInfo['expires_after'], 'день', 'дня','дней')));

        Sms::query()
            ->create([
                'smsText' => 'VPN доступ, для ' . $fullNameUser->Acronym($this->userExpiration->Registration) . ', закончится через ' . $declensionWord($sslInfo['expires_after'], 'день', 'дня','дней') . '. Подробности на https://inform.krimm.ru/vpn',
                'phone' => $this->userExpiration->Registration->phone,
                'smsType' => 1,
                'smsActive' => true
            ]);
    }
}
