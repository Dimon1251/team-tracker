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

    Route::prefix('/user')->name('user.')->group(function () {

        Route::get('/index', [UserController::class, 'index'])->name('index');
        Route::post('/show', [UserController::class, 'show'])->name('show');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/destroy', [UserController::class, 'destroy'])->name('destroy');
        Route::post('/addToTeam', [UserController::class, 'addToTeam'])->name('addToTeam'); //ready
        Route::post('/removeFromTeam', [UserController::class, 'removeFromTeam'])->name('removeFromTeam'); //ready
        Route::get('/auth', [UserController::class, 'selfUser'])->name('auth');

    });

    Route::prefix('/project')->name('project.')->group(function () {

        Route::get('/index', [ProjectController::class, 'index'])->name('index');
        Route::post('/show', [ProjectController::class, 'show'])->name('show');
        Route::post('/create', [ProjectController::class, 'create'])->name('create');
        Route::post('/update', [ProjectController::class, 'update'])->name('update');
        Route::post('/destroy', [ProjectController::class, 'destroy'])->name('destroy');

    });

    Route::prefix('/sprint')->name('sprint.')->group(function () {

        Route::get('/index', [SprintController::class, 'index'])->name('index');
        Route::post('/show', [SprintController::class, 'show'])->name('show');
        Route::post('/create', [SprintController::class, 'create'])->name('create');
        Route::post('/update', [SprintController::class, 'update'])->name('update');
        Route::post('/destroy', [SprintController::class, 'destroy'])->name('destroy');

    });

    Route::prefix('/team')->name('team.')->group(function () {

        Route::get('/index', [TeamController::class, 'index'])->name('index');
        Route::post('/show', [TeamController::class, 'show'])->name('show'); //ready
        Route::post('/create', [TeamController::class, 'create'])->name('create');  //ready
        Route::post('/update', [TeamController::class, 'update'])->name('update');  //ready
        Route::post('/destroy', [TeamController::class, 'destroy'])->name('destroy'); //ready

    });

    Route::prefix('/ticket')->name('ticket.')->group(function () {

        Route::get('/index', [TicketController::class, 'index'])->name('index');
        Route::post('/show', [TicketController::class, 'show'])->name('show');
        Route::post('/create', [TicketController::class, 'create'])->name('create');
        Route::post('/update', [TicketController::class, 'update'])->name('update');
        Route::post('/destroy', [TicketController::class, 'destroy'])->name('destroy');

    });


});
