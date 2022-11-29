<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ApiAuthController extends Controller 
{
    public function login(LoginRequest $request) 
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me !== null) 
        {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        // $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'user' => auth::user()
        ]);
    }

    public function logout(Request $request) 
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function checkToken() 
    {
        return response()->json([
            "authorized" => Auth::guard('api')->check(),
        ]);
    }
}