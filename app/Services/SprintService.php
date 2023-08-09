<?php

namespace App\Services;

use App\Repositories\SprintRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SprintService
{

    public function __construct(private readonly SprintRepository $sprintRepository)
    {
    }

    public function all(){
        return $this->sprintRepository->all();
    }

    public function find($id){
        return $this->sprintRepository->one($id);
    }

    public function create($data){
        $this->sprintRepository->create($data);
    }

    public function update($data, $id){
        $this->sprintRepository->update($data, $id);
    }

    public function delete($id){
        $this->sprintRepository->delete($id);
    }

}
