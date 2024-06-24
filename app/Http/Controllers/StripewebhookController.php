<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Event;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Webhook;
use Illuminate\Support\Facades\Log;

class StripewebhookController extends Controller
{
  public function handleWebhook(Request $request)
  {
    $payload = $request->getContent();
    $signature = $request->header('Stripe-Signature');
    $secret = env('STRIPE_WEBHOOK');
    $event = null;

    try {
      $event = Webhook::constructEvent(
        $payload,
        $signature,
        $secret
      );

      switch ($event->type) {
        case 'customer.created':
          $customer = $event->data->object;
          break;
        case 'customer.subscription.created':
          $subscription = $event->data->object;
          break;
        case 'customer.subscription.deleted':
          $subscription = $event->data->object;
          break;
        case 'customer.subscription.updated':
          $subscription = $event->data->object;
          break;
        case 'payment_method.attached':
          $paymentMethod = $event->data->object;
          break;
        case 'subscription_schedule.created':
          $subscription = $event->data->object;
        case 'plan.created':
          $plan = $event->data->object;
          break;
        case 'invoice.payment_failed':
          $invoice = $event->data->object;

          $this->handlePaymentFailure($invoice);
          break;
      }
      return response('Webhook handled successfully', 200);
    } catch (\Exception $e) {
      Log::error('Webhook signature verification failed: ' . $e->getMessage(), [
        'payload' => $payload,
        'signature' => $signature,
      ]);
      return response()->json(['error' => 'Invalid signature'], 400);
    } catch (\Exception $e) {
      Log::error('Error handling webhook: ' . $e->getMessage());
      return response()->json(['error' => 'Error handling webhook'], 500);
    }
  }
  protected function handlePaymentFailure($invoice)
  {
    $customer = $invoice->customer;
    $subscription = $invoice->subscription;
    Log::info('Payment failed for invoice: ' . $invoice->id, [
      'customer_id' => $customer,
      'subscription_id' => $subscription,
    ]);
  }
}
