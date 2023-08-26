<?php

namespace App\Repositories;

use App\Models\Team;
use App\Models\User;

class UserRepository extends Repository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function addToTeam($user_id, $team_id){
        Team::where('id', $team_id)->first()->users()->attach($user_id);
    }

    public function removeFromTeam($user_id, $team_id){
        Team::where('id', $team_id)->first()->users()->detach($user_id);

    }

}
