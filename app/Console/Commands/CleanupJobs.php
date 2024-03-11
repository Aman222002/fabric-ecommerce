<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostExpiredMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class CleanupJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:cleanup';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'jobs delete  after some time';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        try {
            $thirtyDaysAgo = Carbon::now()->subDays(30);
            $jobs = Job::where('created_at', '<', $thirtyDaysAgo)->get();
            foreach ($jobs as $job) {
                $user = User::where('id', $job->user_id)->first();
                if ($user) {
                    Log::debug('user' . $user);
                    Mail::to($user->email)->send(new PostExpiredMail($job->title, $user));
                }
                $job->update([
                    'post_status' => 'Expired',
                ]);
                // $job->delete();
            }
            Log::debug('Job data' . $job);
            Log::info("Old job Post older than 30 days have been expired.");
            return self::SUCCESS;
        } catch (\Exception $e) {
            Log::error("Error deleting old jobs: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
