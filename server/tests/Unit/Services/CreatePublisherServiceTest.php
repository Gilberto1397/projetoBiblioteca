<?php

namespace Tests\Unit\Services;

use App\Http\Requests\Publisher\PublisherRequest;
use App\Repositories\Publisher\PublisherRepository;
use App\Services\Publisher\CreatePublisherService;
use Tests\TestCase;

class CreatePublisherServiceTest extends TestCase
{
    /**
     * @return void
     * @test
     * The following checks are made:
     * - The response object has the properties: message, statusCode, and error.
     * - The message property is a string.
     * - The statusCode property is an integer.
     * - The error property is a boolean.
     * - The message property is equal to 'Editora criada com sucesso!'.
     * - The statusCode property is equal to 201.
     * - The error property is false when the publisher is created successfully.
     */
    public function testCreatePublisherTrue(): void
    {
        /**
         * Arrange - Given
         */
        $publisherRepositoryMock = $this->createMock(PublisherRepository::class);
        $publisherRepositoryMock->method('createPublisher')->willReturn(true);

        $publisherRequest = new PublisherRequest();

        $createPublisherService = new CreatePublisherService($publisherRepositoryMock);

        /**
         * Act - When
         */
        $response = $createPublisherService->createPublisher($publisherRequest);

        /**
         * Assert - Then
         */
        $this->assertObjectHasProperty('message', $response, 'Response object should have a message property');
        $this->assertObjectHasProperty('statusCode', $response, 'Response object should have a statusCode property');
        $this->assertObjectHasProperty('error', $response, 'Response object should have an error property');

        $this->assertIsString($response->message, 'Response object should have a message property');
        $this->assertIsInt($response->statusCode, 'Response object should have a statusCode property');
        $this->assertIsBool($response->error, 'Response object should have an error property');

        $this->assertSame('Editora criada com sucesso!', $response->message);
        $this->assertSame(201, $response->statusCode);
        $this->assertFalse($response->error, 'Error should be false when publisher is created successfully');
    }

    /**
     * @return void
     * @test
     * The following checks are made:
     * - The response object has the properties: message, statusCode, and error.
     * - The message property is a string.
     * - The statusCode property is an integer.
     * - The error property is a boolean.
     * - The message property is equal to 'Falha ao criar Editora!'.
     * - The statusCode property is equal to 500.
     * - The error property is true when the publisher creation fails.
     */
    public function testCreatePublisherFalse(): void
    {
        /**
         * Arrange - Given
         */
        $publisherRepositoryMock = $this->createMock(PublisherRepository::class);
        $publisherRepositoryMock->method('createPublisher')->willReturn(false);

        $publisherRequest = new PublisherRequest();

        $createPublisherService = new CreatePublisherService($publisherRepositoryMock);

        /**
         * Act - When
         */
        $response = $createPublisherService->createPublisher($publisherRequest);

        /**
         * Assert - Then
         */
        $this->assertObjectHasProperty('message', $response, 'Response object should have a message property');
        $this->assertObjectHasProperty('statusCode', $response, 'Response object should have a statusCode property');
        $this->assertObjectHasProperty('error', $response, 'Response object should have an error property');

        $this->assertIsString($response->message, 'Response object should have a message property');
        $this->assertIsInt($response->statusCode, 'Response object should have a statusCode property');
        $this->assertIsBool($response->error, 'Response object should have an error property');

        $this->assertSame('Falha ao criar Editora!', $response->message);
        $this->assertSame(500, $response->statusCode);
        $this->assertTrue($response->error, 'Error should be true when publisher creation fails');
    }
}
