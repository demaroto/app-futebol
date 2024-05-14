<?php

namespace App\Http\Controllers;

use App\Services\GamePlayerService;
use App\Services\GameService;
use App\Services\PlayerService;
use App\Services\TeamService;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    public function index()
    {
        $gameService = new GameService();
        $game = $gameService->next();
        $playerService = new PlayerService();
        $players = $playerService->getAll();
        $gamePlayerService = new GamePlayerService();
        $gamePlayer = $game ? $gamePlayerService->findByGameId($game->id) : [];
       if (count($gamePlayer)) 
            $gameService->checkPlayer($game->id);
       
        return view('games.index', [
            'game' => $game,
            'players' => $players,
            'gamePlayer' => $gamePlayer
        ]);
    }

    public function create()
    {
        return view('games.create');
    }

    public function store(Request $request)
    {
        $inputRequest = $request->only(['date', 'limit_players']);
        $gameService = new GameService();
        $gameService->createGame(...$inputRequest);

        return redirect()->route('home');
    }
}
