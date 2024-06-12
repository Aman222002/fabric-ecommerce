<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use GoCardlessPro\Client;

class GoCardlessServices
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'access_token' => config('services.gocardless.access_token'),
            'environment' => config('services.gocardless.environment')
        ]);
    }
    public function creatRedirectFlow($param)
    {
        $redirectFlow = $this->client->redirectFlows()->create([
            "params" => $param
        ]);

        return $redirectFlow;
    }
    public function completeRedirectFlow($redirecFlowId, $params)
    {
        // dd($data);
        $redirectFlow = $this->client->redirectFlows()->complete(
            $redirecFlowId,
            ["params" => $params],
        );
        return  $redirectFlow;
    }
    public function createSubscription($data)
    {
        $subscription = $this->client->subscriptions()->create([
            "params" => $data,
        ]);
        return $subscription;
    }
    public function removeSubscription($data)
    {
        // dd($data);
        $this->client->subscriptions()->cancel($data);
    }
}
