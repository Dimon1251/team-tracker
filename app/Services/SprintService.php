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

}
