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
        return $this->teamRepository->all();
    }

    public function find($id){
        return $this->teamRepository->one($id);
    }

    public function create($data){
        $team = $this->teamRepository->create(['name' => $data['name'], 'user_creator' => $data['user_creator']]);
        $this->userRepository->update(['team_id' => $team->id], $data['user_id']);
    }

    public function update($data, $id){
        $this->teamRepository->update($data, $id);
    }

    public function delete($id){
        $this->teamRepository->delete($id);
    }

}
