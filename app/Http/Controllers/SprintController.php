<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSprintRequest;
use App\Services\SprintService;
use App\Services\TicketService;
use Illuminate\Http\Request;

class SprintController extends Controller
{
    public function __construct(private readonly SprintService $sprintService){}

    public function index(){
        $sprints = $this->sprintService->all();
        return response()->json([
            'Projects' => $sprints,
        ]);
    }

    public function show(Request $request){
        $sprint = $this->sprintService->find($request->id);
        return response()->json([
            'Sprint' => $sprint,
        ]);
    }

    public function create(CreateSprintRequest $request){
        $this->sprintService->create($request->validated());
    }

    public function update(Request $request){
        $this->sprintService->update($request->toArray(), $request->id);
    }

    public function destroy(Request $request){
        $this->sprintService->delete($request->id);
    }
}
