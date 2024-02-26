<?php

namespace App\Http\Controllers;

use \GoCardlessPro\Client;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Jobs\VerificationMail;
use App\Jobs\PaymentJob;
use Illuminate\Http\Request;

class GocardlessController extends Controller
{
    //
    public function buyplan(Request $request)
    {

        try {
            $input = $request->all();
            $client = new Client([
                'access_token' => $this->returnValues(),
                'environment' => config('service.gocardless.environment'),
            ]);
            if (!($request->input('user_name'))) {
                $user = Auth::user();
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
            $redirectFlow = $client->redirectFlows()->create([
                "params" => [
                    "session_token" => $session_token,
                    "success_redirect_url" => $redirect_url,
                    "prefilled_customer" => [
                        "given_name" => $name,
                        "family_name" => 'Test',
                        "email" => $email,
                        "postal_code" => ($user->current_postcode) ?? ''
                    ]
                ]
            ]);
            // $data = [
            //     'email' => $user->email,
            //     'url' => $url,
            // ];
            // dispatch(new PaymentJob($user));
            return redirect($redirectFlow->redirect_url);
            // $param = [
            //     "email" => $email,
            //     'family_name' => "Xyz",
            //     "given_name" =>  $name,
            //     "country_code" => "GB",
            //     "metadata" => [
            //         'plan_id' => $input['id'],
            //     ]
            // ];
            // $customer = $client->customers()->create([
            //     "params" => $param
            // ]);
            // if ($customer->id) {
            //     $user->update([
            //         'gc_customer_id' => $customer->id,
            //     ]);
            // }
            // if (GoCardless::$environment == 'sandbox') {
            //     $account_details = array(
            //         'app_id'        => 'INSERT_LIVE_APP_ID',
            //         'app_secret'    => 'INSERT_LIVE_APP_SECRET',
            //         'merchant_id'   => 'INSERT_LIVE_MERCHANT_ID',
            //         'access_token'  => 'INSERT_LIVE_MERCHANT_ACCESS_TOKEN'
            //     );
            // } else {
            //     $account_details = array(
            //         'app_id'        => 'INSERT_SANDBOX_APP_ID',
            //         'app_secret'    => 'INSERT_SANDBOX_APP_SECRET',
            //         'merchant_id'   => 'INSERT_SANDBOX_MERCHANT_ID',
            //         'access_token'  => config('services.gocardless.environment'),
            //     );
            // }
            // // Initialize GoCardless
            // GoCardless::set_account_details($account_details);
            // $subscription_details = array(
            //     'amount' => $input['price'],
            //     'interval_length' => 1,
            //     'interval_unit' => 'month'
            // );
            // // Generate the url
            // $subscription_url = GoCardless::new_subscription_url($subscription_details);
            // dd($subscription_url);
            // $client->billingRequests()->create([
            //     "params" => [
            //         "metadata" => [
            //             "email" => $customer->email,
            //             "given_name" => $customer->given_name,
            //             "family_name" => $customer->family_name,
            //         ],
            //         "links" => [
            //             "customer" => $customer->id,
            //         ],
            //         "mandate_request" => [
            //             "scheme" => "ach"
            //         ]
            //     ]
            // ]);
            // $client->billingRequestFlows()->create([
            //     "params" => [
            //         "redirect_uri" => "http://127.0.0.1:8000/success",
            //         "exit_uri" => "http://127.0.0.1:8000/company/buy/plans/view/1",
            //         "links" => [
            //             "billing_request" => "BRQ0005QNSRJ8QG"
            //         ]
            //     ]
            // ]);
            // if (config('services.gocardless.environment') == 'sandbox') {
            //     $url = "https://pay-sandbox.gocardless.com/";
            // } else {
            //     $url = "https://paygocardless.com/";
            // }
            // $url .= "AL0000JZ1JC7TK";
            // $data = [
            //     'email' => $user->email,
            //     'url' => $url,
            // ];
            // dispatch(new PaymentJob($data));
            // Create mandate link and sent on mail., 
            // check for webhook, when mandate will be created,
            //  you can attach subscription to this account. Till that time, 
            //  save this info in table and once mandate received, update status.
            // return response()->json([
            //     'status' => true,
            //     'message' => "Registation Successfully"
            // ], 200);
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
    }
    /**
     * function to return gocardless values
     */
    public function returnValues()
    {
        $access_token = config('services.gocardless.access_token');
        return $access_token;
    }
}
