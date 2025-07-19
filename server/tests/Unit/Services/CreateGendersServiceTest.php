<?php

namespace Tests\Unit\Services;

use App\Http\Requests\Gender\GenderRequest;
use App\Repositories\Gender\GenderRepository;
use App\Services\Gender\CreateGendersService;
use PHPUnit\Framework\TestCase;

class CreateGendersServiceTest extends TestCase
{
    /**
     * @return void
     * @test
     * The current assertions are made:
     * - The response is an object.
     * - The response has a 'message' property.
     * - The response has a 'statusCode' property.
     * - The response has an 'error' property.
     * - The message is 'Gênero criado com sucesso!'.
     * - The statusCode is 201.
     * - The error property is false.
     */
    public function testCreateGendersTrue()
    {
        /**
         * Arrange - Given
         */

        $genderRequest = new GenderRequest();
        $genderRepositoryMock = $this->createMock(GenderRepository::class);
        $genderRepositoryMock->method('createGenders')->willReturn(true);

        $service = new CreateGendersService($genderRepositoryMock);

        /**
         * Act - When
         */
        $response = $service->createGenders($genderRequest);

        /**
         * Assert - Then
         */
        $this->assertIsObject($response, 'The response is not an object');
        $this->assertObjectHasProperty('message', $response, 'The response does not have a message property');
        $this->assertObjectHasProperty('statusCode', $response, 'The response does not have a statusCode property');
        $this->assertObjectHasProperty('error', $response, 'The response does not have an error property');

        $this->assertSame('Gênero criado com sucesso!', $response->message, 'The message is not as expected');
        $this->assertSame(201, $response->statusCode, 'The statusCode is not as expected');
        $this->assertFalse($response->error, 'The error property should be false');
    }

    /**
     * @return void
     * @test
     * The current assertions are made:
     * - The response is an object.
     * - The response has a 'message' property.
     * - The response has a 'statusCode' property.
     * - The response has an 'error' property.
     * - The message is 'Falha ao criar genêro'.
     * - The statusCode is 500.
     * - The error property is true.
     */
    public function testCreateGendersFalse()
    {
        /**
         * Arrange - Given
         */
        $genderRequest = new GenderRequest();
        $genderRepositoryMock = $this->createMock(GenderRepository::class);
        $genderRepositoryMock->method('createGenders')->willReturn(false);
        $service = new CreateGendersService($genderRepositoryMock);

        /**
         * Act - When
         */
        $response = $service->createGenders($genderRequest);

        /**
         * Assert - Then
         */
        $this->assertIsObject($response, 'The response is not an object');

        $this->assertObjectHasProperty('message', $response, 'The response does not have a message property');
        $this->assertObjectHasProperty('statusCode', $response, 'The response does not have a statusCode property');
        $this->assertObjectHasProperty('error', $response, 'The response does not have an error property');

        $this->assertSame('Falha ao criar genêro', $response->message, 'The message is not as expected');
        $this->assertSame(500, $response->statusCode, 'The statusCode is not as expected');
        $this->assertTrue($response->error, 'The error property should be true');
    }
}
