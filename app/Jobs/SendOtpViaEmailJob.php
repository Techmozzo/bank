<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOtpViaEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $recipient, $otp;

    /**
     * ForgotPasswordJob constructor.
     * @param $user
     * @param $otp
     */
    public function __construct(object $recipient, string $otp)
    {
        $this->recipient = $recipient;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subject = 'Ea-Banker';
        $heading = 'Ea-Banker Authorization Token ';
        $body = $this->messageBody();
        Mail::to($this->recipient->email)->send(new SendMail($this->recipient->name ?? $this->recipient->name(), $subject, $heading, $body));
    }

    private  function messageBody()
    {

        return "You are receiving this email because we received a senstive action on your account.
                    <br/><br/>Please use the OTP below to continue the process.
                    <br/><br/><b>$this->otp</b>
                    <br/><br/>If you did not request such action, no further action is required.
                    <br/><br/>Reach out to Ea-Banker Support if you have any complaints or enquiries.
                    <br/><br/>Thanks";
    }
}
