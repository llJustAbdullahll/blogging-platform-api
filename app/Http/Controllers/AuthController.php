<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginReqeust;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {

        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json([
            'message' => 'Successfully Registered',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'token' => $token
        ], 201);

    }

    public function login(LoginReqeust $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login Successful.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ],
                'token' => $token  
            ], 200);
        } 
        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);
    }

    public function logout(Request $request) : JsonResponse
    {
        // Revoke the user's current access token
        if($request->user()->currentAccessToken()->delete()){
            return response()->json(['message' => 'User logged out successfully']);
        }

        // If logout fails, return an error response
        return response()->json([
            'message' => 'Failed to logout. Please try again.'
        ], 500);       
    }
}
