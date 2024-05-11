<?php

namespace App\Dto\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rules\Password;
use App\Dto\AbstractDTO;
use App\Dto\InterfaceDto;

class UserDto extends AbstractDto implements InterfaceDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $nickname,
        public readonly string $password_confirmation
    ) {
        $this->validate();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:100',
            'email' => 'required|email',
            'password' => ['required', Password::min(6)],
            'nickname' => 'required|min:2|max:30',
            'password_confirmation' => 'required|same:password'
        ];
    }

    public function messages(): array
    {
        return [
            'name' => 'Você precisa definir um nome entre 3 e 15 caracteres.',
            'email' => 'Você precisa definir um e-mail válido.',
            'password' => 'Você precisa definir uma senha acima de 6 caracteres.',
            'nickname' => 'Você precisa definir um nickname entre 2 e 15 caracteres.',
            'password_confirmation' => 'Senha de confirmação nao confere.'
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
