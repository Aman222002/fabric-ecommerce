<?php

namespace App\Services;

use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Subscription;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use Illuminate\Support\Facades\Log;
class StripeServices
{
    protected $stripe;
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }
    public function createCustomer($email, $paymentMethod)
    {
        try {
            $customer = Customer::create([
                'email' => $email,
                'payment_method' => $paymentMethod,
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethod,
                ],
            ]);
            return $customer;
        } catch (ApiErrorException $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            throw $e;
        }
    }
    public function createPaymentIntent($amount, $currency, $customer)
    {
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'customer' => $customer,
            ]);
            return $paymentIntent;
        } catch (ApiErrorException $e) {
        
            Log::error('Stripe Error: ' . $e->getMessage());
            throw $e;
        }
    }
    public function createRedirectFlow($param)
    {
        $redirectFlow = \Stripe\Issuing\Cardholder::create($param);
        return $redirectFlow;
    }

    // public function completeRedirectFlow($redirecFlowId, $params)
    // {
    //     $redirectFlow = \Stripe\Issuing\Cardholder::update($redirecFlowId, $params);
    //     return $redirectFlow;
    // }
      public function completeRedirectFlow($redirecFlowId, $params)
    {
      
        $redirectFlow = $this->stripe->redirectFlows()->complete(
            $redirecFlowId,
            ["params" => $params],
        );
        return  $redirectFlow;
    }
    public function createSubscription($data)
    {
        $subscription = $this->stripe->subscriptions()->create([
            "params" => $data,
        ]);
        return $subscription;
    }
    public function cancelSubscription($subscriptionId)
    {
        try {
            $subscription = Subscription::retrieve($subscriptionId);
            $subscription->cancel();
        } catch (ApiErrorException $e) {
            Log::error('Stripe Error: ' . $e->getMessage());
            throw $e;
        }
    }
   
    // public function createRedirectFlow($param)
    // {
    //     $redirectFlow = $this->stripe->redirectFlows()->create([
    //         "params" => $param
    //     ]);

    //     return $redirectFlow;
    // }
    // public function completeRedirectFlow($redirecFlowId, $params)
    // {
      
    //     $redirectFlow = $this->stripe->redirectFlows()->complete(
    //         $redirecFlowId,
    //         ["params" => $params],
    //     );
    //     return  $redirectFlow;
    // }
 
}

