<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;



class UserAddressController extends Controller
{
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
                'user_id' => 'required|exists:users,id',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:15',
                'country' => 'required|string|max:22',
                'latitude' => 'nullable|string|max:255',
                'longitude' => 'nullable|string|max:255',
                'address1' => 'required|string|max:255',
                'address2' => 'nullable|string|max:255',
                'county' => 'nullable|string|max:255',
            ]);

            UserAddress::upsert(
                ['user_id' => auth()->id()],
                [
                    'user_id' => $request->input('user_id'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'zip_code' => $request->input('zip_code'),
                    'country' => $request->input('country'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'address1' => $request->input('address1'),
                    'address2' => $request->input('address2'),
                    'county' => $request->input('county'),

                ]
            );

            // Retrieve the updated or inserted record
            $userAddress = UserAddress::where('user_id', $request->user_id)->first();

            return response()->json($userAddress, 201);
        } catch (\Exception $e) {
            // Handle validation errors or other exceptions
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
