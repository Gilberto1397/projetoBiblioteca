<?php

namespace Feature\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GenderControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
     * @return void
     * @test
     * The current assertions are made:
     * - The response status code should be 201 (Created).
     * - The response should contain the "message" property.
     * - The response should contain the "error" property.
     * - The 'message' property should be 'Gênero criado com sucesso!'.
     * - The 'error' property should be false.
     */
    public function testCreateGendersTrue()
    {
        DB::beginTransaction();

        $response = $this->json('POST', '/api/v1/novo-genero', [
            'singleName' => 'Fiction'
        ]);
        $objectResponse = json_decode($response->getContent());

        $this->assertSame(201, $response->getStatusCode(),
            'The response status code should be 201 (Created).'
        );

        $this->assertObjectHasProperty(
            'message',
            $objectResponse,
            'The response should contain the "message" property.'
        );
        $this->assertObjectHasProperty(
            'error',
            $objectResponse,
            'The response should contain the "error" property.'
        );

        $this->assertSame('Gênero criado com sucesso!', $objectResponse->message,
            "The 'message' property should be 'Gênero criado com sucesso!'."
        );

        $this->assertFalse($objectResponse->error, "The 'error' property should be false.");

        DB::rollBack();
    }

    public function testCreateGendersFalse()
    {
        $response = $this->json('POST', '/api/v1/novo-genero', [
            'teste' => '123'
        ]);
        $objectResponse = json_decode($response->getContent());

        $this->assertSame(406, $response->getStatusCode(),
            'The response status code should be 406 (Not Acceptable).'
        );

        $this->assertObjectHasProperty(
            'messages',
            $objectResponse,
            'The response should contain the "messages" property.'
        );
        $this->assertObjectHasProperty(
            'error',
            $objectResponse,
            'The response should contain the "error" property.'
        );

        $this->assertTrue($objectResponse->error, "The 'error' property should be true.");
    }
}
