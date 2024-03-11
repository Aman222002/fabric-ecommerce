<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Plan;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use GoCardlessPro\Webhook;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Echo_;

class WebhookController extends Controller
{
    //
    public function webhookHandler(Request $request)
    {
        $webhookEndpointSecret = config('services.gocardless.webhook_secret');
        $requestBody = @file_get_contents('php://input');
        $signatureHeader =  $request->header('Webhook-Signature');
        $data = json_decode($requestBody);
        try {
            $events = Webhook::parse($requestBody, $signatureHeader, $webhookEndpointSecret);
            Log::info(print_r($data, true));
            $user_id = Null;
            if ($data && $data->events) {
                foreach ($data->events as $k => $v) {
                    if ($v->resource_type  == 'subscriptions') {
                        if ($v->action == 'payment_created') {
                            $user_id = $v->resource_metadata->user_id;
                            $user = User::find($user_id);
                            $user->update(['payment_id' => $v->links->payment]);
                            log::info('User Is' . $user);
                            $user->update(['subscription_status' => 'pending']);
                            $user_subscription = DB::table('user_subscription')->insert([
                                'plan_id' => $user->plan_id,
                                'user_id' => $user->id,
                                'subscription_status' => 'pending',
                                'subscription_id' => $v->links->subscription,
                                'start_date' => null,
                                'end_date' => null,
                                'next_plan_id' => null,
                            ]);
                        }
                    }
                    if ($v->resource_type == 'payments') {
                        $user = DB::table('users')->where('payment_id', $v->links->payment);
                        if ($v->action == 'created' || $v->action == 'failed' || $v->action == 'confirmed' || $v->action == 'paid_out') {
                            Log::info("Inside Payment");
                            if ($v->action !== 'confirmed') {
                                log::info(print_r('Action:' . $v->action, 1));
                            } else if ($v->action == 'paid_out') {
                                $user = User::where('payment_id', $v->links->payment)->get();
                                $plan = Plan::where('id', $user->plan_id)->get();
                                $interval = $plan->interval;
                                $interval_unit = $plan->interval;
                                $days = null;
                                if ($interval_unit == 'yearly') {
                                    $days = $interval * 365;
                                } else if ($interval_unit == 'monthly') {
                                    $carbonInterval = CarbonInterval::months($interval);
                                    $days = Carbon::now()->add($carbonInterval)->daysInMonth;
                                } else {
                                    $days = $interval * 7;
                                }
                                $days = $days - 1;
                                $start_date = Carbon::now();
                                $user_subscription = DB::table('user_subscription')->where('user_id', $user_id)->update([
                                    'plan_id' => $user->plan_id,
                                    'user_id' => $user->id,
                                    'subscription_status' => 'active',
                                    'start_date' => $start_date,
                                    'end_date' => $start_date->addDays($days),
                                ]);
                                $user->update(['subscription_status' => 'active']);
                            } else if ($v->action == 'failed') {
                                $user = DB::table('users')->where('payment_id', $v->links->payment);
                                $user->update(['subscription_status' => 'failed']);
                            }
                        }
                    }
                }
            }
            return response()->json(['message' => 'Webhook received and processed successfully', 'data' => $data], 200);
        } catch (\GoCardlessPro\Core\Exception\InvalidSignatureException $e) {
            return response()->json(['error' => 'Invalid signature'], 498);
        }
    }
}
