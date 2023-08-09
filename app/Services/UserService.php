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

    public function create($data){
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

}
