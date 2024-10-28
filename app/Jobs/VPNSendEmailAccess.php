<?php

namespace App\Jobs;

use App\Mail\SendSSLMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class VPNSendEmailAccess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private $email, private $full_name, private $filepath)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (count($this->email) > 1){
            Mail::to($this->email[0], $this->full_name)->cc($this->email[1])->send(new SendSSLMail($this->filepath));
        } else {
            Mail::to($this->email[0], $this->full_name)->send(new SendSSLMail($this->filepath));
        }

    }
}
