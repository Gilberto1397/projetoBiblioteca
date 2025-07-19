<?php

namespace Tests\Unit\Services;

use App\Http\Requests\Publisher\PublisherFiltersRequest;
use App\Http\Resources\Publisher\PublisherCollectionResource;
use App\Models\Publisher;
use App\Repositories\Publisher\PublisherRepository;
use App\Services\Publisher\GetPublisherService;
use Tests\TestCase;

class GetPublisherServiceTest extends TestCase
{
    /**
     * @return void
     * @test
     * The following checks are made:
     * - The result is an object.
     * - The result has the properties: message, statusCode, error, and data.
     * - The message is empty.
     * - The statusCode is 200.
     * - The error is false.
     * - The data is an instance of PublisherCollectionResource.
     * - Each publisher in the data has the attributes: id, name, and countryOrigin.
     * - Each publisher's id, name, and countryOrigin are not empty.
     */
    public function testGetPublisherTrue()
    {
        /**
         * Given - Arrange
         */
        $request = new PublisherFiltersRequest();
        $request->allPublishers = 1;

        $publisher1 = new Publisher();
        $publisher1->publisher_id = 1;
        $publisher1->publisher_name = 'Publisher One';
        $publisher1->publisher_country_origin = 'Country One';

        $publisher2 = new Publisher();
        $publisher2->publisher_id = 2;
        $publisher2->publisher_name = 'Publisher Two';
        $publisher2->publisher_country_origin = 'Country Two';

        $publisherRepository = $this->createMock(PublisherRepository::class);
        $publisherRepository->method('filteredPublishers')->willReturn([]);
        $publisherRepository->method('getAllPublishers')->willReturn([$publisher1, $publisher2]);

        $service = new GetPublisherService($publisherRepository);

        /**
         * When - Act
         */
        $result = $service->getPublisher($request);
        $resultObject = json_decode($result->data->toJson());

        /**
         * Then - Assert
         */
        $this->assertIsObject($result, 'Result should be an object');

        $this->assertObjectHasProperty('message', $result, 'Result should have a message property');
        $this->assertObjectHasProperty('statusCode', $result, 'Result should have a statusCode property');
        $this->assertObjectHasProperty('error', $result, 'Result should have an error property');
        $this->assertObjectHasProperty('data', $result, 'Result should have a data property');

        $this->assertEquals('', $result->message, 'Message should be empty');
        $this->assertEquals(200, $result->statusCode, 'Status code should be 200');
        $this->assertFalse($result->error, 'Error should be false');
        $this->assertInstanceOf(
            PublisherCollectionResource::class,
            $result->data,
            'Data should be an instance of PublisherCollectionResource'
        );

        foreach ($resultObject as $publisher) {
            $this->assertObjectHasProperty('id', $publisher, 'Publisher should have an id attribute');
            $this->assertObjectHasProperty('name', $publisher, 'Publisher should have a name attribute');
            $this->assertObjectHasProperty(
                'countryOrigin',
                $publisher,
                'Publisher should have a countryOrigin attribute'
            );

            $this->assertNotEmpty($publisher->id, 'Publisher id should not be empty');
            $this->assertNotEmpty($publisher->name, 'Publisher name should not be empty');
            $this->assertNotEmpty($publisher->countryOrigin, 'Publisher countryOrigin should not be empty');
        }
    }

    /**
     * @return void
     * @test
     * The following checks are made:
     * - The result is an object.
     * - The result has the properties: message, statusCode, error, and data.
     * - The message is empty.
     * - The statusCode is 200.
     * - The error is false.
     * - The data is an instance of PublisherCollectionResource.
     * - The data property is empty.
     * - The data property is an array.
     */
    public function testGetPublisherNone()
    {
        /**
         * Given - Arrange
         */
        $request = new PublisherFiltersRequest();
        $request->allPublishers = 1;

        $publisherRepository = $this->createMock(PublisherRepository::class);
        $publisherRepository->method('filteredPublishers')->willReturn([]);
        $publisherRepository->method('getAllPublishers')->willReturn([]);

        $service = new GetPublisherService($publisherRepository);

        /**
         * When - Act
         */
        $result = $service->getPublisher($request);
        $resultObject = json_decode($result->data->toJson());

        /**
         * Then - Assert
         */
        $this->assertIsObject($result, 'Result should be an object');

        $this->assertObjectHasProperty('message', $result, 'Result should have a message property');
        $this->assertObjectHasProperty('statusCode', $result, 'Result should have a statusCode property');
        $this->assertObjectHasProperty('error', $result, 'Result should have an error property');
        $this->assertObjectHasProperty('data', $result, 'Result should have a data property');

        $this->assertEquals('', $result->message, 'Message should be empty');
        $this->assertEquals(200, $result->statusCode, 'Status code should be 200');
        $this->assertFalse($result->error, 'Error should be false');
        $this->assertInstanceOf(
            PublisherCollectionResource::class,
            $result->data,
            'Data should be an instance of PublisherCollectionResource'
        );
        $this->assertEmpty($resultObject, 'Result data should be empty');
        $this->assertIsArray($resultObject, 'Data should be an array');
    }
}
