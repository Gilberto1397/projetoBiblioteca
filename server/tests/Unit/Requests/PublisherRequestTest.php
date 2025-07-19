<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Publisher\PublisherRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class PublisherRequestTest extends TestCase
{
    /**
     * @param string $fieldName
     * @param array $dataRequest
     * @param string $expectedMessage
     * @return void
     * @test
     * @dataProvider countryOriginNotAccepted
     * @dataProvider namesNotAccepted
     */
    public function testDataNotAccepted(string $fieldName, array $dataRequest, string $expectedMessage): void
    {
        /**
         * Arrange - Given
         */
        $publisherRequest = new PublisherRequest();
        $validator = Validator::make($dataRequest, $publisherRequest->rules(), $publisherRequest->messages());

        /**
         * Act - When
         */
        $validated = $validator->fails();
        $firstMessage = $validator->messages()->get($fieldName)[0];

        /**
         * Assert - Then
         */
        $this->assertTrue($validated, "The data should not be accepted - '{$fieldName}'");
        $this->assertSame($firstMessage, $expectedMessage, "Wrong error message for '{$fieldName}'");
    }

    /**
     * @return void
     * @test
     * The following checks are made:
     * - The data should be accepted by the validation rules.
     */
    public function testDataAccepted(): void
    {
        /**
         * Arragne - Given
         */
        $request1 = [
            'name' => 'Editora Exemplo',
            'countryOrigin' => 'Brasil'
        ];

        $request2 = [
            'name' => 'Editora Teste',
            'countryOrigin' => 'Estados Unidos'
        ];

        $dataSet = [$request1, $request2];
        $publisherRequest = new PublisherRequest();
        $rules = $publisherRequest->rules();

        foreach ($dataSet as $request) {
            /**
             * Act - When
             */
            $validator = Validator::make($request, $rules);
            $validated = $validator->fails();

            /**
             * Assert - Then
             */
            $this->assertFalse($validated, 'The data are not accepted.');
        }
    }

    /**
     * @return array[]
     */
    public function namesNotAccepted(): array
    {
        $name1 = [
            'name' => '',
            'countryOrigin' => 'Brasil'
        ];

        $name2 = [
            'name' => 123,
            'countryOrigin' => 'Brasil'
        ];

        $name3 = [
            'name' => str_repeat('a', 256), // 256 characters long
            'countryOrigin' => 'Brasil'
        ];

        $name4 = [
            'countryOrigin' => 'Brasil'
        ];

        return [
            "PublisherRequest - name = ''" => ['name', $name1, "O campo 'nome' é obrigatório!"],
            'PublisherRequest - name = 123' => ['name', $name2, "O nome informado deve ser um texto!"],
            'PublisherRequest - name = 256 chars' => [
                'name',
                $name3,
                "O nome informado deve ter no máximo 255 caracteres!"
            ],
            'PublisherRequest - without name field' => [
                'name',
                $name4,
                "O campo 'nome' é obrigatório!"
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function countryOriginNotAccepted(): array
    {
        $countryOrigin1 = [
            'name' => 'Editora Exemplo',
            'countryOrigin' => ''
        ];

        $countryOrigin2 = [
            'name' => 'Editora Exemplo',
            'countryOrigin' => 123
        ];

        $countryOrigin3 = [
            'name' => 'Editora Exemplo',
            'countryOrigin' => str_repeat('a', 256) // 256 characters long
        ];

        $countryOrigin4 = [
            'name' => 'Editora Exemplo'
        ];

        return [
            "PublisherRequest - countryOrigin = ''" => [
                'countryOrigin',
                $countryOrigin1,
                "O campo 'país de origem' é obrigatório!"
            ],
            'PublisherRequest - countryOrigin = 123' => [
                'countryOrigin',
                $countryOrigin2,
                "O nome do país de origem deve ser um texto!"
            ],
            'PublisherRequest - countryOrigin = 256 chars' => [
                'countryOrigin',
                $countryOrigin3,
                "O país de origem informado deve ter no máximo 255 caracteres!"
            ],
            'PublisherRequest - without countryOrigin field' => [
                'countryOrigin',
                $countryOrigin4,
                "O campo 'país de origem' é obrigatório!"
            ]
        ];
    }
}
