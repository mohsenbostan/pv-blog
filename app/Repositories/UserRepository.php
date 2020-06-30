<?php

namespace App\Repositories;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * @param $name
     * @param $email
     * @param $password
     */
    public function store($name, $email, $password): void
    {
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
    }
}
