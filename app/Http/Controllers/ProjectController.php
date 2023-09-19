<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(private readonly ProjectService $projectService){}

    public function index(){
        $projects = $this->projectService->all();
        return response()->json([
            'Projects' => $projects,
        ]);
    }

    public function show(Request $request){
        $project = $this->projectService->find($request->id);
        return response()->json([
            'Project' => $project,
        ]);
    }

    public function create(CreateProjectRequest $request){
        $this->projectService->create($request->validated());
    }

    public function update(Request $request){
        $this->projectService->update($request->toArray(), $request->id);
    }

    public function destroy(Request $request){
        $this->projectService->delete($request->id);
    }

    public function addTeam($id, $team_id){
        $this->projectService->addTeam($id, $team_id);
    }

    public function removeTeam($id, $team_id){
        $this->projectService->removeTeam($id, $team_id);
    }
}
