<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Pagination\LengthAwarePaginator;

class PlayerRepository extends AbstractRepository
{
    protected static $model = Player::class;

    public static function findByLevel(int $level){
        return self::model()::query()->with('user')->where(['level' => $level])->first();
    }

    public static function paginate($perPage = 5): LengthAwarePaginator
    {
        return self::model()::query()->with('user')->paginate($perPage);
    }

    public static function findOne($id)
    {
        return self::model()::query()
                ->with('user')
                ->withSum('gamePlayers', 'goals')
                ->where(['id' => $id])
                ->first();
    }

    public static function findByUserId(int $userId)
    {
        return self::model()::query()->with('user')->where(['user_id' => $userId])->first();
    }

    public static function getWithUser()
    {
        return self::model()::query()->with('user')->get();
    }

    /**
     * Busca goleiros
     * @return void
     */
    public static function findByGoalKeeper(){
        return self::model()::query()->with('user')->where(['level' => true])->get();
    }
}