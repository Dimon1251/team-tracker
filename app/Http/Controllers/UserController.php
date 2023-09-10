<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(private readonly UserService $userService){}

    public function index(){
        $users = $this->userService->all();
        return response()->json([
            'Users' => $users,
        ]);
    }

    public function show(Request $request){
        $user = $this->userService->find($request->id);
        return response()->json([
            'User' => $user,
        ]);
    }

    public function update(Request $request){
        $this->userService->update($request->toArray(), $request->id);
    }

    public function destroy(Request $request){
        $this->userService->delete($request->id);
    }

    public function addToTeam($user_id, $team_id){
        $this->userService->addToTeam($user_id, $team_id);
    }

    public function removeFromTeam($user_id, $team_id){
        $this->userService->removeFromTeam($user_id, $team_id);
    }

    public function selfUser(){
        $user = $this->userService->find(Auth::id());
        return response()->json([
            'User' => $user,
        ]);
    }
}
