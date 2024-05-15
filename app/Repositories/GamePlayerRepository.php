<?php

namespace App\Repositories;

use App\Models\GamePlayer;

class GamePlayerRepository extends AbstractRepository
{
    protected static $model = GamePlayer::class;

    public static function findByPlayerId(int $player_id){
        return self::model()::query()->where(['player_id' => $player_id])->get();
    }

    public static function findByTeamId(int $team_id){
        return self::model()::query()->with('player')->with('user')->where(['team_id' => $team_id])->get();
    }

    public static function findByGameId(int $game_id){
        return self::model()::query()->with('user')->with('player')->where(['game_id' => $game_id])->get();
    }

    public static function changeTeamByGameId(int $game_id, array $value)
    {
        return self::model()::query()->where(['game_id' => $game_id])->update($value);
    }

    public static function deleteByGameId($game_id)
    {
        return self::model()::query()->where(['game_id' => $game_id])->delete();
    }

}