<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSprintRequest;
use App\Http\Requests\UpdateSprintRequest;
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

    public function show($id){
        $sprint = $this->sprintService->find($id);
        return response()->json([
            'Sprint' => $sprint,
        ]);
    }

    public function create(CreateSprintRequest $request){
        $this->sprintService->create($request->validated());
    }

    public function update(UpdateSprintRequest $request, $id){
        $this->sprintService->update($request->validated(), $id);
    }

    public function destroy($id){
        $this->sprintService->delete($id);
    }
}
