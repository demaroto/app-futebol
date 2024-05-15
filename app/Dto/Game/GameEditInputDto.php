<?php

namespace App\Dto\Game;

use Illuminate\Contracts\Validation\Validator;
use App\Dto\AbstractDto;
use App\Dto\InterfaceDto;

class GameEditInputDto extends AbstractDto implements InterfaceDto
{
    public function __construct(
        public readonly string $date,
        public readonly string $limit_players,
        public readonly int $id
    ) {
        $this->validate();
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date_format:Y-m-d',
            'limit_players' => 'required|integer|min:2|max:11',
            'id' => 'required|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'date' => 'Você precisa definir uma data no formato Y-m-d H:i:s.',
            'limit_players' => 'Você precisa definir um numero entre 2 e 11.'
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
