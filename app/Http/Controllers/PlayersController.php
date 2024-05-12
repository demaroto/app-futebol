<?php

namespace App\Http\Controllers;

use App\Dto\Player\PlayerEditInputDto;
use App\Services\GameService;
use App\Services\PlayerService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PlayersController extends Controller
{
    public function index()
    {
        $players = new PlayerService();
        
        return view('players.index', ['players' => $players->listPlayers()]);
    }

    public function view($id)
    {
        $playerService = new PlayerService();
        $player = $playerService->findOnePlayer($id);
        return view('players.view', ['player' => $player]);
    }

    public function edit($id)
    {
        $playerService = new PlayerService();
        $gameService = new GameService();
        $player = $playerService->findOnePlayer($id);
        $nextGame = $gameService->next();
        
        $gamePlayer = count($nextGame) ? array_filter($nextGame->gamePlayers->toArray(), fn($q) => $q['player_id'] == $id) : [];
        $gamePlayer = count($gamePlayer) ? array_values($gamePlayer) : [];
           
        return view('players.edit', ['player' => $player, 'gamePlayer' => $gamePlayer, 'game' => $nextGame]);
    }

    public function update(Request $request, $id)
    {
        
        $goalkeeper = $request->goalkeeper === 'on' ? true : false;
        $dto = new PlayerEditInputDto($id, $request->level, $goalkeeper);
        $playerService = new PlayerService();
        $playerService->editPlayer($dto);

        return redirect()->route('players.edit', $id);
    }
}
