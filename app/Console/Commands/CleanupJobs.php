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
            $thirtyDaysAgo = Carbon::now()->subDays(30);
            Job::where('created_at', '<', $thirtyDaysAgo)->delete();
            Log::info("Old jobs older than 30 days have been deleted successfully.");
            return self::SUCCESS;
        } catch (\Exception $e) {
            Log::error("Error deleting old jobs: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
