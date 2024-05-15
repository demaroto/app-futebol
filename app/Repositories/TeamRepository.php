<?php

namespace App\Repositories;

use App\Models\Team;

class TeamRepository extends AbstractRepository
{
    protected static $model = Team::class;

    public static function findByGameId(int $game_id){
        return self::model()::query()
            ->with('game')
            ->with('players')
            ->with('gamePlayers')
            ->where(['game_id' => $game_id])->get();
    }

    public static function deleteByGameId($game_id)
    {
        return self::model()::query()->where(['game_id' => $game_id])->delete();
    }

    public static function getTeamsEmpty($game_id)
    {
        return self::model()::query()->with('gamePlayers')->where(['game_id' => $game_id])->get();
    }

}