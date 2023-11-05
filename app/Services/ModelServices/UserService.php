<?php 

namespace App\Services\ModelServices;
use App\Constants\UserConstant\UserRole;
use App\Constants\UserConstant\UserStatus;
use App\Models\User;

class UserService extends BaseService {
    public function __construct(User $user) {
        $this->model = $user;
    }

    public function getAllUser() {
        $users = User::whereNot('role', UserRole::ADMIN)->get();
        return $users;
    }

    public function isEmailExist($email)
    {
        return User::where('email', $email)->where('status', UserStatus::ACTIVE)->exists();
    }
}