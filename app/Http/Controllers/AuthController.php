<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
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



    public function login(UserLoginRequest $request)
    {
        if (!Auth::attempt($request->toArray())) {
            return response()->json([
                'message' => 'Invalid credentials.',
            ], 422);
        }

        $token = JWTAuth::fromUser(Auth::user());
        $user = Auth::user();
        return response()->json([
            'status' => true,
            'token' => $token,
            'user' => [
                'Name' => $user->name,
                'Id' => $user->id,
            ],
        ], 200);

    }

    public function register(UserRegisterRequest $request){
        $user = $this->userService->create($request->except('password_confirmation'));
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'token' => $token,
            'user' => [
                'Name' => $user->name,
                'Id' => $user->id,
            ],
        ], 200);
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
