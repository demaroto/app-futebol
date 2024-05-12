<?php

namespace App\Dto\Player;

use Illuminate\Contracts\Validation\Validator;
use App\Dto\AbstractDto;
use App\Dto\InterfaceDto;

class PlayerInputDto extends AbstractDto implements InterfaceDto
{
    public function __construct(
        public readonly int $user_id,
        public readonly int $level,
        public readonly bool $goalkeeper
    ) {
        $this->validate();
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|unique:players,user_id|integer|exists:users,id',
            'level' => 'required|integer|min:1|max:5',
            'goalkeeper' => 'required|boolean'
        ];
    }

    public function messages(): array
    {
        return [
            'user_id' => 'Você precisa informa um usuário novo.',
            'level' => 'Você precisa definir um número entre 1 e 5.',
            'goalkeeper' => 'Você precisa definir um valor sim ou não.',
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
