<?php

namespace Feature\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use withoutMiddleware;

    /**
     * @return void
     * @test
     * The following checks are made:
     * - The response status code is 201, indicating successful creation.
     * - The response contains a 'message' property indicating success.
     * - The response contains an 'error' property set to false, indicating no error occurred.
     * - The 'message' property is a string and contains the expected success message.
     * - The 'error' property is a boolean and is set to false, indicating no error occurred.
     * - The 'message' is 'Usuário criado com sucesso!', indicating the user was created successfully.
     * - The 'error' is false, indicating no error occurred during the user creation process.
     */
    public function testCreateUserTrue(): void
    {
        DB::beginTransaction();

        $response = $this->json('POST', '/api/v1/novo-usuario', [
            'name' => 'Test User',
            'cpf' => '12345678901',
            'email' => 'mail@mail.com',
            'password' => 'password123',
            'telephone' => '11987654321',
            'dateBirth' => '01/01/2000',
        ]);
        $objectResponse = json_decode($response->getContent());

        $this->assertSame(201, $response->getStatusCode(), 'The response status code should be 201 for successful creation');
        $this->assertObjectHasProperty('message', $objectResponse, 'The response should contain a message property');
        $this->assertObjectHasProperty('error', $objectResponse, 'The response should contain an error property');

        $this->assertIsString($objectResponse->message, 'The message property should be a string');
        $this->assertIsBool($objectResponse->error, 'The error property should be a boolean');

        $this->assertSame('Usuário criado com sucesso!', $objectResponse->message, 'The message should indicate success');
        $this->assertFalse($objectResponse->error, 'The error property should be false for a successful creation');

        DB::rollBack();
    }
}
