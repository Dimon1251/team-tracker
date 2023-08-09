<?php

namespace App\Repositories;

use App\Models\Sprint;

class SprintRepository extends Repository
{
    public function __construct(Sprint $model)
    {
        parent::__construct($model);
    }

}
