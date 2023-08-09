<?php

namespace App\Http\Controllers;

use App\Services\TeamService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(private readonly TeamService $teamService){}

    public function index(){
        $teams = $this->teamService->all();
        return response()->json([
            'Teams' => $teams,
        ]);
    }

    public function show(Request $request){
        $team = $this->teamService->find($request->id);
        return response()->json([
            'Team' => $team,
        ]);
    }

    public function create(Request $request){
        $this->teamService->create($request->toArray());
    }

    public function update(Request $request){
        $this->teamService->update($request->toArray(), $request->id);
    }

    public function destroy(Request $request){
        $this->teamService->delete($request->id);
    }
}
