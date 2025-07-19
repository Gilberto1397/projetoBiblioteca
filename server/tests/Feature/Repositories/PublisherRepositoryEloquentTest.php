<?php

namespace Feature\Repositories;

use App\Http\Requests\Publisher\PublisherFiltersRequest;
use App\Http\Requests\Publisher\PublisherRequest;
use App\Models\Publisher;
use App\Repositories\Publisher\PublisherRepositoryEloquent;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PublisherRepositoryEloquentTest extends TestCase
{
    /**
     * @return void
     * @test
     * The following checks are made:
     * - The method returns an array.
     * - If the array is not empty, each element is an instance of Publisher.
     */
    public function testGetAllPublishers()
    {
        $repository = new PublisherRepositoryEloquent();
        $result = $repository->getAllPublishers();

        $this->assertIsArray($result);

        if (count($result) > 0) {
            foreach ($result as $publisher) {
                $this->assertInstanceOf(Publisher::class, $publisher);
            }
        }
    }

    /**
     * @param PublisherFiltersRequest $request
     * @param int $expectedCount
     * @return void
     * @test
     * @dataProvider dataFilterPublishers
     */
    public function testFilteredPublishers(PublisherFiltersRequest $request, int $expectedCount)
    {
        DB::beginTransaction();

        $publisher1 = new Publisher();
        $publisher1->publisher_name = 'Nome muito específico para teste';
        $publisher1->publisher_country_origin = 'Pais muito específico para teste';
        $publisher1->save();

        $publisher2 = new Publisher();
        $publisher2->publisher_name = 'Nome muito específico para teste';
        $publisher2->publisher_country_origin = 'Pais Especifico para teste';
        $publisher2->save();

        $repository = new PublisherRepositoryEloquent();
        $result = $repository->filteredPublishers($request);

        $this->assertIsArray($result);
        $this->assertCount($expectedCount, $result);

        DB::rollBack();
    }

    /**
     * @return void
     * @test
     * The following checks are made:
     * - The method returns a boolean.
     */
    public function testCreatePublisher()
    {
        DB::beginTransaction();

        $publisherRequest = new PublisherRequest();
        $publisherRequest->name = 'Nome Teste';
        $publisherRequest->countryOrigin = 'Pais teste';
        $publisherEloquent = new PublisherRepositoryEloquent();
        $result = $publisherEloquent->createPublisher($publisherRequest);

        $this->assertIsBool($result, 'The return of the method is not a boolean');
        $this->assertTrue($result, 'The publisher was not created successfully');
        DB::rollBack();
    }

    /**
     * @return array[]
     */
    public function dataFilterPublishers()
    {
        $request1 = new PublisherFiltersRequest();
        $request1->id = 1;

        $request2 = new PublisherFiltersRequest();
        $request2->name = 'Nome muito específico para teste';

        $request3 = new PublisherFiltersRequest();
        $request3->countryOrigin = 'Pais muito específico para teste';

        $request4 = new PublisherFiltersRequest();
        $request4->name = 'Nome que não existe';

        return [
            'idFilter' => [$request1, 1],
            'nameFilter' => [$request2, 2],
            'countryFilter' => [$request3, 1],
            'nameFilterNoResults' => [$request4, 0]
        ];
    }
}
