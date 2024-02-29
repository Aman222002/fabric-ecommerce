<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Command;

use function PHPUnit\Framework\returnSelf;

class CleanResetToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clean-reset-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        try {
            $users = User::whereNotNull('reset_token')->get();
            foreach ($users as $user) {
                $user->reset_token = null;
                $user->save();
            }
        } catch (\Exception $e) {
            Log::info("Failure");
            return Self::FAILURE;
        }
    }
}
