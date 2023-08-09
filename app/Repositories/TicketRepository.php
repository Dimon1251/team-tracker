<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository extends Repository
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }

 /*   public function assignUser($ticket_id, $assign, $assigned){
        Ticket::where('id', $ticket_id)->update([
            'assignee_user_id' => $assign,
            'assigned_user_id' => $assigned
        ]);
    }*/

}
