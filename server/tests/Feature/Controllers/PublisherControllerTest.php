<?php

namespace Feature\Controllers;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PublisherControllerTest extends TestCase
{
    use withoutMiddleware;

    public function testGetPublishers()
    {
        $response = $this->json('GET', '/api/v1/editoras');
        $objectResponse = json_decode($response->getContent());

        $this->assertSame(200, $response->getStatusCode());
        $this->assertObjectHasProperty('message', $objectResponse, 'The response should contain a message property');
        $this->assertObjectHasProperty('error', $objectResponse, 'The response should contain an error property');
        $this->assertObjectHasProperty('data', $objectResponse, 'The response should contain a data property');
        $this->assertIsObject($objectResponse->data, 'The data property should be an object');

        if (count($objectResponse->data->publishers) > 0) {
            foreach ($objectResponse->data->publishers as $publisher) {
                $this->assertObjectHasProperty('id', $publisher, 'The publisher should have an id property');
                $this->assertObjectHasProperty('name', $publisher, 'The publisher should have a name property');
                $this->assertObjectHasProperty('countryOrigin', $publisher, 'The publisher should have a countryOrigin property');

                $this->assertNotEmpty($publisher->id, 'The publisher id should not be empty');
                $this->assertNotEmpty($publisher->name, 'The publisher name should not be empty');
                $this->assertNotEmpty($publisher->countryOrigin, 'The publisher country origin should not be empty');

                $this->assertIsInt($publisher->id, 'The publisher id should be an integer');
                $this->assertIsString($publisher->name, 'The publisher name should be a string');
                $this->assertIsString($publisher->countryOrigin, 'The publisher country origin should be a string');
            }
        }
    }

    public function testCreatePublisher()
    {
        DB::beginTransaction();

        $response = $this->json('POST', '/api/v1/nova-editora', [
            'name' => 'Test Publisher',
            'countryOrigin' => 'Test Country'
        ]);
        $objectResponse = json_decode($response->getContent());

        $this->assertSame(201, $response->getStatusCode(), 'The response status code should be 201 for successful creation');
        $this->assertObjectHasProperty('message', $objectResponse, 'The response should contain a message property');
        $this->assertObjectHasProperty('error', $objectResponse, 'The response should contain an error property');

        $this->assertIsString($objectResponse->message, 'The message property should be a string');
        $this->assertIsBool($objectResponse->error, 'The error property should be a boolean');

        $this->assertSame('Editora criada com sucesso!', $objectResponse->message, 'The message should indicate success');
        $this->assertFalse($objectResponse->error, 'The error property should be false for a successful creation');

        DB::rollBack();
    }
}
