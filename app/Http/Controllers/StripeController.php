<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StripeServices;
use Stripe\Stripe;
use Stripe\StripeInvoice;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Jobs\PaymentJob;
use App\Models\UserSubscription;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\ApiErrorException;

class StripeController extends Controller
{
    protected $stripeServices;

    public function __construct(StripeServices $stripeServices)
    {
        $this->stripeServices = $stripeServices;
    }
    // public function createSubscription(Request $request)
    // {
    //     $customerId = 'stripe_customer_id';
    //     try {
    //         $subscription = $this->stripeServices->createSubscription($customerId, 'price_id');
    //     } catch (\Exception $e) {

    //         Log::error('Subscription creation failed: ' . $e->getMessage());
    //     }
    // }
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
            if ($user->subscription_status == 'active') {
                $data = [
                    "amount" => $priceCents,
                    "currency" => "GBP",
                    "name" => $selected_plan->name,
                    "interval_unit" => $selected_plan->interval_unit,
                    "interval" => $selected_plan->interval,
                    "metadata" => ['user_id' => strval($user->id)],
                ];
                if ($selected_plan->price > $user_plan->price) {
                    $user_subscription = UserSubscription::where('user_id', $user->id)->first();
                    $paymentIntent = \Stripe\PaymentIntent::create([
                        'amount' => $priceCents,
                        'currency' => 'gbp',
                        'metadata' => [
                            'plan_id' => $plan_id,
                        ],
                    ]);
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
            if (!$customer->invoice_settings->default_payment_method) {

                $setupIntent = \Stripe\SetupIntent::create([
                    'customer' => $customer->id,
                    'payment_method_types' => ['card'],
                ]);
                $customer = \Stripe\Customer::retrieve($customer->id);
            }

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $priceCents,
                'currency' => 'gbp',
                'metadata' => [
                    'plan_id' => $plan_id,
                ],
                'customer' => $customer->id,

            ]);

            $product = \Stripe\Product::create([
                'name' => $selected_plan->name,
                'metadata' => [
                    'plan_id' => $plan_id,
                ],
            ]);
            $plan = \Stripe\Plan::create([
                'amount' => $priceCents,
                'currency' => 'gbp',
                'metadata' => [
                    'plan_id' => $plan_id,
                ],
                "interval" => $selected_plan->interval_unit,
                'product' => $product->id,
            ]);
            $subscription = \Stripe\Subscription::create([
                'customer' => $customer->id,
                'items' => [
                    [
                        'plan' => $plan->id,
                    ],
                ],
                'metadata' => [
                    'plan_id' => $plan_id,
                ],
            ]);
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
            // $checkoutSessionOptions = [
            //     'payment_method_types' => ['card'],
            //     'line_items' => [
            //         [
            //             'price_data' => [
            //                 'currency' => 'gbp',
            //                 'product_data' => [
            //                     'name' => $selected_plan->name,
            //                 ],
            //                 'recurring' => [
            //                     'interval' => $selected_plan->interval_unit,  
            //                     'interval_count' => $selected_plan->interval, 
            //                 ],
            //                 'unit_amount' => $priceCents,
            //             ],
            //             'quantity' => 1,
            //         ],
            //     ],
            //     'mode' => 'subscription',
            //     'success_url' => env('APP_URL') . '/success?session_id={CHECKOUT_SESSION_ID}',
            //     'cancel_url' => env('APP_URL') . '/cancel',
            // ];
            $email = $user->email;
            $name = $user->name;
            $session_token = md5(uniqid(rand(), true));

            $param = [
                "name" => $name,
                "email" => $email,
                'metadata' => [
                    'session_token' => $session_token,
                    'plan_id' => $plan_id,
                ],

            ];

            $checkoutSession = Session::create($checkoutSessionOptions);
            $paymentIntentId = $paymentIntent->id;
            $customerId = $customer->id;

            $data = [
                'email' => $user->email,
                'url' => $checkoutSession->url,
            ];
            dispatch(new PaymentJob($data));

            $user->plan_id = $selected_plan->id;
            $user->subscription_status = 'pending';
            $user->gc_customer_id = $customerId;
            $user->payment_id = $paymentIntentId;
            $user->save();

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
    // public function createCustomer(Request $request)
    // {
    //     try {
    //         $customer = \Stripe\Customer::create([
    //             'name' => $request->input('name'),
    //             'email' => $request->input('email'),
    //             'phone' => $request->input('phone'),
    //         ]);
    //         $customer = \Stripe\Customer::retrieve($customer->id);

    //         $customerId = $customer->id;
    //         $setupIntent = \Stripe\SetupIntent::create([
    //             'customer' => $customer->id,
    //         ]);

    //         return response()->json(['customer' => $customer, 'customerId' => $customerId]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    //     public function createSubscription(Request $request)
    //     {
    //         try {
    //             $request->validate([
    //                 'customer' => 'required|string',

    //                 'plan_id' => 'required|integer',
    //             ]);

    //             $customerId = $request->input('customer');
    //             $paymentMethodId = $request->input('payment_method');
    //             $planId = $request->input('priceId');

    //             $selected_plan = Plan::find($planId);
    //             if (!$selected_plan) {
    //                 return response()->json(['error' => 'Plan not found.'], 404);
    //             }

    //             $customer = \Stripe\Customer::retrieve($customerId);
    //             if (!$customer) {
    //                 throw new \Exception('Customer not found.');
    //             }

    //             // Attach payment method to customer
    //             \Stripe\PaymentMethod::attach($paymentMethodId, [
    //                 'customer' => $customerId,
    //             ]);

    //             // Set payment method as default
    //             \Stripe\Customer::update($customerId, [
    //                 'invoice_settings' => [
    //                     'default_payment_method' => $paymentMethodId,
    //                 ],
    //             ]);

    //             $priceCents = $selected_plan->price * 100;
    //             $price = \Stripe\Price::create([
    //                 'currency' => 'gbp',
    //                 'unit_amount' => $priceCents,
    //                 'recurring' => [
    //                     'interval' => $selected_plan->interval_unit,
    //                     'interval_count' => $selected_plan->interval,
    //                 ],
    //                 'product_data' => [
    //                     'name' => $selected_plan->name,
    //                 ],
    //             ]);

    //             // Create the subscription
    //             $subscription = \Stripe\Subscription::create([
    //                 'customer' => $customer->id,
    //                 'items' => [
    //                     [
    //                         'price' => $price->id,
    //                     ],
    //                 ],
    //                 'default_payment_method' => $paymentMethodId,
    //             ]);

    //             return response()->json(['subscription' => $subscription]);
    //         } catch (InvalidRequestException $e) {
    //             // Handle specific Stripe API request errors
    //             return response()->json(['error' => $e->getMessage()], 400);
    //         } catch (\Exception $e) {
    //             // Handle other generic exceptions
    //             return response()->json(['error' => $e->getMessage()], 500);
    //         }
    //     }
    //     public function attachPaymentMethod(Request $request)
    // {
    //   dd($request);
    //     try {
    //         $customerId = $request->input('customerId');
    //         $paymentMethodId = $request->input('paymentMethodId');

    //         // Attach the payment method to the customer
    //         \Stripe\PaymentMethod::attach($paymentMethodId, [
    //             'customer' => $customerId,
    //         ]);

    //         // Set the payment method as the default
    //         \Stripe\Customer::update($customerId, [
    //             'invoice_settings' => [
    //                 'default_payment_method' => $paymentMethodId,
    //             ],
    //         ]);

    //         return response()->json(['success' => true]);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }

    // public function createSubscription(Request $request)
    // {

    //     try {

    //         Stripe::setApiKey(config('services.stripe.secret'));

    //         $paymentMethod = $request->input('payment_method_id');
    //         $planId = $request->input('plan_id');
    //         $intervalUnit = $request->input('interval');
    //         $planPrice = $request->input('plan_price');
    //         $planName = $request->input('plan_name');
    //         $user = Auth::user();
    //         $selectedPlan = Plan::find($planId); 
    //         $userPlan = Plan::find($user->plan_id);
    //         $priceCents = $planPrice * 100;


    //         if ($user->subscription_status == 'active') {
    //             if ($planPrice > $userPlan->price) {

    //                 $product = \Stripe\Product::create([
    //                     'name' => $planName,
    //                     'metadata' => [
    //                         'plan_id' => $planId,
    //                     ],
    //                 ]);

    //                 $plan = \Stripe\Plan::create([
    //                     'amount' => $priceCents,
    //                     'currency' => 'gbp',
    //                     'metadata' => [
    //                         'plan_id' => $planId,
    //                     ],
    //                     'interval' => $intervalUnit,
    //                     'product' => $product->id,
    //                 ]);
    //                 $userSubscription = UserSubscription::where('user_id', $user->id)->first();
    //                 $subscription = \Stripe\Subscription::retrieve($userSubscription->subscription_id,);
    //                 $updatedSubscription = \Stripe\Subscription::update($userSubscription->subscription_id, [

    //                     'items' => [
    //                         [
    //                             'id' => $subscription->items->data[0]->id,
    //                             'plan' => $plan->id,
    //                         ],
    //                     ],
    //                     'expand' => ['latest_invoice.payment_intent'],
    //                 ]);
    //                 $currentPeriodStart = $updatedSubscription->current_period_start;
    //                 $currentPeriodEnd = $updatedSubscription->current_period_end;


    //                 $userSubscription = UserSubscription::where('user_id', $user->id)->first();
    //                 $userSubscription->update([
    //                     'next_plan_id' => $planId,
    //                     'upgrade_subscription_id' =>$subscription->items->data[0]->id,
    //                     'start_date' => date('Y-m-d H:i:s', $currentPeriodStart),
    //                 'end_date' => date('Y-m-d H:i:s', $currentPeriodEnd)
    //                 ]);

    //                 $userSubscription->update(['next_plan_id' => $planId,'upgrade_subscription_id'=> $subscription->items->data[0]->id,'start_date' => date('Y-m-d H:i:s', $currentPeriodStart),
    //                 'end_date' => date('Y-m-d H:i:s', $currentPeriodEnd)]);

    //                 $user->update([
    //                     'upgrade_plan_id' => $planId,
    //                     'upgrade_status' => 'initiated', 
    //                     'upgrade_plan_payment_id' => $paymentMethod, 
    //                 ]);

    //                 return response()->json([
    //                     'status' => true,
    //                     'message' => "Subscription upgrade initiated. New plan will be added within 4-5 days.",
    //                 ], 200);
    //             } 
    //         }
    //         $customer = \Stripe\Customer::create([
    //             'payment_method' => $paymentMethod,
    //             'email' => auth()->user()->email,
    //             'invoice_settings' => [
    //                 'default_payment_method' => $paymentMethod,
    //             ],
    //         ]);
    //         $product = \Stripe\Product::create([
    //             'name'=> $planName,
    //             'metadata' => [
    //                 'plan_id' =>$planId,
    //             ],
    //         ]);
    //         $plan = \Stripe\Plan::create([
    //             'amount' => $priceCents,
    //             'currency' => 'gbp',
    //             'metadata' => [
    //                 'plan_id' => $planId,
    //             ],
    //             'interval' =>  $intervalUnit,
    //             'product' => $product->id,
    //         ]);


    //         $subscription = \Stripe\Subscription::create([
    //             'customer' => $customer->id,
    //             'items' => [['plan' => $plan->id]],
    //             'expand' => ['latest_invoice.payment_intent'],
    //         ]);
    //         $currentPeriodStart = $subscription->current_period_start;
    // $currentPeriodEnd = $subscription->current_period_end;
    //        // dd($subscription);
    //         $user->plan_id = $planId;
    //         $user->subscription_status = 'active';
    //         $user->gc_customer_id = $customer->id;
    //         $user->payment_id = $paymentMethod;
    //         $user->save();

    //         UserSubscription::updateOrCreate(
    //             ['user_id' => $user->id],
    //             ['plan_id' => $planId, 'subscription_status' => 'active','subscription_id'=>$subscription->id,'start_date' => date('Y-m-d H:i:s', $currentPeriodStart),
    //             'end_date' => date('Y-m-d H:i:s', $currentPeriodEnd)]
    //         );

    //         return response()->json([
    //             'success' => true,
    //             'subscription' => $subscription,
    //         ]);
    //     } catch (ApiErrorException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'error' => $e->getMessage(),
    //         ], 500);
    //     }
    // }
    public function createSubscription(Request $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            $paymentMethod = $request->input('payment_method_id');
            $planId = $request->input('plan_id');
            $intervalUnit = $request->input('interval');
            $planPrice = $request->input('plan_price');
            $planName = $request->input('plan_name');
            $user = Auth::user();
            $selectedPlan = Plan::find($planId);
            $userPlan = Plan::find($user->plan_id);
            $priceCents = $planPrice * 100;
            if ($user->subscription_status == 'active') {
                $userSubscription = UserSubscription::where('user_id', $user->id)->first();
                $subscription = \Stripe\Subscription::retrieve($userSubscription->subscription_id);
                if ($planPrice > $userPlan->price) {
                    $customer = \Stripe\Customer::retrieve($user->gc_customer_id);
                    $product = \Stripe\Product::create([
                        'name' => $planName,
                        'metadata' => [
                            'plan_id' => $planId,
                        ],
                    ]);
                    $plan = \Stripe\Plan::create([
                        'amount' => $priceCents,
                        'currency' => 'gbp',
                        'metadata' => [
                            'plan_id' => $planId,
                        ],
                        'interval' => $intervalUnit,
                        'product' => $product->id,
                    ]);

                    $userSubscription = UserSubscription::where('user_id', $user->id)->first();
                    $subscription = \Stripe\Subscription::retrieve($userSubscription->subscription_id,);
                    $updatedSubscription = \Stripe\Subscription::update($userSubscription->subscription_id, [

                        'items' => [
                            [
                                'id' => $subscription->items->data[0]->id,
                                'plan' => $plan->id,
                            ],
                        ],
                        'expand' => ['latest_invoice.payment_intent'],
                    ]);
                    $currentPeriodStart = $updatedSubscription->current_period_start;
                    $currentPeriodEnd = $updatedSubscription->current_period_end;


                    $userSubscription = UserSubscription::where('user_id', $user->id)->first();
                    $userSubscription->update([
                        'next_plan_id' => $planId,
                        'upgrade_subscription_id' => $subscription->items->data[0]->id,
                        'start_date' => date('Y-m-d H:i:s', $currentPeriodStart),
                        'end_date' => date('Y-m-d H:i:s', $currentPeriodEnd)
                    ]);

                    $userSubscription->update([
                        'next_plan_id' => $planId, 'upgrade_subscription_id' => $subscription->items->data[0]->id, 'start_date' => date('Y-m-d H:i:s', $currentPeriodStart),
                        'end_date' => date('Y-m-d H:i:s', $currentPeriodEnd)
                    ]);


                    $user->update([
                        'upgrade_plan_id' => $planId,
                        'upgrade_status' => 'initiated',
                        'upgrade_plan_payment_id' => $paymentMethod,
                    ]);
                    \Stripe\Customer::update(
                        $customer->id,
                        [
                            'invoice_settings' => [
                                'default_payment_method' => $paymentMethod,
                            ],
                        ]
                    );
                    $invoice = \Stripe\Invoice::create([
                        'customer' => $customer->id,
                        'subscription' => $updatedSubscription->id,
                        // 'auto_advance' => true, 
                        'default_payment_method' => $paymentMethod,
                    ]);
                    $invoice->finalizeInvoice();
                    $paymentIntent = \Stripe\PaymentIntent::retrieve($invoice->payment_intent);
                    $paymentIntent->confirm();
                    return response()->json([
                        'status' => true,
                        'message' => "Subscription upgrade initiated. New plan will be added within 4-5 days.",
                    ], 200);
                } else if ($planPrice < $userPlan->price) {

                    $product = \Stripe\Product::create([
                        'name' => $planName,
                        'metadata' => [
                            'plan_id' => $planId,
                        ],
                    ]);
                    $plan = \Stripe\Plan::create([
                        'amount' => $priceCents,
                        'currency' => 'gbp',
                        'metadata' => [
                            'plan_id' => $planId,
                        ],
                        'interval' => $intervalUnit,
                        'product' => $product->id,
                    ]);
                    $subscriptionSchedule = \Stripe\SubscriptionSchedule::create([
                        'customer' => $user->gc_customer_id,
                        'start_date' => $subscription->current_period_end,
                        'phases' => [
                            [
                                'items' => [
                                    [
                                        'plan' => $plan->id,
                                    ],
                                ],
                            ],
                        ],

                    ]);
                    $subscriptionScheduleId = $subscriptionSchedule->id;
                    $currentPeriodStart = $subscription->current_period_start;
                    $currentPeriodEnd = $subscription->current_period_end;

                    $userSubscription->update([
                        'next_plan_id' => $planId,
                        'start_date' => date('Y-m-d H:i:s', $currentPeriodStart),
                        'end_date' => date('Y-m-d H:i:s', $currentPeriodEnd),
                        'upgrade_subscription_id' => $subscriptionScheduleId,
                    ]);
                    $user->update([
                        'upgrade_status' => 'initiated',
                        'subscription_status' => 'active',
                        'upgrade_plan_id' => $planId,
                    ]);

                    return response()->json([
                        'status' => true,
                        'message' => "Subscription downgrade scheduled for the next billing cycle.",
                    ], 200);
                }
            }
           
            $customer = \Stripe\Customer::create([
                'payment_method' => $paymentMethod,
                'email' => auth()->user()->email,
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethod,
                ],
            ]);

            $product = \Stripe\Product::create([
                'name' => $planName,
                'metadata' => [
                    'plan_id' => $planId,
                ],
            ]);
            $plan = \Stripe\Plan::create([
                'amount' => $priceCents,
                'currency' => 'gbp',
                'metadata' => [
                    'plan_id' => $planId,
                ],
                'interval' => $intervalUnit,
                'product' => $product->id,
            ]);
            $subscription = \Stripe\Subscription::create([
                'customer' => $customer->id,
                'items' => [['plan' => $plan->id]],
                'expand' => ['latest_invoice.payment_intent'],
            ]);

          
            $currentPeriodStart = $subscription->current_period_start;
            $currentPeriodEnd = $subscription->current_period_end;
            $user->plan_id = $planId;
            $user->subscription_status = 'active';
            $user->gc_customer_id = $customer->id;
            $user->payment_id = $paymentMethod;
            $user->save();
            UserSubscription::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'plan_id' => $planId,
                    'subscription_status' => 'active',
                    'subscription_id' => $subscription->id,
                    'start_date' => date('Y-m-d H:i:s', $currentPeriodStart),
                    'end_date' => date('Y-m-d H:i:s', $currentPeriodEnd)
                ]
            );
            // $checkoutSessionOptions = [
            //     'payment_method_types' => ['card'],
            //     'line_items' => [
            //         [
            //             'price_data' => [
            //                 'currency' => 'gbp',
            //                 'product_data' => [
            //                     'name' => $planName,
            //                 ],
            //                 'unit_amount' => $priceCents,
            //             ],
            //             'quantity' => 1,
            //         ],
            //     ],
            //     'mode' => 'payment',
            //     'success_url' => env('APP_URL') . '/success?session_id={CHECKOUT_SESSION_ID}',
            //     'cancel_url' => env('APP_URL') . '/cancel',
            // ];
            
            // $checkoutSession = \Stripe\Checkout\Session::create($checkoutSessionOptions);
            return response()->json([
                'success' => true,
                'subscription' => $subscription,

            ]);
        } catch (ApiErrorException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function downloadInvoice($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $customer_id = $user->gc_customer_id;
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $invoices = \Stripe\Invoice::all(['customer' => $customer_id, 'limit' => 1, 'status' => 'paid']);
            $latestInvoice = $invoices->data[0];
            if (!$latestInvoice) {
                return response()->json(['error' => 'No paid invoices found for this user.'], 404);
            }
            return response()->json([
                'download_url' => $latestInvoice->invoice_pdf,
                'paid' => $latestInvoice->paid,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
