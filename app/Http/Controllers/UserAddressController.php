<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Country;
use App\Models\UserAddress;
use Illuminate\Http\Request;



class UserAddressController extends Controller
{

    public function index()
    {
        $countries = Country::all();
        return response()->json(['countries' => $countries]);
    }
    // public function storeOrUpdate(Request $request)
    // {
    //     $request->validate([
    //         'street_address' => 'required|string',
    //         'city' => 'required|string',
    //         'state' => 'required|string',
    //         'zip_code' => 'required|string',
    //     ]);

    //     $user = UserAddress::updateOrCreate(
    //         ['user_id' => auth()->id()],
    //         [
    //             'street_address' => $request->input('street_address'),
    //             'city' => $request->input('city'),
    //             'state' => $request->input('state'),
    //             'zip_code' => $request->input('zip_code'),
    //         ]
    //     );
    // }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:15',
                'country' => 'required|string|max:22',
                'address1' => 'required|string|max:255',
            ]);
            // return $request->all();
            UserAddress::insert(
                // ['user_id' => auth()->id()],
                [
                    'user_id' => auth()->id(),
                    'address1' => $request->address1,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'country' => $request->country,
                    'latitude' => $request->latitude,
                    'longitude' => $request->longitude,
                    'address2' => $request->address2,
                    'county' => $request->county,
                ]
            );

            // Retrieve the updated or inserted record
            $userAddress = UserAddress::where('user_id', auth()->id())->first();

            return response()->json($userAddress, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
