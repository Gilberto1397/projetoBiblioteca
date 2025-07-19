<?php

namespace Feature\Repositories;

use App\Http\Requests\Gender\GenderRequest;
use App\Repositories\Gender\GenderRepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GenderRepositoryEloquentTest extends TestCase
{
    /**
     * @return void
     * @test
     * @dataProvider dataGenres
     * The current assertions are made:
     * - The result is a boolean
     * - The result is true
     */
    public function testCreateGendersTrue(GenderRequest $genderRequest, bool $expectedResult)
    {
        DB::beginTransaction();

        $genderRepository = new GenderRepositoryEloquent();
        $result = $genderRepository->createGenders($genderRequest);

        $this->assertIsBool($result, 'The result is not a boolean');
        $this->assertSame($expectedResult, $result, 'The result does not match the expected value');

        DB::rollBack();
    }

    /**
     * @return array[]
     */
    public function dataGenres()
    {
        $genres1 = new GenderRequest();
        $genres1->listNames = [
            ['name' => 'Teste 1'],
            ['name' => 'Teste 2'],
        ];

        $genres2 = new GenderRequest();
        $genres2->singleName = 'Teste 3';

        return [
            'multiple genres' => [$genres1, true],
            'single genre' => [$genres2, true]
        ];
    }
}
