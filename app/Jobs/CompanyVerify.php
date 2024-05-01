<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCompanyEmail;
class CompanyVerify implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $verificationToken;
    /**
     * Create a new job instance.
     */
    public function __construct($user, $verificationToken)
    {
        //
        $this->user = $user;
        $this->verificationToken = $verificationToken;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->user->email)->send(new VerificationCompanyEmail($this->user, $this->verificationToken));
    }
}
