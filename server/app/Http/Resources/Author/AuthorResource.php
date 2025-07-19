<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'author';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->author_id,
            'name' => $this->author_name,
            'nationality' => $this->author_nationality,
            'dateBirth' => \DateTime::createFromFormat('Y-m-d', $this->author_date_birth)->format('d/m/Y'),
        ];
    }
}
