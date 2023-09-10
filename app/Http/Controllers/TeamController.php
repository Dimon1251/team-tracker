<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Services\TeamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeamController extends Controller
{
    public function __construct(private readonly TeamService $teamService){}

    public function index(){
        $teams = $this->teamService->all();
        return response()->json([
            'Teams' => $teams,
        ]);
    }

  /*  public function show(Request $request){
        $team = $this->teamService->find($request->id);
        return response()->json([
            'Team' => $team,
        ]);
    }*/

    public function create(CreateTeamRequest $request){
        $this->teamService->create($request->validated());
    }

    public function update(UpdateTeamRequest $request, $id){
        $this->teamService->update($request->validated(), $id);
    }

    public function destroy($id){
        $this->teamService->delete($id);
    }
}
