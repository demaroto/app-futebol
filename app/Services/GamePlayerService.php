<?php

namespace App\Services;

use App\Dto\GamePlayer\GamePlayerInputDto;
use App\Models\GamePlayer;
use App\Repositories\GamePlayerRepository;
use App\Repositories\GameRepository;
use Illuminate\Database\Eloquent\Model;

class GamePlayerService {

    public function createGamePlayer(GamePlayerInputDto $dto) : Model
    {
        $repository = GamePlayerRepository::create($dto->toArray());
        return $repository;
    }

    public function next()
    {
        $gameRepository = GameRepository::getNextGame();
        return $gameRepository;
    }

    public function updateGamePlayer(int $id, GamePlayerInputDto $dto)  {
        $repository = GamePlayerRepository::update($id, $dto->toArray());
        return $repository;
    }

    public function cleanTeamByGameId($id)
    {
        $attr = ['team_id' =>  null];
        GamePlayerRepository::changeTeamByGameId($id, $attr);
        return;
    }

    public function deleteByGameId($id)
    {
        GamePlayerRepository::deleteByGameId($id);
    }

    public function findByGameId($id)
    {
        $repository = GamePlayerRepository::findByGameId($id);
        return $repository;
    }

    public function findByTeam($id)
    {
        $repository = GamePlayerRepository::findByTeamId($id);
        return $repository;
    }


}