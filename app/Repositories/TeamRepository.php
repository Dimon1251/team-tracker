<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;

class TeamRepository extends Repository
{
    public function __construct(Team $model)
    {
        parent::__construct($model);
    }

    public function allByUser($id){
        return User::where('id', $id)->first()->teams;
    }

    public function usersNotInTeam($id){
        return User::whereDoesntHave('teams', function ($query) use ($id) {
            $query->where('team_id', $id);
        })->get();
    }

    public function teamsByProject($id){
        return Project::find($id)->teams;
    }

}
