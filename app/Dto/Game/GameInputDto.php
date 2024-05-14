<?php

namespace App\Dto\Game;

use Illuminate\Contracts\Validation\Validator;
use App\Dto\AbstractDto;
use App\Dto\InterfaceDto;

class GameInputDto extends AbstractDto implements InterfaceDto
{
    public function __construct(
        public readonly string $date,
        public readonly string $limit_players
    ) {
        $this->validate();
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date_format:Y-m-d|unique:games,date',
            'limit_players' => 'required|min:1|max:11'
        ];
    }

    public function messages(): array
    {
        return [
            'date' => 'Você precisa definir uma data no formato Y-m-d H:i:s.',
            'date.unique' => 'Já existe uma partida com esta data',
            'limit_players' => 'Você precisa definir um numero entre 1 e 11.',
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
