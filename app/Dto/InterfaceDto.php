<?php

namespace App\Dto;

use Illuminate\Contracts\Validation\Validator;

interface InterfaceDto
{
    public function rules():array;
    public function messages():array;
    public function validator():Validator;
    public function validate():array;
}