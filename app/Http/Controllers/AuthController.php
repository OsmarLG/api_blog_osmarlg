<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    //
    public function loginForm() {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {        
        $response = Http::post('http://api_blog_osmarlg.test/api/auth/login', [
            'username' => $request->username,
            'password' => $request->password,
        ]);

        if ($response->successful()) {
            $token = $response->json('token');
            $role = $response->json('user.role');
            $userId = $response->json('user.id');

            return response()->json([
                'token' => $token,
                'role' => $role,
                'userId' => $userId
            ]);
        } else {
            return response()->json(['message' => $response->json('message')], 401);
        }
    }

    public function register() {
        return view('auth.register');
    }
    
    public function registerWeb(Request $request) {
        $response = Http::post('http://api_blog_osmarlg.test/api/auth/register', [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
            'phone' => $request->phone,
        ]);

        if ($response->successful()) {
            return response()->json([
                'message' => 'Wait for activation',
            ]);
        } else {
            return response()->json(['message' => $response->json('message')], 401);
        }
    }

    public function logout(Request $request)
    {
        $csrfToken = $request->header('X-CSRF-TOKEN');
        $token = $request->header('Authorization');

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'X-CSRF-TOKEN' => $csrfToken
        ])->post('http://api_blog_osmarlg.test/api/auth/logout');

        if ($response->successful()) {
            return response()->json(['message' => 'Logged out successfully'], 200);
        } else {
            return response()->json(['message' => 'Error during logout'], 500);
        }
    }
}
