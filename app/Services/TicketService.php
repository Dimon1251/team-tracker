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

    public function all(){
        return $this->ticketRepository->all();
    }

    public function find($id){
        return $this->ticketRepository->one($id);
    }

    public function create($data){
        $this->ticketRepository->create($data);
    }

    public function update($data, $id){
        $data = collect($data)->except('id')->all();
        $this->ticketRepository->update($data, $id);
    }

    public function delete($id){
        $this->ticketRepository->delete($id);
    }

 /*   public function assignUser($ticket_id, $assign, $assigned){
        $this->ticketRepository->assignUser($ticket_id, $assign, $assigned);
    }*/

    public function allBySprint($id){
        return $this->ticketRepository->allBySprint($id);
    }

}
