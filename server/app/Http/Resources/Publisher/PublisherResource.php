<?php

namespace App\Http\Resources\Publisher;

use Illuminate\Http\Resources\Json\JsonResource;

class PublisherResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'publisher';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->publisher_id, //@phpstan-ignore-line
            'name' => $this->publisher_name, //@phpstan-ignore-line
            'countryOrigin' => $this->publisher_country_origin, //@phpstan-ignore-line
        ];
    }
}
