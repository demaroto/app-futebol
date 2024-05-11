<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game_id'
    ];

    public function game() : BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function gamePlayers() : HasMany
    {
        return $this->HasMany(GamePlayer::class);
    }

    public function players() : HasManyThrough
    {
        return $this->hasManyThrough(Player::class, GamePlayer::class, 'team_id', 'id', 'id', 'player_id');
    }

}
