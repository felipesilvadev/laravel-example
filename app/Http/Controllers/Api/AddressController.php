<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $address = Address::create($request->all());

        return response()->json($address, 201);
    }

    public function show(Address $address)
    {
        $user = $address->user()->first();

        if($address) {
            return response()->json(['user' => $user, 'address' => $address]);
        }
    }
}
