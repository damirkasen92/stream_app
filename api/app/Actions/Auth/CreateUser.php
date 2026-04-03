<?php

namespace App\Actions\Auth;

use App\Data\Auth\UserRegistrationData;
use App\Models\User;

class CreateUser
{
    public static function execute(UserRegistrationData $data): User {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
        ]);
    }
}
