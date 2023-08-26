<?php

namespace App\Repositories;

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

}
