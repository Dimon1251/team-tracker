<?php

namespace App\Services;

use App\Repositories\TeamRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TeamService
{

    public function __construct(private readonly TeamRepository $teamRepository,
                                private readonly UserRepository $userRepository)
    {
    }

    public function all(){
        $teams = $this->teamRepository->allByUser(Auth::id());
        foreach ($teams as $team){
            if ($team->user_creator == Auth::id()){
                $team->status = "owner";
            } else {
                $team->status = "member";
            }
        }
        return $teams;
    }

    public function usersByTeams($id){
        return $this->teamRepository->usersNotInTeam($id);
    }

    public function teamsByProject($id){
        return $this->teamRepository->teamsByProject($id);
    }

    public function find($id){
        return $this->teamRepository->one($id);
    }

    public function create($data){
        $data['user_creator'] = Auth::id();
        $team = $this->teamRepository->create($data);
        $team->users()->attach($data['user_creator']);
    }

    public function update($data, $id){
        $this->teamRepository->update($data, $id);
    }

    public function delete($id){
        $this->teamRepository->delete($id);
    }

}
