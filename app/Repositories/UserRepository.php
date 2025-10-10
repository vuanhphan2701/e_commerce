<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{

    // Tạo user mới
    public function createUser(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    // Tìm user theo email
    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }


    // Kiểm tra password
    public function checkPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }
}
