<?php

namespace App\Repositories;

use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Support\Facades\Hash;
use Core\Repositories\BaseRepository;
class UserRepository extends BaseRepository
{
    protected $model = User::class;

    // Tạo user mới
    public function createUser(array $data)
    {
        return $this->model::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    // Tìm user theo email
    public function findByEmail(string $email)
    {
        return $this->model::where('email', $email)->first();
    }


    // Kiểm tra password
    public function checkPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }
}
