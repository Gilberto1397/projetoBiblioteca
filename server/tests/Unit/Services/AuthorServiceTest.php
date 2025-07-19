<?php

namespace Tests\Unit\Services;

use App\Http\Resources\Author\AuthorCollectionResource;
use App\Models\Author;
use App\Repositories\Author\AuthorRepository;
use App\Services\Author\GetAuthorsService;
use Tests\TestCase;

class AuthorServiceTest extends TestCase
{
    /**
     * @return void
     * @test
     * Os seguintes testes foram realizados:
     * Verifica se a propriedade message existe no objeto de resposta.
     * Verifica se a propriedade statusCode existe no objeto de resposta.
     * Verifica se a propriedade error existe no objeto de resposta.
     * Verifica se a propriedade data existe no objeto de resposta.
     * Verifica se a propriedade message está vazia.
     * Verifica se a propriedade statusCode é um inteiro.
     * Verifica se o valor de statusCode é igual a 200.
     * Verifica se a propriedade error é um booleano.
     * Verifica se o valor de error é igual a false.
     * Verifica se a propriedade data não está vazia.
     * Verifica se a propriedade data é uma instância de AuthorCollectionResource.
     */
    public function testGetAuthorsTrue()
    {
        /**
         * Givev - Arrange
         */

        $authorOne = new Author();
        $authorOne->author_id = 1;
        $authorOne->author_name = 'Dr. Nelson Colaço';
        $authorOne->author_nationality = 'Egito';
        $authorOne->author_date_birth = '1982-08-20';

        $authorTwo = new Author();
        $authorTwo->author_id = 2;
        $authorTwo->author_name = 'Sra. Cecília Neves';
        $authorTwo->author_nationality = 'Omã';
        $authorTwo->author_date_birth = '1971-12-17';

        $authorThree = new Author();
        $authorThree->author_id = 3;
        $authorThree->author_name = 'Srta. Milene Daniella Zambrano Neto';
        $authorThree->author_nationality = 'Eslováquia';
        $authorThree->author_date_birth = '2022-05-06';

        $authorFour = new Author();
        $authorFour->author_id = 4;
        $authorFour->author_name = 'Dr. Teobaldo Willian Ramos';
        $authorFour->author_nationality = 'Rússia';
        $authorFour->author_date_birth = '2000-05-25';

        $repository = $this->createMock(AuthorRepository::class);
        $repository->method('getAuthors')
            ->willReturn([$authorOne, $authorTwo, $authorThree, $authorFour]);

        $service = new GetAuthorsService($repository);

        /**
         * When - Act
         */
        $resposta = $service->getAuthors();

        /**
         * Then - Assert
         */
        $this->assertObjectHasProperty(
            'message',
            $resposta,
            "A propriedade 'message' não existe no objeto de resposta."
        );
        $this->assertObjectHasProperty(
            'statusCode',
            $resposta,
            "A propriedade 'statusCode' não existe no objeto de resposta."
        );
        $this->assertObjectHasProperty('error', $resposta, "A propriedade 'error' não existe no objeto de resposta.");
        $this->assertObjectHasProperty('data', $resposta, "A propriedade 'data' não existe no objeto de resposta.");

        $this->assertEmpty($resposta->message, "A propriedade 'message' não está vazia.");

        $this->assertIsInt($resposta->statusCode, "A propriedade 'statusCode' não é um inteiro.");
        $this->assertEquals(200, $resposta->statusCode, "O status code não é 200.");

        $this->assertIsBool($resposta->error, "A propriedade 'error' não é um booleano.");
        $this->assertEquals(false, $resposta->error, "A propriedade 'error' não é false.");

        $this->assertNotEmpty($resposta->data, "A propriedade 'data' está vazia.");
        $this->assertInstanceOf(
            AuthorCollectionResource::class,
            $resposta->data,
            "A propriedade 'data' não é uma instância de AuthorCollectionResource."
        );
    }

    /**
     * @return void
     *  Lista de testes realizados:
     *  Verifica se a propriedade message existe no objeto de resposta.
     *  Verifica se a propriedade statusCode existe no objeto de resposta.
     *  Verifica se a propriedade error existe no objeto de resposta.
     *  Verifica se a propriedade data existe no objeto de resposta.
     *  Garante que a propriedade message está vazia.
     *  Garante que a propriedade statusCode é um inteiro.
     *  Garante que o valor de statusCode é igual a 200.
     *  Garante que a propriedade error é um booleano.
     *  Garante que o valor de error é igual a false.
     *  Garante que a propriedade data está vazia.
     *  Garante que a propriedade data é um array.
     */
    public function testGetAuthorsFalse()
    {
        /**
         * Givev - Arrange
         */
        $repository = $this->createMock(AuthorRepository::class);
        $repository->method('getAuthors')
            ->willReturn([]);

        $service = new GetAuthorsService($repository);

        /**
         * When - Act
         */
        $resposta = $service->getAuthors();

        /**
         * Then - Assert
         */
        $this->assertObjectHasProperty(
            'message',
            $resposta,
            "A propriedade 'message' não existe no objeto de resposta."
        );
        $this->assertObjectHasProperty(
            'statusCode',
            $resposta,
            "A propriedade 'statusCode' não existe no objeto de resposta."
        );
        $this->assertObjectHasProperty('error', $resposta, "A propriedade 'error' não existe no objeto de resposta.");
        $this->assertObjectHasProperty('data', $resposta, "A propriedade 'data' não existe no objeto de resposta.");

        $this->assertEmpty($resposta->message, "A propriedade 'message' não está vazia.");

        $this->assertIsInt($resposta->statusCode, "A propriedade 'statusCode' não é um inteiro.");
        $this->assertEquals(200, $resposta->statusCode, "O status code não é 200.");

        $this->assertIsBool($resposta->error, "A propriedade 'error' não é um booleano.");
        $this->assertEquals(false, $resposta->error, "A propriedade 'error' não é false.");

        $this->assertEmpty($resposta->data, "A propriedade 'data' não está vazia.");
        $this->assertIsArray($resposta->data, "A propriedade 'data' não é um array.");
    }
}
