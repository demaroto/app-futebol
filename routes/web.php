<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GamePlayerController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\PlayersController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;


Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/auth', [SessionController::class, 'store'])->name('auth');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::get('/register', [AuthController::class, 'create'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register-store');

Route::middleware(['auth'])->group(function(){
    
    Route::group(['prefix' => 'players'], function(){
        Route::get('/', [PlayersController::class, 'index'])->name('players.index');
        Route::get('/{id}', [PlayersController::class, 'view'])->name('players.view');
        Route::get('/{id}/edit', [PlayersController::class, 'edit'])->name('players.edit');
        Route::put('/{id}', [PlayersController::class, 'update'])->name('players.update');
    });
    
    Route::group(['prefix' => 'games'], function(){
        Route::get('/', [GamesController::class, 'index'])->name('games.index');
        Route::get('/create', [GamesController::class, 'create'])->name('games.create');
        Route::get('/{id}/edit', [GamesController::class, 'edit'])->name('games.edit');
        Route::delete('/{id}', [GamesController::class, 'delete'])->name('games.delete');
        Route::put('/{id}', [GamesController::class, 'update'])->name('games.update');
        Route::post('/store', [GamesController::class, 'store'])->name('games.store');
    });

    Route::group(['prefix' => 'game-player'], function(){
        Route::put('/{id}/update', [GamePlayerController::class, 'update'])->name('gamePlayer.update');
        Route::post('/store', [GamePlayerController::class, 'store'])->name('gamePlayer.store');
    });
});

Route::get('/', function(){
    return view('home');
})->name('home');

