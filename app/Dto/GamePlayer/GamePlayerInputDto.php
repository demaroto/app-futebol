<?php

namespace App\Dto\GamePlayer;

use Illuminate\Contracts\Validation\Validator;
use App\Dto\AbstractDto;
use App\Dto\InterfaceDto;

class GamePlayerInputDto extends AbstractDto implements InterfaceDto
{
    public function __construct(
        public readonly int $player_id,
        public readonly int $game_id,
        public readonly bool $confirmed,
        public readonly int $goals,
        public readonly int|null $team_id = null
    ) {
        $this->validate();
    }

    public function rules(): array
    {
        return [
            'player_id' => 'required|integer|exists:players,id',
            'game_id' => 'required|integer|exists:games,id',
            'confirmed' => 'required|boolean',
            'goals' => 'integer|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'player_id' => 'Você precisa informar um jogador existente.',
            'game_id' => 'Você precisa informar um game existente.',
            'confirmed' => 'Confirmação de presença inválido.',
            'goal' => 'Você precisa definir os gols no mínimo 0',
           
        ];
    }

    public function validator(): Validator
    {

        return validator($this->toArray(), $this->rules(), $this->messages());
    }

    public function validate(): array
    {
        return $this->validator()->validate();
    }
}
