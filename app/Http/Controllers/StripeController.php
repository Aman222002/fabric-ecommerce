<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StripeServices;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Jobs\PaymentJob;
use App\Models\UserSubscription;

class StripeController extends Controller
{
    protected $stripeServices;

    public function __construct(StripeServices $stripeServices)
    {
        $this->stripeServices = $stripeServices;
    }
    public function createSubscription(Request $request)
    {
        $customerId = 'stripe_customer_id';
        try {
            $subscription = $this->stripeServices->createSubscription($customerId, 'price_id');
        } catch (\Exception $e) {

            Log::error('Subscription creation failed: ' . $e->getMessage());
        }
    }
    public function cancelSubscription(Request $request)
    {
        $subscriptionId = 'stripe_subscription_id';
        try {
            $this->stripeServices->cancelSubscription($subscriptionId);
        } catch (\Exception $e) {
            Log::error('Subscription cancellation failed: ' . $e->getMessage());
        }
    }
    public function createPaymentIntent(Request $request)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            $input = $request->all();
            $user = Auth::user();
            $user->load('company.address');
            $selected_plan = Plan::find($input['id']);
            $user_plan = Plan::find($user->plan_id);
            $priceCents = $selected_plan->price * 100;
            $plan_id = $selected_plan->id;
            // $paymentIntent = \Stripe\Subscription::create([
            //     'amount' => $priceCents,
            //     'currency' => 'gbp',
            //     'metadata' => [
            //         'plan_id' => $plan_id,
            //     ],
            // ]);
            if ($user->subscription_status == 'active') {
                $data = [
                    "amount" => $priceCents,
                    "currency" => "GBP",
                    "name" => $selected_plan->name,
                    "interval_unit" => $selected_plan->interval_unit,
                    "interval" => $selected_plan->interval,
                    "metadata" => ['user_id' => strval($user->id)],
                ];
                // dd($data);
                if ($selected_plan->price > $user_plan->price) {
                    $user_subscription = UserSubscription::where('user_id', $user->id)->first();

                    // $this->gocardlessService->createSubscription($data);
                    $paymentIntent = \Stripe\PaymentIntent::create([
                        'amount' => $priceCents,
                        'currency' => 'gbp',
                        'metadata' => [
                            'plan_id' => $plan_id,
                        ],
                    ]);
                    // $subscription = \Stripe\Subscription::create([
                    //     'customer' => $customer_id,
                    //     'items' => [
                    //         [
                    //             'plan' => $plan_id,
                    //         ],
                    //     ],
                    //     'metadata' => [
                    //         'plan_id' => $plan_id,
                    //     ],
                    // ]);
                    $checkoutSessionOptions = [
                        'payment_method_types' => ['card'],
                        'line_items' => [
                            [
                                'price_data' => [
                                    'currency' => 'gbp',
                                    'product_data' => [
                                        'name' => $selected_plan->name,
                                    ],
                                    'unit_amount' => $priceCents,
                                ],
                                'quantity' => 1,
                            ],
                        ],
                        'mode' => 'payment',
                        'success_url' => env('APP_URL') . '/success?session_id={CHECKOUT_SESSION_ID}',
                        'cancel_url' => env('APP_URL') . '/cancel',
                    ];
                    $email = $user->email;
                    $name = $user->name;
                    $session_token = md5(uniqid(rand(), true));
                    $checkoutSession = Session::create($checkoutSessionOptions);
                    $paymentIntentId = $paymentIntent->id;
                    $user->update(['upgrade_plan_id' => $input['id'], 'upgrade_status' => 'initiated', 'upgrade_plan_payment_id' => $paymentIntentId]);
                    return response()->json([
                        'status' => true,
                        'message' => "Subscription Will be added within 4-5 days in your account"
                    ], 200);
                } else {
                    $users_subscription = UserSubscription::where('user_id', $user->id)->first();
                    $users_subscription->update(['next_plan_id' => $input['id']]);
                }
            }
            if (empty($user->stripe_customer_id)) {
                $customer = \Stripe\Customer::create([
                    'email' => $user->email,
                    'name' => $user->name,
                ]);
            } else {
                $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
            }
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $priceCents,
                'currency' => 'gbp',
                'metadata' => [
                    'plan_id' => $plan_id,
                ],
            ]);
            // $plan = \Stripe\Plan::create([
            //     'amount' => $priceCents,
            //     'currency' => 'gbp',
            //     'metadata' => [
            //         'plan_id' => $plan_id,
            //     ],
            //     "interval" => $selected_plan->interval_unit,
            //     "product" => $selected_plan->id,
            // ]);
            // $subscription = \Stripe\Subscription::create([
            //     'customer' => $customer->id,
            //     'items' => [
            //         [
            //             'plan' => $selected_plan->id,
            //         ],
            //     ],
            // ]);
            $checkoutSessionOptions = [
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'gbp',
                            'product_data' => [
                                'name' => $selected_plan->name,
                            ],
                            'unit_amount' => $priceCents,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => env('APP_URL') . '/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => env('APP_URL') . '/cancel',
            ];
            $email = $user->email;
            $name = $user->name;
            $session_token = md5(uniqid(rand(), true));
            // $companyAddress = $user->company->address->city;
            // $companyAddress = [
            //     'line1' => $user->company->address->first_line_address,
            //     'city' => $user->company->address->city,
            //     'state' => $user->company->address->state,
            //     'postal_code' => $user->company->address->postal_code,
            //     'country' => 'US',
            // ];
            //$redirect_url = url('complete/redirect/flow/' . $user->id . '/' . $input['id'] . '/' . $session_token);
            $param = [
                "name" => $name,
                "email" => $email,
                'metadata' => [
                    'session_token' => $session_token,
                    'plan_id' => $plan_id,
                ],
                // "billing" => [
                //     "address" => $companyAddress
                // ],
            ];
            // $redirectFlow = $this->stripeServices->createRedirectFlow($param);
            $checkoutSession = Session::create($checkoutSessionOptions);
            $paymentIntentId = $paymentIntent->id;
            $customerId = $customer->id;
            //dd($customerId);
            $data = [
                'email' => $user->email,
                'url' => $checkoutSession->url,
            ];
            dispatch(new PaymentJob($data));
            // $redirectFlow = $this->stripeServices->createRedirectFlow($param);
            $user->plan_id = $selected_plan->id;
            $user->subscription_status = 'pending';
            $user->gc_customer_id = $customerId;
            $user->payment_id = $paymentIntentId;
            $user->save();
            // UserSubscription::create([
            //     'user_id' => $user->id,
            //     'plan_id' => $selected_plan->id,
            //     'subscription_status' => 'pending',
            // ]);
            UserSubscription::updateOrCreate(
                ['user_id' => $user->id],
                ['plan_id' => $selected_plan->id, 'subscription_status' => 'pending']
            );
            return response()->json([
                'status' => true,
                'sessionId' => $checkoutSession->id,
                'url' => $checkoutSession->url,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function cancelUpgradeRequest()
    {
        try {
            $user = Auth::user();
            $user_subscription = UserSubscription::where('user_id', $user->id)->first();
            //dd($user_subscription);
            $this->stripeServices->cancelSubscription($user_subscription->upgrade_subscription_id);
            sleep(8);
            return response()->json(['status' => true, 'message' => 'Canceled Successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}


