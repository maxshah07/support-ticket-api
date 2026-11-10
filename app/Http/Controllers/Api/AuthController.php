<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validate email and password
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        // 2. Find the user by email
        $user = User::where('email', $validated['email'])->first(); 
        //first() will return the first record that matches the query or null if no record is found.

        // 3. Check if the user exists and password matches
        // If invalid, return JSON with HTTP 401
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        // 4. Generate a Sanctum token
        $token = $user->createToken('api-token')->plainTextToken;

        // 5. Return the token as JSON
        return response()->json([
            'token' => $token
        ]);
    }

    public function me(Request $request) {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        // 1. Retrieve the token used for this request
        $token = $request->user()->currentAccessToken();

        // 2. Revoke (delete) that token
        $token->delete();

        // 3. Return a JSON success message
        return response()->json([
            'message' => 'Logged out sucessfully'
        ]);
    }
}