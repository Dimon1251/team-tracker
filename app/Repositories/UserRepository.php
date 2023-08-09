<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function addToTeam($user_id, $team_id){
        User::where('id', $user_id)->update([
            'team_id' => $team_id
        ]);
    }

    public function removeFromTeam($user_id){
        User::where('id', $user_id)->update([
            'team_id' => null
        ]);
    }

}
