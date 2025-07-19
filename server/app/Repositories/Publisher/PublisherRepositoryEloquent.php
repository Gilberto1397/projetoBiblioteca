<?php

namespace App\Repositories\Publisher;

use App\Http\Requests\Publisher\PublisherFiltersRequest;
use App\Http\Requests\Publisher\PublisherRequest;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class PublisherRepositoryEloquent implements PublisherRepository
{
    /**
     * Creates a new publisher in the database.
     * @param  PublisherRequest  $publisherRequest
     * @throw PDOException
     * @return bool
     */
    public function createPublisher(PublisherRequest $publisherRequest): bool
    {
        try {
            $publisher = new Publisher();
            $publisher->publisher_name = $publisherRequest->name;
            $publisher->publisher_country_origin = $publisherRequest->countryOrigin;
            return $publisher->save();
        } catch (\PDOException $exception) {
            return false;
        }
    }

    /**
     * Return all publishers or filter them according to the parameters entered.
     * @param  PublisherFiltersRequest  $publisherFiltersRequest
     * @return Publisher[]|Builder[]|Collection|array
     */
    public function filteredPublishers(PublisherFiltersRequest $publisherFiltersRequest)
    {
        $publishers = $this->filterPublisher($publisherFiltersRequest);

        if ($publishers->doesntExist()) {
            return [];
        }

        return $publishers->get()->all();
    }

    /**
     * Filters publishers according to the filters provided.
     * @param  PublisherFiltersRequest  $publisherFiltersRequest
     * @return Builder
     */
    private function filterPublisher(PublisherFiltersRequest $publisherFiltersRequest): Builder
    {
        $publishers = Publisher::query();

        if (!empty($publisherFiltersRequest->id)) {
            $publishers->where('publisher_id', $publisherFiltersRequest->id);
        }
        if (!empty($publisherFiltersRequest->name)) {
            $publishers->where('publisher_name', 'ilike', "%{$publisherFiltersRequest->name}%");
        }
        if (!empty($publisherFiltersRequest->countryOrigin)) {
            $publishers->where('publisher_country_origin', $publisherFiltersRequest->countryOrigin);
        }

        return $publishers;
    }

    /**
     * Return all publishers.
     * @return Publisher[]|array
     */
    public function getAllPublishers(): array
    {
        $publishers = Publisher::all();

        if ($publishers->count() === 0) {
            return [];
        }
        return $publishers->all();
    }
}
