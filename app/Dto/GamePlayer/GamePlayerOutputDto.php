<?php

namespace App\Dto\GamePlayer;

use Illuminate\Contracts\Validation\Validator;
use App\Dto\AbstractDto;
use App\Dto\InterfaceDto;

class GamePlayerOutputDto extends AbstractDto implements InterfaceDto
{
    public function __construct(
        public readonly int $id,
        public readonly int $player_id,
        public readonly int $game_id,
        public readonly bool $confirmed,
        public readonly int $goals,
        public readonly int|null $team_id,
    ) {
        $this->validate();
    }

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
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
