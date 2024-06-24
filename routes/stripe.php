<?php

use App\Http\Controllers\StripewebhookController;
use App\Http\Controllers\WebhookController;

// use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::match(['get', 'post'], '/stripe-webhook', [StripewebhookController::class, 'handleWebhook']);
// till now you have not even created route