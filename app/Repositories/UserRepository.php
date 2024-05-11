<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends AbstractRepository
{
    protected static $model = User::class;

    public static function findByEmail(string $email){
        return self::model()::query()->where(['email' => $email])->first();

    }

    /**
     * Ultimo usuário criado
     * @return void
     */
    public static function findByLastedCreated(){
        return self::model()::query()->orderByDesc('id')->first();
    }
}