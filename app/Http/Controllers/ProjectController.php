<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
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

    public function show($id){
        $project = $this->projectService->find($id);
        return response()->json([
            'Project' => $project,
        ]);
    }

    public function create(CreateProjectRequest $request){
        $this->projectService->create($request->validated());
    }

    public function update(UpdateProjectRequest $request, $id){
        $this->projectService->update($request->validated(), $id);
    }

    public function destroy($id){
        $this->projectService->delete($id);
    }

    public function addTeam($id, $team_id){
        $this->projectService->addTeam($id, $team_id);
    }

    public function removeTeam($id, $team_id){
        $this->projectService->removeTeam($id, $team_id);
    }
}
