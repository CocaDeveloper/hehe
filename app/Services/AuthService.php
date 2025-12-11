<?php

namespace App\Services;

use App\Models\Char;
use App\Models\User;

class AuthService
{
    public function register(array $data)
    {
        return User::create([
            'userid' => $data['login'],
            'email' => $data['email'],
            'user_pass' => $data['password'],
            'phone' => $data['phone'],
        ]);
    }
}