<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
class AuthController extends Controller
{
    public function __construct(private readonly UserService $userService)
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials.',
            ]);
        }

        $token = JWTAuth::fromUser(Auth::user());
        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => [
                'Name' => $user->name,
                'Id' => $user->id,
            ],
        ]);

    }

    public function register(Request $request){
        $data = ['name' => 'Dima', 'email' => $request->email, 'password' => $request->password];
        $user = $this->userService->create($data);
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'status' => 'success',
            'token' => $token,
            'user' => [
                'Name' => $user->name,
                'Id' => $user->id,
            ],
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
