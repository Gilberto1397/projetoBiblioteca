<?php

namespace Tests\Repositories;

use App\Http\Requests\User\UserRequest;
use App\Repositories\User\UserRepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserRepositoryEloquentTest extends TestCase
{
    /**
     * @return void
     * @test
     * The following checks are made:
     * - The return value is true, indicating the user was created successfully.
     */
    public function testCreateUser(): void
    {
        DB::beginTransaction();

        $userRequest = new UserRequest();
        $userRequest->name = 'Test User';
        $userRequest->cpf = '12345678901';
        $userRequest->email = 'mail@mail.com';
        $userRequest->password = 'password123';
        $userRequest->dateBirth = '01/01/2000';
        $userRequest->telephone = '1234567890';

        $repository = new UserRepositoryEloquent();
        $result = $repository->createUser($userRequest);

        $this->assertTrue($result, 'User created successfully');

        DB::rollBack();
    }
}
