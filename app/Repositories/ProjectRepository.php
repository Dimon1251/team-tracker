<?php

namespace App\Repositories;

use App\Models\Project;
use App\Models\User;

class ProjectRepository extends Repository
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function allByUser($id){
        $teams = User::where('id', $id)->first()->teams;
        $projects = [];
        foreach ($teams as $team){
            $projects[] = $team->projects;
        }
        $uniqueElements = collect($projects)
            ->flatten() // Преобразовать в одномерный массив
            ->unique('id')   // Удалить повторяющиеся элементы
            ->values();   // Переиндексировать массив
        return $uniqueElements->all();
    }

}
