<?php

namespace App\Http\Controllers;

use App\Dto\Game\GameEditInputDto;
use App\Dto\Game\GameInputDto;
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

    public function edit($id)
    {
        $gameService = new GameService();
        $game = $gameService->findById($id);
        if (!$game) redirect()->route('games.index');
        return view('games.edit', ['game' => $game]);
    }

    public function update(Request $request, $id)
    {

        $gameService = new GameService();
        $inputs = $request->only(['game_id', 'date', 'limit_players']);
        $inputDto = new GameEditInputDto($inputs['date'], $inputs['limit_players'], $inputs['game_id']);
        $gamePlayerService = new GamePlayerService();
        $gamePlayerService->cleanTeamByGameId($id);
        $gameService->update($id, $inputDto);

        return redirect()->route('games.index');
    }

    public function store(Request $request)
    {
        $inputRequest = $request->only(['date', 'limit_players']);
        $gameService = new GameService();
        $gameService->createGame(...$inputRequest);

        return redirect()->route('games.index');
    }

    public function delete($id)
    {
        $gameService = new GameService();
        $gameService->deleteGame($id);
        return redirect()->route('games.index');
    }
}
