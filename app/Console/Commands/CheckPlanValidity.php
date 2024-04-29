<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Plan;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Log;
use App\Services\GoCardlessServices;

class CheckPlanValidity extends Command
{
    protected $gocardlessService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:plan-validity';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check validity of user plan';

    public function __construct(GoCardlessServices $gocardlessService)
    {
        parent::__construct();
        $this->gocardlessService = $gocardlessService;
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        try {
            $today = date("y-m-d");
            $user_subscription = UserSubscription::where('end_date', '<', $today)->whereNotNull('next_plan_id')->get();
            foreach ($user_subscription as $subscription) {
                $data = $subscription->subscription_id;
                $user_data = User::find($subscription->user_id);
                $this->gocardlessService->removeSubscription($data);
                $plan = Plan::find($subscription->next_plan_id);
                $priceCents = $plan->price * 100;
                $data = [
                    "amount" => $priceCents,
                    "currency" => "GBP",
                    "name" => $plan->name,
                    "interval_unit" => $plan->interval_unit,
                    "interval" => $plan->interval,
                    "metadata" => ['user_id' => strval($subscription->user_id)],
                    "links" => ["mandate" => $user_data->mandate_id],
                ];
                $subscription->delete();
                $this->gocardlessService->createSubscription($data);
                Log::info("Success");
                return self::SUCCESS;
            }
        } catch (\Exception $e) {
            Log::info("Failure");
            return self::FAILURE;
        }
    }
}
