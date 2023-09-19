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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::middleware('jwt.auth')->group(function () {

    Route::prefix('/users')->name('users.')->group(function () {

        Route::get('/index', [UserController::class, 'index'])->name('index'); //ready
        Route::post('/show', [UserController::class, 'show'])->name('show');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/destroy', [UserController::class, 'destroy'])->name('destroy');
        Route::get('/{user_id}/add-to-team/{team_id}', [UserController::class, 'addToTeam'])->name('addToTeam'); //ready
        Route::get('/{user_id}/remove-from-team/{team_id}', [UserController::class, 'removeFromTeam'])->name('removeFromTeam'); //ready
        Route::get('/auth', [UserController::class, 'selfUser'])->name('auth'); //ready
        Route::get('/tickets', [TicketController::class, 'ticketsByUser'])->name('tickets'); //ready

    });

    Route::prefix('/projects')->name('projects.')->group(function () {

        Route::get('/index', [ProjectController::class, 'index'])->name('index'); //ready
        Route::post('/show', [ProjectController::class, 'show'])->name('show');
        Route::post('/create', [ProjectController::class, 'create'])->name('create'); //ready
        Route::post('/update', [ProjectController::class, 'update'])->name('update');
        Route::post('/destroy', [ProjectController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/users', [UserController::class, 'usersByProject'])->name('users'); //ready
        Route::get('/{id}/teams', [TeamController::class, 'teamsByProject'])->name('teams'); //ready

        Route::get('/{id}/add-team/{team_id}', [ProjectController::class, 'addTeam']); //ready
        Route::get('/{id}/remove-team/{team_id}', [ProjectController::class, 'removeTeam']); //ready

    });

    Route::prefix('/sprints')->name('sprints.')->group(function () {

        Route::get('/{id}/tickets', [TicketController::class, 'ticketsBySprint'])->name('tickets'); //ready
        Route::get('/index', [SprintController::class, 'index'])->name('index');
        Route::post('/show', [SprintController::class, 'show'])->name('show');
        Route::post('/create', [SprintController::class, 'create'])->name('create'); //ready
        Route::post('/update', [SprintController::class, 'update'])->name('update');
        Route::post('/destroy', [SprintController::class, 'destroy'])->name('destroy');

    });

    Route::prefix('/teams')->name('teams.')->group(function () {

        Route::get('/index', [TeamController::class, 'index'])->name('index'); //ready
        Route::post('/show', [TeamController::class, 'show'])->name('show');
        Route::post('/create', [TeamController::class, 'create'])->name('create');  //ready
        Route::post('/{id}/update', [TeamController::class, 'update'])->name('update'); //ready
        Route::get('/{id}/delete', [TeamController::class, 'destroy'])->name('destroy'); //ready
        Route::get('/{id}/users', [TeamController::class, 'usersByTeams'])->name('users');

    });

    Route::prefix('/tickets')->name('ticket.')->group(function () {

        Route::get('/index', [TicketController::class, 'index'])->name('index');
        //Route::post('/index-sprint', [TicketController::class, 'indexBySprint'])->name('indexBySprint');
        Route::post('/show', [TicketController::class, 'show'])->name('show');
        Route::post('/create', [TicketController::class, 'create'])->name('create'); //ready
        Route::post('/update', [TicketController::class, 'update'])->name('update'); //ready
        Route::post('/destroy', [TicketController::class, 'destroy'])->name('destroy');

    });


});
