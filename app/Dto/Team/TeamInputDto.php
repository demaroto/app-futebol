<?php

namespace App\Dto\Team;

use Illuminate\Contracts\Validation\Validator;
use App\Dto\AbstractDTO;
use App\Dto\InterfaceDTO;

class TeamInputDto extends AbstractDto implements InterfaceDto
{

    public function __construct(
        public readonly string $name,
        public readonly int $game_id
    ) {
        $this->validate();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:1|max:150',
            'game_id' => 'required|exists:games,id'
            
        ];
    }

    public function messages(): array
    {
        return [
            'name' => 'Você precisa definir entre 1 e 60 caracteres.',
            'game_id' => 'Você precisa definir a partida',
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
