<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository extends Repository
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

}
