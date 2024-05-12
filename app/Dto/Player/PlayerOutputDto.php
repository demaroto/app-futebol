<?php

namespace App\Dto\Player;

use Illuminate\Contracts\Validation\Validator;
use App\Dto\AbstractDto;
use App\Dto\InterfaceDto;

class PlayerOutputDto extends AbstractDto implements InterfaceDto
{
    public function __construct(
        public readonly int $id,
        public readonly string $user_id,
        public readonly string $level,
        public readonly bool $goalkeeper
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
