<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

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

    public function addToTeam(Request $request){
        $this->userService->addToTeam($request->user_id, $request->team_id);
    }

    public function removeFromTeam(Request $request){
        $this->userService->removeFromTeam($request->user_id);
    }
}
