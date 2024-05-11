<?php

namespace App\Services;

use App\Dto\Player\PlayerEditInputDto;
use App\Dto\Player\PlayerInputDto;
use App\Dto\Player\PlayerOutputDto;
use App\Models\Player;
use App\Repositories\PlayerRepository;
use Illuminate\Database\Eloquent\Collection;

class PlayerService {

    public function listPlayers()
    {
        $repository = PlayerRepository::paginate(); 
        return $repository;
    }

    public function getAll()
    {
        $repository = PlayerRepository::getWithUser();
        return $repository;
    }
    public function createPlayer(int $userId, int $level, bool $goalkeeper) : PlayerOutputDto
    {
        $inputDto = new PlayerInputDto($userId, $level, $goalkeeper);
        $repository = PlayerRepository::create($inputDto->toArray());
        $outputDto = new PlayerOutputDto($repository->id, $inputDto->user_id, $inputDto->level, $inputDto->goalkeeper);
        return $outputDto;
    }

    public function editPlayer(PlayerEditInputDto $dto) {
        PlayerRepository::update($dto->id, ['level' => $dto->level, 'goalkeeper' => $dto->goalkeeper]);
    }

    public function findOnePlayer($id)
    {
        $repository = PlayerRepository::findOne($id);
        return $repository;
    }

    public function changeLevel(int $userId, int $level) : PlayerOutputDto|null
    {
        $player = PlayerRepository::findByUserId($userId);
        if ($player) {
            $inputDto = new PlayerInputDto($userId, $player->level, $player->goalkeeper);
            
            PlayerRepository::update($inputDto->user_id, ['level' => $level]);

            return new PlayerOutputDto($player->id, $userId, $level, $player->goalkeeper);
        }

        return null;
    }

    public function changeGoalKeeper(int $userId, bool $isGoalKeeper) : PlayerOutputDto|null
    {
        $player = PlayerRepository::findByUserId($userId);
        if ($player) {
            $inputDto = new PlayerInputDto($userId, $player->level, $player->goalkeeper);
            PlayerRepository::update($inputDto->user_id, ['goalkeeper' => $isGoalKeeper]);

            return new PlayerOutputDto($player->id, $userId, $player->level,  $isGoalKeeper);
        }

        return null;
    }
}