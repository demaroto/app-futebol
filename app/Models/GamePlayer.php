<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class GamePlayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'player_id',
        'team_id',
        'game_id',
        'confirmed',
        'goals'
    ];

    public function game() : BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class);
    }

    public function player() : BelongsTo
    {
        return $this->BelongsTo(Player::class);
    }

    public function user() : HasOneThrough
    {
        return $this->hasOneThrough(User::class,Player::class, 'id', 'id', 'player_id',  'user_id'); 
    }
}
