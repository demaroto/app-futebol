<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'limit_players'
    ];

    public function teams() : HasMany
    {
        return $this->hasMany(Team::class);
    }

    public function gamePlayers() : HasMany
    {
        return $this->hasMany(GamePlayer::class);
    }

        /**
     * Get all of the games for the Player
     */
    public function players() : HasManyThrough
    {
        return $this->hasManyThrough(Player::class, GamePlayer::class, 'game_id', 'id', 'id', 'player_id');
    }
}
