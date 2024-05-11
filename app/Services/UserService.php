<?php

namespace App\Services;

use App\Dto\User\UserDto;
use App\Dto\User\UserOutput;
use App\Repositories\UserRepository;

class UserService {

    /** 
     * @param mixed[] $input Array com [name, email, password, nickname, password_confirmation]  
     * 
    */
    public function createUser($input) : UserOutput {
        
        $inputDto = new UserDto(...$input);
        
        $repository = UserRepository::create($inputDto->toArray());
        $outputDto = new UserOutput($repository->id, $inputDto->name, $inputDto->email, $inputDto->nickname);
        return $outputDto;
    }
}