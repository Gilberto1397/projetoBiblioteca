<?php

namespace App\Repositories\User;

use App\Http\Requests\User\UserRequest;

interface UserRepository
{
    /**
     * Create a new user in the database.
     * @param  UserRequest  $userRequest
     * @return bool
     */
    public function createUser(UserRequest $userRequest):bool;
}
