<?php

namespace App\Http\Resources\Book;

use App\Http\Resources\Author\AuthorResource;
use App\Http\Resources\Gender\GenderResource;
use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string
     */
    public static $wrap = 'book';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->book_id,
            'title' => $this->book_title,
            'isbn' => $this->book_isbn,
            'publication_date' => DateTime::createFromFormat(
                'Y-m-d',
                $this->book_publication_date
            )->format('d/m/Y'),
            'inStock' => $this->book_in_stock,
            'author' => new AuthorResource($this->author),
            'gender' => new GenderResource($this->gender),
        ];
    }
}
