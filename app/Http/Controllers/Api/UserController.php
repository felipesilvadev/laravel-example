<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Exception;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show(User $user_id)
    {
        $address = $user_id->address()->first();
        $posts = $user_id->posts()->get();

        if($address || $posts) {
            return response()->json(['user' => $user_id, 'address' => $address, 'posts' => $posts]);
        }

        return response()->json($user_id);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            return response()->json($user, 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, User $user_id)
    {
        try {
            $user_id->name = $request->input('name');
            $user_id->email = $request->input('email');
            if(!empty($request->input(('password')))) {
                $user_id->password = Hash::make($request->input('password'));
            }

            $user_id->save();

            return response()->json($user_id, 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    public function destroy(User $user_id)
    {
        $user_id->delete();

        return response()->json('',204);
    }
}
