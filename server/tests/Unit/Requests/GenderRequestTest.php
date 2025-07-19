<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\Gender\GenderRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class GenderRequestTest extends TestCase
{
    /**
     * @return void
     * @test
     * The following checks are made:
     * - The data should be accepted by the validation rules.
     */
    public function testAcceptedData(): void
    {
        /**
         * Arrange - Given
         */
        $data1 = [
            'listNames' => [
                ['name' => 'Fiction'],
                ['name' => 'Non-Fiction']
            ]
        ];

        $data2 = [
            'singleName' => 'Science Fiction'
        ];
        $dataSet = [$data1, $data2];

        $request = new GenderRequest();

        foreach ($dataSet as $item) {
            /**
             * Act - When
             */
            $validator = Validator::make($item, $request->rules(), $request->messages());

            /**
             * Assert - Then
             */
            $this->assertFalse($validator->fails(), "Data not accepted.");
        }
    }

    /**
     * @param string $fieldName
     * @param array $dataRequest
     * @param string $expectedMessage
     * @return void
     * @test
     * @dataProvider listNamesNotAccepted
     * @dataProvider singleNameNotAccepted
     * The following checks are made:
     * - The data should not be accepted by the validation rules.
     * - The error message should match the expected message.
     */
    public function dataNotAccepted(string $fieldName, array $dataRequest, string $expectedMessage): void
    {
        /**
         * Arrange - Given
         */
        $genderRequest = new GenderRequest();
        $validator = Validator::make($dataRequest, $genderRequest->rules(), $genderRequest->messages());

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
     * @return array[]
     */
    public function listNamesNotAccepted(): array
    {
        $listName1 = [
            'listNames' => [
                ['name' => '']
            ]
        ];

        $listName2 = [
            'listNames' => [
                ['name' => str_repeat('a', 256)]
            ]
        ];

        $listName3 = [
            'listNames' => [
                ['name' => 123],
            ]
        ];

        $listName4 = [
            'listNames' => [
                ['name' => 'teste'],
                ['name' => 456],
            ]
        ];

        $listName5 = [];

        return [
            "GenderRequest - listName = ''" => ['listNames.0.name', $listName1, 'É obrigatório informar ao menos um nome!'],
            'GenderRequest - listName = 256 chars' => ['listNames.0.name', $listName2, 'O nome informado deve ter no máximo 255 caracteres!'],
            'GenderRequest - listName = 123' => ['listNames.0.name', $listName3, 'Todos os nomes informados devem ser um texto! Valor errado: 123'],
            'GenderRequest - listName[1] = 456' => ['listNames.1.name', $listName4, 'Todos os nomes informados devem ser um texto! Valor errado: 456'],
        ];
    }

    /**
     * @return array[]
     */
    public function singleNameNotAccepted(): array
    {
        $singleName1 = [
            'singleName' => ''
        ];

        $singleName2 = [
            'singleName' => 123
        ];

        $singleName3 = [
            'singleName' => str_repeat('a', 256) // 256 characters long
        ];

        $singleName4 = [];

        return [
            "GenderRequest - singleName = ''" => ['singleName', $singleName1, "O campo 'nome' é obrigatório!"],
            'GenderRequest - singleName = 123' => ['singleName', $singleName2, "O nome informado deve ser um texto!"],
            'GenderRequest - singleName = 256 chars' => ['singleName', $singleName3, "O nome informado deve ter no máximo 255 caracteres!"],
            'GenderRequest - without singleName field' => ['singleName', $singleName4, "O campo 'nome' é obrigatório!"]
        ];
    }
}
