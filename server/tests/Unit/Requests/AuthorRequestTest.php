<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Author\AuthorRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class AuthorRequestTest extends TestCase
{

    /**
     * @param array $dataAccepted
     * @return void
     * @test
     * @dataProvider dataSetAccepted
     * Tests if the data provided is accepted by the AuthorRequest validation rules.
     */
    public function testDataAccepted(array $dataAccepted): void
    {
        /**
         * Arrange - Given
         */
        $request = new AuthorRequest();
        $rules = $request->rules();

        /**
         * Act - When
         */

        $validator = Validator::make($dataAccepted, $rules);

        /**
         * Assert - Then
         */

        $this->assertFalse($validator->fails(), 'Dados falharam na validação');
    }

    /**
     * @param array $dataNotAccepted
     * @return void
     * @test
     * @dataProvider nameNotAccepted
     * @dataProvider dateBirthNotAccepted
     * @dataProvider nationalityNotAccepted
     * Tests if the data provided is not accepted by the AuthorRequest validation rules.
     */
    public function testDataNotAccepted(array $dataNotAccepted): void
    {
        /**
         * Arrange - Given
         */
        $request = new AuthorRequest();
        $rules = $request->rules();
        $messages = $request->messages();

        /**
         * Act - When
         */

        $validator = Validator::make($dataNotAccepted, $rules, $messages);
        $responseValidation = $validator->fails();

        /**
         * Assert - Then
         */

        $this->assertTrue($responseValidation, 'DADOS NÃO FALHARAM NA VALIDAÇÃO');
    }

    /**
     * @param array $nameSet
     * @param string $expectedMessage
     * @param string $keyMessage
     * @return void
     * @test
     * @dataProvider nameNotAccepted
     * Tests if the name provided is not accepted by the AuthorRequest validation rules and returns
     * the expected error message.
     */
    public function testDataNameNotAccepted(array $nameSet, string $expectedMessage, string $keyMessage): void
    {
        /**
         * Arrange - Given
         */
        $request = new AuthorRequest();
        $rules = $request->rules();
        $messages = $request->messages();

        /**
         * Act - When
         */

        $validator = Validator::make($nameSet, $rules, $messages);
        $failedValidation = $validator->fails();
        $firstMessage = $validator->messages()->get($keyMessage)[0];

        /**
         * Assert - Then
         */

        $this->assertTrue($failedValidation, 'DADOS DE NOME NÃO FALHARAM NA VALIDAÇÃO');
        $this->assertEquals($expectedMessage, $firstMessage, 'A mensagem de erro não é a esperada');
    }

    /**
     * @param array $nationalitySet
     * @param string $expectedMessage
     * @param string $keyMessage
     * @return void
     * @test
     * @dataProvider nationalityNotAccepted
     * Tests if the nationality provided is not accepted by the AuthorRequest validation rules and returns
     * the expected error message.
     */
    public function testDataNationalityNotAccepted(
        array  $nationalitySet,
        string $expectedMessage,
        string $keyMessage
    ): void
    {
        /**
         * Arrange - Given
         */
        $request = new AuthorRequest();
        $rules = $request->rules();
        $messages = $request->messages();

        /**
         * Act - When
         */

        $validator = Validator::make($nationalitySet, $rules, $messages);
        $failedValidation = $validator->fails();
        $firstMessage = $validator->messages()->get($keyMessage)[0];

        /**
         * Assert - Then
         */

        $this->assertTrue($failedValidation, 'DADOS DE NACIONALIDADE NÃO FALHARAM NA VALIDAÇÃO');
        $this->assertEquals($expectedMessage, $firstMessage, 'A mensagem de erro não é a esperada');
    }

    /**
     * @param array $nationalitySet
     * @param string $expectedMessage
     * @param string $keyMessage
     * @return void
     * @test
     * @dataProvider dateBirthNotAccepted
     * Tests if the nationality provided is not accepted by the AuthorRequest validation rules and returns
     * the expected error message.
     */
    public function testDataDateBirthNotAccepted(
        array  $nationalitySet,
        string $expectedMessage,
        string $keyMessage
    ): void
    {
        /**
         * Arrange - Given
         */
        $request = new AuthorRequest();
        $rules = $request->rules();
        $messages = $request->messages();

        /**
         * Act - When
         */

        $validator = Validator::make($nationalitySet, $rules, $messages);
        $failedValidation = $validator->fails();
        $firstMessage = $validator->messages()->get($keyMessage)[0];

        /**
         * Assert - Then
         */

        $this->assertTrue($failedValidation, 'DADOS DE DATA DE NASCIMENTO NÃO FALHARAM NA VALIDAÇÃO');
        $this->assertEquals($expectedMessage, $firstMessage, 'A mensagem de erro não é a esperada');
    }

    /**
     * @return array
     */
    public function dataSetAccepted(): array
    {
        $data1 = [
            'name' => 'Nome Exemplo',
            'nationality' => 'Brasileiro',
            'dateBirth' => '01/01/2000'
        ];

        $data2 = [
            'name' => 'Outro Nome Exemplo',
            'nationality' => 'Americano',
            'dateBirth' => '01/01/1997'
        ];

        $data3 = [
            'name' => 'Nome Exemplo Novamente',
            'nationality' => 'Argentino',
            'dateBirth' => '15/05/1995'
        ];

        return [
            'AuthorRequest - acceptedData1' => [$data1],
            'AuthorRequest - acceptedData2' => [$data2],
            'AuthorRequest - acceptedData3' => [$data3]
        ];
    }

    /**
     * @return array
     */
    public function nameNotAccepted(): array
    {
        $data1 = [
            'name' => '',
            'nationality' => '',
            'dateBirth' => '01/01/2000'
        ];

        $data2 = [
            'name' => 123,
            'nationality' => 'Americano',
            'dateBirth' => '01/01/1997'
        ];

        $data3 = [
            'name' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
             Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
              galley of type and scrambled it to make a type specimen book. It hasdasd",
            'nationality' => 'Argentino',
            'dateBirth' => '15/05/1995'
        ];

        $data4 = [
            'nationality' => 'Português',
            'dateBirth' => '15/05/1996'
        ];

        return [
            "AuthorRequest - name = ''" => [$data1, "O campo 'nome' é obrigatório!", 'name'],
            'AuthorRequest - name = 123' => [$data2, "O nome informado deve ser um texto!", 'name'],
            'AuthorRequest - name = 255 chars' => [
                $data3,
                "O campo 'nome' deve ter no máximo 255 caracteres!",
                'name'
            ],
            'AuthorRequest - without name field' => [$data4, "O campo 'nome' é obrigatório!", 'name']
        ];
    }

    /**
     * @return array
     */
    public function nationalityNotAccepted(): array
    {
        $data1 = [
            'name' => 'Nome Exemplo',
            'nationality' => '',
            'dateBirth' => '01/01/2000'
        ];

        $data2 = [
            'name' => 'Nome Exemplo Novo',
            'dateBirth' => '01/01/2000'
        ];

        $data3 = [
            'name' => 'Nome Exemplo Again',
            'nationality' => 123,
            'dateBirth' => '01/01/2000'
        ];

        $data4 = [
            'name' => 'Nome Exemplo',
            'nationality' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem,
             Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a
              galley of type and scrambled it to make a type specimen book. It hasdasd",
            'dateBirth' => '01/01/2000'
        ];

        return [
            "AuthorRequest - nationality = ''" => [$data1, "O campo 'nacionalidade' é obrigatório!", 'nationality'],
            'AuthorRequest - without nationality field' => [
                $data2,
                "O campo 'nacionalidade' é obrigatório!",
                'nationality'
            ],
            'AuthorRequest - nationality = 123' => [
                $data3,
                "A nacionalidade informada deve ser um texto!",
                'nationality'
            ],
            'AuthorRequest - nationality = 255 chars' => [
                $data4,
                "O campo 'nacionalidade' deve ter no máximo 255 caracteres!",
                'nationality'
            ]
        ];
    }

    /**
     * @return array
     */
    public function dateBirthNotAccepted(): array
    {
        $data1 = [
            'name' => 'Nome Exemplo',
            'nationality' => 'Brasileiro',
            'dateBirth' => ''
        ];

        $data2 = [
            'name' => 'Nome Exemplo Novo',
            'nationality' => 'Brasileiro',
        ];

        $data3 = [
            'name' => 'Nome Exemplo Again',
            'nationality' => 'Brasileiro',
            'dateBirth' => '2000-01-01'
        ];

        $data4 = [
            'name' => 'Nome Exemplo Again',
            'nationality' => 'Brasileiro',
            'dateBirth' => '2000/01/01'
        ];

        $data5 = [
            'name' => 'Nome Exemplo Again',
            'nationality' => 'Brasileiro',
            'dateBirth' => '2000/15/01'
        ];

        return [
            "AuthorRequest - dateBirth = ''" => [$data1, "O campo 'Data de Nascimento' é obrigatório!", 'dateBirth'],
            'AuthorRequest - without dateBirth field' => [
                $data2,
                "O campo 'Data de Nascimento' é obrigatório!",
                'dateBirth'
            ],
            'AuthorRequest - dateBirth = 2000-01-01' => [
                $data3,
                "A data de nascimento informada deve estar no formato Dia/Mês/Ano",
                'dateBirth'
            ],
            'AuthorRequest - dateBirth = 2000/01/01' => [
                $data4,
                "A data de nascimento informada deve estar no formato Dia/Mês/Ano",
                'dateBirth'
            ],
            'AuthorRequest - dateBirth = 2000/15/01' => [
                $data5,
                "A data de nascimento informada deve estar no formato Dia/Mês/Ano",
                'dateBirth'
            ]
        ];
    }
}
