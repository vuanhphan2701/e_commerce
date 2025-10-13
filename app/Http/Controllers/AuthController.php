<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Validator;
use Core\Response;

class AuthController extends Controller
{

    /**
     * Authentication Repository
     */
    protected $users;

    public function __construct()
    {
        $this->users = resolve(UserRepository::class);
    }

    // Đăng ký người dùng
    public function register(Request $request)
    {
        // Tạo validator thủ công
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Nếu validate thất bại
        if ($validator->fails()) {
            return Response::error('Validation failed', 422, $validator->errors());
        }


        // Tạo user mới
        $user = $this->users->createUser($validator->validated());

        // Tạo token API cho user
        $token = $user->createToken('auth_token')->plainTextToken;
        return Response::success([
            'user' => $user,
            'token' => $token
        ], 'User registered successfully', 201);
    }

    // Đăng nhập người dùng
    public function authenticate(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Nếu lỗi
        if ($validator->fails()) {
            return Response::error('Validation failed', 422, $validator->errors());
        }

        $credentials = $validator->validated();

        // Tìm user theo email
        $user = $this->users->findByEmail($credentials['email']);

        // Kiểm tra mật khẩu
        if (!$user || !$this->users->checkPassword($user, $credentials['password'])) {
            return Response::error('Invalid credentials', 401);
        }

        // Tạo token đăng nhập
        $token = $user->createToken('auth_token')->plainTextToken;

        return Response::success([
            'user' => $user,
            'token' => $token
        ], 'User authenticated successfully');
    }
}
