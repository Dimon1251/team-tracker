<?php

namespace App\Repositories;

use App\Models\Sprint;
use App\Models\Ticket;
use App\Models\User;

class TicketRepository extends Repository
{
    public function __construct(Ticket $model)
    {
        parent::__construct($model);
    }


    public function allBySprint($id){
        return Sprint::where('id', $id)->first()->tickets;
    }

    public function ticketsByUser($id){
        $teams = User::find($id)->teams;
        $tickets = [];
        foreach ($teams as $team) {
            $teamData = [
                'team' => $team->name,
                'projects' => [],
            ];
            foreach ($team->projects as $project) {
                $projectData = [
                    'project' => $project->name,
                    'sprints' => [],
                ];
                foreach ($project->sprints as $sprint) {
                    $sprintData = [
                        'sprint' => $sprint->name,
                        'tickets' => $sprint->tickets->filter(function ($ticket) use ($id) {
                            return $ticket->assigned_user_id === $id;
                        }),
                    ];
                    if (!empty($sprintData['tickets'])) {
                        $projectData['sprints'][] = $sprintData;
                    }
                }
                if (!empty($projectData['sprints'])) {
                    $teamData['projects'][] = $projectData;
                }
            }
            if (!empty($teamData['projects'])) {
                $tickets[] = $teamData;
            }
        }
        return $tickets;
    }

}
