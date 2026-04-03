<?php

namespace App\Actions\Auth;

use App\Data\Auth\UserLoginData;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthUser
{
    public static function execute(UserLoginData $data){
        $user = User::where('email', $data->email)->first();

//        It is also possible here
//        Auth::attempt(['email' => $data->email, 'password' => $data->password]);
//        then Auth::user() - facade style

        if (!$user || !Hash::check($data->password, $user->password)) {
            throw ValidationException::withMessages([
                'error' => ['Invalid credentials.'],
            ]);
        }

        return $user;
    }
}
