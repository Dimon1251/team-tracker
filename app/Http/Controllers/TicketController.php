<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTicketRequest;
use App\Models\User;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    public function __construct(private readonly TicketService $ticketService){}

    public function index(){
        $tickets = $this->ticketService->all();
        return response()->json([
            'Tickets' => $tickets,
        ]);
    }

    public function ticketsBySprint($id){
        $tickets = $this->ticketService->allBySprint($id);
        return response()->json([
            'Tickets' => $tickets,
        ]);
    }

    public function show($id){
        $ticket = $this->ticketService->find($id);
        return response()->json([
            'Ticket' => $ticket,
        ]);
    }

    public function create(CreateTicketRequest $request){
        $this->ticketService->create($request->validated());
    }

    public function update(Request $request){
        foreach ($request->toArray() as $item){
            $this->ticketService->update($item, $item['id']);
        }
    }

    public function destroy($id){
        $this->ticketService->delete($id);
    }

    public function ticketsByUser(){
        $tickets = $this->ticketService->ticketsByUser(Auth::id());
        return response()->json([
            'Tickets' => $tickets,
        ]);
    }
}
