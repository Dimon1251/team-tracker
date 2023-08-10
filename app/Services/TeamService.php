<?php

namespace App\Services;

use App\Repositories\TeamRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TeamService
{

    public function __construct(private readonly TeamRepository $teamRepository)
    {
    }

    public function all(){
        return $this->teamRepository->all();
    }

    public function find($id){
        return $this->teamRepository->one($id);
    }

    public function create($data){
        $this->teamRepository->create($data);
    }

    public function update($data, $id){
        $this->teamRepository->update($data, $id);
    }

    public function delete($id){
        $this->teamRepository->delete($id);
    }

}
