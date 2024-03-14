<?php

namespace App\Http\Controllers;

use \GoCardlessPro\Client;
use App\Models\Company;
use App\Services\GoCardlessServices;
use App\Models\User;
use App\Models\Plan;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Auth;
use App\Jobs\VerificationMail;
use App\Jobs\PaymentJob;
use Illuminate\Http\Request;

class GocardlessController extends Controller
{
    protected $gocardlessService;

    public function __construct(GoCardlessServices $gocardlessService)
    {
        $this->gocardlessService = $gocardlessService;
    }
    /**
     * function to buy plan and register user if not registered
     */
    public function buyplan(Request $request)
    {
        try {
            $input = $request->all();
            if (!($request->input('user_name'))) {
                $user = Auth::user();
                $selected_plan = Plan::find($input['id']);
                $user_plan = Plan::find($user->paln_id);
                $priceCents = $selected_plan->price * 100;
                if ($user->subscription_status == 'active') {
                    $data = [
                        "amount" => $priceCents,
                        "currency" => "USD",
                        "name" => $selected_plan->name,
                        "interval_unit" => $selected_plan->interval_unit,
                        "interval" => $selected_plan->interval,
                        "metadata" => ['user_id' => strval($user->id)],
                        "links" => ["mandate" => $user->mandate_id]
                    ];
                    if ($selected_plan->price > $user_plan->price) {
                        $user_subscription = UserSubscription::where('user_id', $user->id)->get();
                        $this->gocardlessService->removeSubscription($user_subscription->subscription_id);
                        $this->gocardlessService->createSubscription($data);
                        $user->update(['plan_id' => $input['id']]);
                        return response()->json([
                            'status' => true,
                            'message' => "Subscription Will be added soon in your account"
                        ], 200);
                    } else {
                        //handling case to downgrade the subscription
                        $users_subscription = UserSubscription::where('user_id', $user->id)->get();
                        $users_subscription->update(['next_plan_id' => $input['id']]);
                    }
                } else {
                    $email = $user->email;
                    $name = $user->name;
                    $session_token = md5(uniqid(rand(), true));
                    $redirect_url = url('complete/redirect/flow/' . $user->id . '/' . $input['id'] . '/' . $session_token);
                    $param = [
                        "session_token" => $session_token,
                        "success_redirect_url" => $redirect_url,
                        "prefilled_customer" =>  [
                            "given_name" => $name,
                            "family_name" => 'Test',
                            "email" => $email,
                        ]
                    ];
                    $redirectFlow = $this->gocardlessService->creatRedirectFlow($param);
                    $data = [
                        'email' => $user->email,
                        'url' => $redirectFlow->redirect_url,
                    ];
                    dispatch(new PaymentJob($data));
                    return response()->json([
                        'status' => true,
                        'message' => "Registation Successfully"
                    ], 200);
                }
            } else {
                $user = User::create([
                    'name' => $input['user_name'],
                    'email' => $input['email'],
                    'password' => $input['password'],
                    'phone' => $input['phone'],
                ]);
                $user->assignRole('Company Admin');
                dispatch(new VerificationMail($user->email));
            }
            if ($request->input('company_name')) {
                if ($request->input('company_email')) {
                    $company =  Company::create([
                        'user_id' =>  $user->id,
                        'company_name' => $input['company_name'],
                        'company_email' => $input['company_email'],
                    ]);
                }
            }
            $email = $user->email;
            $name = $user->name;
            $session_token = md5(uniqid(rand(), true));
            $redirect_url = url('complete/redirect/flow/' . $user->id . '/' . $input['id'] . '/' . $session_token);
            $param = [
                "session_token" => $session_token,
                "success_redirect_url" => $redirect_url,
                "prefilled_customer" =>  [
                    "given_name" => $name,
                    "family_name" => 'Test',
                    "email" => $email,
                ]
            ];
            $redirectFlow = $this->gocardlessService->creatRedirectFlow($param);
            $data = [
                'email' => $user->email,
                'url' => $redirectFlow->redirect_url,
            ];
            dispatch(new PaymentJob($data));
            return response()->json([
                'status' => true,
                'message' => "Registation Successfully"
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    /**
     *  When customer authorize gocardless then redirect to complete flow with Mandate ID and Customer ID
     */
    public function completeRedirectFlow(Request $request)
    {
        $plan = Plan::find($request->planId);
        $user = User::find($request->userId);
        $params = [["session_token" => $request->session]];
        $redirect_flow_id = $request->redirect_flow_id;
        $params = ["session_token" => $request->session];
        $priceCents = $plan->price * 100;
        $redirectFlow = $this->gocardlessService->completeRedirectFlow($redirect_flow_id, $params);
        $user->update(['mandate_id' => $redirectFlow->links->mandate, 'gc_customer_id' => $redirectFlow->links->customer, 'mandate_status' => 'pending', 'plan_id' => $request->planId]);
        $data = [
            "amount" => $priceCents,
            "currency" => "USD",
            "name" => $plan->name,
            "interval_unit" => $plan->interval_unit,
            "interval" => $plan->interval,
            "metadata" => ['user_id' => strval($user->id)],
            "links" => ["mandate" => $user->mandate_id]
        ];
        $subscription = $this->gocardlessService->createSubscription($data);
        // Create mandate link and sent on mail., 
        // check for webhook, when mandate will be created,
        //  you can attach subscription to this account. Till that time, 
        //  save this info in table and once mandate received, update status.
        return redirect($redirectFlow->confirmation_url);
    }
}
