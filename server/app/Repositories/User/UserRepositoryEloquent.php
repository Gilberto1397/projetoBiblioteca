<?php

namespace App\Repositories\User;

use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PDOException;

class UserRepositoryEloquent implements UserRepository
{
    /**
     * @param  UserRequest  $userRequest
     * @throw PDOException
     * @return bool
     */
    public function createUser(UserRequest $userRequest): bool
    {
        try {
            $dateBirth = \DateTime::createFromFormat('d/m/Y', $userRequest->dateBirth)->format('Y-m-d');

            $user = new User();
            $user->user_name = $userRequest->name;
            $user->user_cpf = $userRequest->cpf;
            $user->user_email = $userRequest->email;
            $user->user_password = Hash::make($userRequest->password);
            $user->user_date_birth = $dateBirth;
            $user->user_register_last_update = date('Y-m-d', strtotime("+1 day"));
            $user->user_register_active = true;
            $user->user_telephone = $userRequest->telephone ?? null;
            $user->user_userole_id = 1;
            return $user->save();

        } catch (PDOException $e) {
            return false;
        }
    }
}
