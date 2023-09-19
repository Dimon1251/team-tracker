<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;

class ProjectRepository extends Repository
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function allByUser($id){
        $teams = User::where('id', $id)->first()->teams;
        $projects = [];
        foreach ($teams as $team){
            $projects[] = $team->projects;
        }
        $uniqueElements = collect($projects)
            ->flatten()
            ->unique('id')
            ->values();
        return $uniqueElements->all();
    }

    public function addTeam($id, $team_id){
        $project = Project::find($id);
        if (!$project->teams->contains($team_id)) {
            $project->teams()->attach($team_id);
        }
    }

    public function removeTeam($id, $team_id){
        Project::find($id)->teams()->detach($team_id);
    }

}
