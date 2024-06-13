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
            $priceCents = $selected_plan->price * 100;
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
            $companyAddress = $user->company->address->city;
            $redirect_url = url('complete/redirect/flow/' . $user->id . '/' . $input['id'] . '/' . $session_token);
            $param = [
                "name" => $name,
                "email" => $email,
                'metadata' => [
                    'session_token' => $session_token,
                    'billing' =>  $companyAddress,
                ],
            ];
            //dd($param);
            // $redirectFlow = $this->stripeServices->createRedirectFlow($param);
            $checkoutSession = Session::create($checkoutSessionOptions);
            $data = [ 
                'email' => $user->email,
                'url' => $checkoutSession->url,
            ];
            dispatch(new PaymentJob($data));
            // $user->plan_id = $selected_plan->id;
            // $user->subscription_status = 'pending';
            // $user->save();
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
    //     public function createPaymentIntent(Request $request)
    // {
    //     try {
    //         Stripe::setApiKey(env('STRIPE_SECRET'));

    //         $input = $request->all();
    //         $user = Auth::user();
    //         $selected_plan = Plan::find($input['id']);

    //         $priceCents = $selected_plan->price * 100; 
    //         $checkoutSessionOptions = [
    //             'payment_method_types' => ['card'],
    //             'line_items' => [
    //                 [
    //                     'price_data' => [
    //                         'currency' => 'GBP',
    //                         'product_data' => [
    //                             'name' => $selected_plan->name,
    //                         ],
    //                         'unit_amount' => $priceCents,
    //                     ],
    //                     'quantity' => 1,
    //                 ],
    //             ],
    //             'mode' => 'payment',
    //             'success_url' => env('APP_URL') . '/success?session_id={CHECKOUT_SESSION_ID}',
    //             'cancel_url' => env('APP_URL') . '/cancel',
    //         ];
    //         $checkoutSession = Session::create($checkoutSessionOptions);

    //         $data = [
    //             'email' => $user->email,
    //             'url' => $checkoutSession->url,
    //         ];

    //         dispatch(new PaymentJob($data));
    //         $user->plan_id = $selected_plan->id;
    //         $user->subscription_status = 'pending';
    //         $user->save();
    //         return response()->json([
    //             'status' => true,
    //             'sessionId' => $checkoutSession->id,
    //             'url' => $checkoutSession->url,
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    public function completeRedirectFlow(Request $request)
    {
        // dd($request);
        $plan = Plan::find($request->planId);
        $user = User::find($request->userId);
        $params = [["session_token" => $request->session]];
        $redirect_flow_id = $request->redirect_flow_id;
        $params = ["session_token" => $request->session];
        $priceCents = $plan->price * 100;
        $redirectFlow = $this->stripeServices->completeRedirectFlow($redirect_flow_id, $params);
        $user->update(['mandate_id' => $redirectFlow->links->mandate, 'gc_customer_id' => $redirectFlow->links->customer, 'plan_id' => $request->planId]);
        $data = [
            "amount" => $priceCents,
            "currency" => "GBP",
            "name" => $plan->name,
            "interval_unit" => $plan->interval_unit,
            "interval" => $plan->interval,
            "metadata" => ['user_id' => strval($user->id)],
            "links" => ["mandate" => $user->mandate_id]
        ];
        $subscription = $this->stripeServices->createSubscription($data);
        return redirect($redirectFlow->confirmation_url);
    }
}
