<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TicketService
{

    public function __construct(private readonly TicketRepository $ticketRepository)
    {
    }

}
