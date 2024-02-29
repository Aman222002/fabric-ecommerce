<?php

namespace App\Jobs;

use App\Mail\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $user;
    protected $data;
    protected $email;

    /**
     * Create a new job instance.
     * @return void
     */
    public function __construct(array $data)
    {
        //
        $this->user = $data;
        $this->email = $data['email'];
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle(): void
    {
        //
        Mail::to($this->email)->send(new Payment($this->user));
    }
}
