<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProjectService
{

    public function __construct(private readonly ProjectRepository $projectRepository)
    {
    }

    public function all(){
        return $this->projectRepository->allByUser(Auth::id());
    }

    public function find($id){
        return $this->projectRepository->one($id);
    }

    public function create($data){
        $project = $this->projectRepository->create(['name' => $data['name']]);
        foreach ($data['team_list'] as $team){
            $project->teams()->attach($team);
        }

    }

    public function update($data, $id){
        $this->projectRepository->update($data, $id);
    }

    public function delete($id){
        $this->projectRepository->delete($id);
    }

    public function addTeam($id, $team_id){
        $this->projectRepository->addTeam($id, $team_id);
    }

    public function removeTeam($id, $team_id){
        $this->projectRepository->removeTeam($id, $team_id);
    }

}
