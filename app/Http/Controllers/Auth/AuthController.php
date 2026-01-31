<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //registered user
    public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user
        ], 201);
    }

    //login user
    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // check if user exist in database
        $user = User::where('email', $request->email)->first(); // get objct user
        // dd($user);
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json([
                'message' => 'User is not authenticated'
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        // return user data and user's API/Bearer token
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ], 200);
    }

    // logout user
    public function logout(Request $request){

        $user = $request->user();
        // revoke all tokens
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }

    //me
    public function me(Request $request){

        $user = $request->user();

        return response()->json([
            'data' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]
        ], 200);
    }
}
