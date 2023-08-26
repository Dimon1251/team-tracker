<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserService
{

    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function all(){
        return $this->userRepository->all();
    }

    public function find($id){
        return $this->userRepository->one($id);
    }

    public function create($data){
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function update($data, $id){
        $this->userRepository->update($data, $id);
    }

    public function delete($id){
        $this->userRepository->delete($id);
    }

    public function addToTeam($user_id, $team_id){
        $this->userRepository->addToTeam($user_id, $team_id);
    }

    public function removeFromTeam($user_id, $team_id){
        $this->userRepository->removeFromTeam($user_id, $team_id);
    }

}
