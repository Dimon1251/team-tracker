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

}
