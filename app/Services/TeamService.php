<?php

namespace App\Services;

use App\Dto\Team\TeamInputDto;
use App\Dto\Team\TeamOutputDto;
use App\Repositories\TeamRepository;

class TeamService {

    public function createTeam(string $name, int $game_id) : TeamOutputDto
    {
        $inputDto = new TeamInputDto($name, $game_id);
        
        $repository = TeamRepository::create($inputDto->toArray());
        $outputDto = new TeamOutputDto($repository->id, $inputDto->name, $inputDto->game_id);
        return $outputDto;
    }

    public function findByGame(int $game_id)
    {
       $repository = TeamRepository::findByGameId($game_id);
       return $repository;
    }

    public function deleteByGameId($game_id)
    {
        $repository = TeamRepository::deleteByGameId($game_id);
    }

    public function countByGameId($game_id)
    {
        $repository = TeamRepository::findByGameId($game_id)->count();
        return $repository;
    }

}