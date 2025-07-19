<?php

namespace App\Repositories\Publisher;

use App\Http\Requests\Publisher\PublisherFiltersRequest;
use App\Http\Requests\Publisher\PublisherRequest;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface PublisherRepository
{
    /**
     * Creates a new publisher in the database.
     * @param  PublisherRequest  $publisherRequest
     * @throw PDOException
     * @return bool
     */
    public function createPublisher(PublisherRequest $publisherRequest): bool;

    /**
     * Return all filtered publishers them according to the parameters entered.
     * @param  PublisherFiltersRequest  $publisherFiltersRequest
     * @return Publisher[]|Builder[]|Collection
     */
    public function filteredPublishers(PublisherFiltersRequest $publisherFiltersRequest);

    /**
     * Return all publishers.
     * @return Publisher[]|array
     */
    public function getAllPublishers(): array;
}
