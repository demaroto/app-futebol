<?php

namespace App\Repositories;

use App\Models\Game;

class GameRepository extends AbstractRepository
{
    protected static $model = Game::class;

    public static function getNextGame(){
        return self::model()::query()->with('gamePlayers')->with('teams')->with('players')->where('date', '>=', date('Y-m-d'))->first();
    }

    public static function playerConfirmed($id)
    {
        return self::model()::query()
                ->with('gamePlayers', fn($query) => $query->where('confirmed', 1))
                ->with('players')
                ->where('id', $id)->first();
    }

}