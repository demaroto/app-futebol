<?php

namespace App\Dto\Game;

use Illuminate\Contracts\Validation\Validator;
use App\Dto\AbstractDto;
use App\Dto\InterfaceDto;

class GameOutputDto extends AbstractDto implements InterfaceDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $date,
        public readonly string $limit_players
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
