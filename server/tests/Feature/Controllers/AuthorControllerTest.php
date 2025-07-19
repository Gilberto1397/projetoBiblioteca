<?php

namespace Feature\Controllers;

use App\Models\Author;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testGetAuthorsTrue()
    {
        $response = $this->json('GET', '/api/v1/autores/');
        $objectResponse = json_decode($response->getContent());

        $this->assertSame(200, $response->getStatusCode());

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
        $this->assertObjectHasProperty(
            'authors',
            $objectResponse,
            'The response should contain the "authors" property.'
        );

        $this->assertEmpty($objectResponse->message, "The 'message' property should be empty.");

        $this->assertFalse($objectResponse->error, "The 'error' property should be false.");

        $this->assertNotEmpty($objectResponse->authors, "The 'authors' property should be not empty.");

        foreach ($objectResponse->authors as $author) {
            $this->assertObjectHasProperty(
                'id',
                $author,
                "The 'id' attribute should exist in each object in the 'authors' array."
            );
            $this->assertObjectHasProperty(
                'name',
                $author,
                "The 'name' attribute should exist in each object in the 'authors' array."
            );
            $this->assertObjectHasProperty(
                'nationality',
                $author,
                "The 'nationality' attribute should exist in each object in the 'authors' array."
            );
            $this->assertObjectHasProperty(
                'dateBirth',
                $author,
                "The 'dateBirth' attribute should exist in each object in the 'authors' array."
            );

            $this->assertNotEmpty($author->id, "The 'id' attribute should not be empty.");
            $this->assertNotEmpty($author->name, "The 'name' attribute should not be empty.");
            $this->assertNotEmpty($author->nationality, "The 'nationality' attribute should not be empty.");
            $this->assertNotEmpty($author->dateBirth, "The 'dateBirth' attribute should not be empty.");
        }
    }

    public function testGetAuthorsFalse()
    {
        DB::beginTransaction();

        Author::fromQuery('delete from publishers_books;');
        Author::fromQuery('delete from books;');
        Author::fromQuery('delete from authors;');

        $response = $this->json('GET', '/api/v1/autores/');
        $objectResponse = json_decode($response->getContent());

        $this->assertSame(200, $response->getStatusCode());

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
        $this->assertObjectHasProperty(
            'authors',
            $objectResponse,
            'The response should contain the "authors" property.'
        );

        $this->assertEmpty($objectResponse->message, "The 'message' property should be empty.");

        $this->assertFalse($objectResponse->error, "The 'error' property should be false.");

        $this->assertEmpty($objectResponse->authors, "The 'authors' property should be empty.");
    }

    public function testCreateAuthorTrue()
    {
        DB::beginTransaction();

        $resposta = $this->json('POST', '/api/v1/novo-autor/', [
            'name' => 'Joao Teste',
            'nationality' => 'Brasileiro',
            'dateBirth' => '20/10/1997'
        ]);
        $objectResponse = json_decode($resposta->getContent());

        $this->assertSame(201, $resposta->getStatusCode());

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

        $this->assertNotEmpty($objectResponse->message, "The 'message' property should not be empty.");
        $this->assertSame('Autor criado com sucesso!', $objectResponse->message, 'Wrong message.');

        $this->assertFalse($objectResponse->error, "The 'error' property should be false.");

        DB::rollBack();
    }
}
