<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Requests\API\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
// return $data;
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return (new UserResource($user))->additional([
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return response()->json([
               $e->getMessage()
            ], 401);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credential = $request->validated();
            if (auth()->attempt($credential)) {
                $user = auth()->user();
                return (new UserResource($user))->additional([
                    'token' => $user->createToken('auth_token')->plainTextToken
                ]);
            }
            return response()->json([
                'message' => 'credential is not match'
            ], 401);
        } catch (\Exception $e) {
            $error = Log::error($e->getMessage(), [
                'line' => __LINE__,
                'file' => __File__
            ]);
            return response()->json($error, 401);
        }
    }

    public function profile()
    {
        try {
            $user = Auth::guard('sanctum')->user();
            return new UserResource($user);
        } catch (AuthorizationException $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ];
    }
}
