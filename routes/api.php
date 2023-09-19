<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SprintController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('jwt.auth')->group(function () {

    Route::prefix('/users')->group(function () {

        Route::get('/index', [UserController::class, 'index']);
        Route::get('/{user_id}/add-to-team/{team_id}', [UserController::class, 'addToTeam']);
        Route::get('/{user_id}/remove-from-team/{team_id}', [UserController::class, 'removeFromTeam']);
        Route::get('/auth', [UserController::class, 'selfUser']);
        Route::get('/tickets', [TicketController::class, 'ticketsByUser']);

    });

    Route::prefix('/projects')->group(function () {

        Route::get('/index', [ProjectController::class, 'index']);
        Route::get('/{id}/show', [ProjectController::class, 'show']);
        Route::post('/create', [ProjectController::class, 'create']);
        Route::post('/{id}/update', [ProjectController::class, 'update']);
        Route::get('/{id}/destroy', [ProjectController::class, 'destroy']);
        Route::get('/{id}/users', [UserController::class, 'usersByProject']);
        Route::get('/{id}/teams', [TeamController::class, 'teamsByProject']);
        Route::get('/{id}/add-team/{team_id}', [ProjectController::class, 'addTeam']);
        Route::get('/{id}/remove-team/{team_id}', [ProjectController::class, 'removeTeam']);

    });

    Route::prefix('/sprints')->group(function () {

        Route::get('/{id}/tickets', [TicketController::class, 'ticketsBySprint']);
        Route::get('/index', [SprintController::class, 'index']);
        Route::get('/{id}/show', [SprintController::class, 'show']);
        Route::post('/create', [SprintController::class, 'create']);
        Route::post('/{id}/update', [SprintController::class, 'update']);
        Route::get('/{id}/destroy', [SprintController::class, 'destroy']);

    });

    Route::prefix('/teams')->group(function () {

        Route::get('/index', [TeamController::class, 'index']);
        Route::get('/{id}/show', [TeamController::class, 'show']);
        Route::post('/create', [TeamController::class, 'create']);
        Route::post('/{id}/update', [TeamController::class, 'update']);
        Route::get('/{id}/destroy', [TeamController::class, 'destroy']);
        Route::get('/{id}/users', [TeamController::class, 'usersByTeams']);

    });

    Route::prefix('/tickets')->group(function () {

        Route::get('/index', [TicketController::class, 'index']);
        Route::get('/{id}/show', [TicketController::class, 'show']);
        Route::post('/create', [TicketController::class, 'create']);
        Route::post('/update', [TicketController::class, 'update']);
        Route::get('/{id}/destroy', [TicketController::class, 'destroy']);

    });

});
