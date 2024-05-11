<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractRepository implements RepositoryInterface
{
    protected static $model;

    public static function model():Model{
        return app(static::$model);
    }

    public static function all():Collection{
        return self::model()::all();
    }

    public static function find(int $id):Model|null{
        return self::model()::query()->find($id);
    }

    public static function create(array $attributes = []):Model|null{
        return self::model()::query()->create($attributes);
    }
    
    public static function delete(int $id):int{
        return self::model()::query()->where(['id' => $id])->delete();
    }

    public static function update(int $id, array $attributes = []):int{
        return self::model()::query()->where(['id' => $id])->update($attributes);
    }

}