<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
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
            $tenMinutesAgo = Carbon::now()->subMinutes(10);
            Job::where('created_at', '<', $tenMinutesAgo)->delete();
            Log::info("Success");
            return self::SUCCESS;
        } catch (\Exception $e) {
            //$this->error('Error deleting old jobs: ' . $e->getMessage());
            Log::debug("Fail");
            return self::FAILURE;
        }
    }
}
