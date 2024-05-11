<?php

namespace App\Http\Controllers;

use App\Dto\GamePlayer\GamePlayerInputDto;
use App\Services\GamePlayerService;
use App\Services\GameService;
use Illuminate\Http\Request;

class GamePlayerController extends Controller
{
    public function update(Request $request, $id)
    {
        $inputRequest = $request->only(['id', 'player_id', 'game_id', 'confirmed', 'goals', 'team_id']);
       
        $gamePlayerService = new GamePlayerService();
        $confirmed = $inputRequest['confirmed'] == 1 ? true : false;
        $team_id = isset($inputRequest['team_id']) && $inputRequest['team_id'] != 0 ? $inputRequest['team_id'] : null;
        $dto = new GamePlayerInputDto($inputRequest['player_id'], $inputRequest['game_id'], $confirmed, 0, $team_id);
        $gamePlayerService->updateGamePlayer($inputRequest['id'], $dto);
        $gameService = new GameService();
        $gameService->checkPlayer($inputRequest['game_id']);
        return redirect()->route('games.index');
    }

    public function store(Request $request)
    {
        $inputRequest = $request->only(['player_id', 'game_id', 'confirmed', 'goals', 'team_id']);
        $gamePlayerService = new GamePlayerService();
        $confirmed = $inputRequest['confirmed'] == 1 ? true : false;
        $dto = new GamePlayerInputDto($inputRequest['player_id'], $inputRequest['game_id'], $confirmed, 0, null);
        $output = $gamePlayerService->createGamePlayer($dto);
        $gameService = new GameService();
        $gameService->checkPlayer($inputRequest['game_id']);
        return redirect()->route('games.index');
    }
}
