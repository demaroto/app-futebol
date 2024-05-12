<?php

namespace App\Dto\Team;

use Illuminate\Contracts\Validation\Validator;
use App\Dto\AbstractDto;
use App\Dto\InterfaceDto;

class TeamOutputDto extends AbstractDto implements InterfaceDto
{

    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly int $game_id
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
