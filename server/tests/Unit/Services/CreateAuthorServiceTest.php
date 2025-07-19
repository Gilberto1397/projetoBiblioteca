<?php

namespace Tests\Unit\Services;

use App\Http\Requests\Author\AuthorRequest;
use App\Repositories\Author\AuthorRepository;
use App\Services\Author\CreateAuthorService;
use PHPUnit\Framework\TestCase;
use stdClass;

class CreateAuthorServiceTest extends TestCase
{
    /**
     * @return void
     * @test
     * The following checks are made:
     * - The response is an instance of StdClass
     * - The message, status code, and error flag are defined
     * - The success message is defined and correct
     * - The status code is defined and correct
     * - The error flag is false when the author is created successfully
     */
    public function testCreateAuthorTrue()
    {
        /**
         * Arrange - Given
         */

        $authorRepositoryMock = $this->createMock(AuthorRepository::class);
        $authorRepositoryMock->method('createAuthor')->willReturn(true);

        $authorRequest = new AuthorRequest();
        $createAuthorService = new CreateAuthorService($authorRepositoryMock);

        /**
         * Act - When
         */

        $response = $createAuthorService->createAuthor($authorRequest);

        /**
         * Assert - Then
         */

        $this->assertInstanceOf(StdClass::class, $response, 'Resposta não é um objeto StdClass');

        $this->assertNotEmpty($response->message, 'Mensagem de sucesso não está definida');
        $this->assertNotEmpty($response->statusCode, 'Código de status não está definido');
        $this->assertIsBool($response->error, 'Erro não está definido');

        $this->assertEquals(
            'Autor criado com sucesso!',
            $response->message,
            'Mensagem de sucesso incorreta'
        );

        $this->assertEquals(201, $response->statusCode, 'Código de status incorreto');

        $this->assertFalse($response->error, 'Erro deve ser false quando a criação é bem-sucedida');
    }

    /**
     * @return void
     * @test
     * The following checks are made:
     * - The response is an instance of StdClass
     * - The message, status code, and error flag are defined
     * - The success message is defined and correct
     * - The status code is defined and correct
     * - The error flag is true when the author is created successfully
     */
    public function testCreateAuthorFalse()
    {
        /**
         * Arrange - Given
         */

        $authorRepositoryMock = $this->createMock(AuthorRepository::class);
        $authorRepositoryMock->method('createAuthor')->willReturn(false);

        $authorRequest = new AuthorRequest();
        $createAuthorService = new CreateAuthorService($authorRepositoryMock);

        /**
         * Act - When
         */

        $response = $createAuthorService->createAuthor($authorRequest);

        /**
         * Assert - Then
         */

        $this->assertInstanceOf(StdClass::class, $response, 'Resposta não é um objeto StdClass');

        $this->assertNotEmpty($response->message, 'Mensagem de sucesso não está definida');
        $this->assertNotEmpty($response->statusCode, 'Código de status não está definido');
        $this->assertIsBool($response->error, 'Erro não está definido');

        $this->assertEquals(
            'Falha ao criar Autor!',
            $response->message,
            'Mensagem de sucesso incorreta'
        );

        $this->assertEquals(500, $response->statusCode, 'Código de status incorreto');

        $this->assertTrue($response->error, 'Erro deve ser true quando a criação falha');
    }
}
