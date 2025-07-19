<?php

namespace App\Repositories\Author;

use App\Http\Requests\Author\AuthorRequest;
use App\Models\Author;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class AuthorRepositoryEloquent implements AuthorRepository
{
    /**
     * @param  AuthorRequest  $authorRequest
     * @return bool
     */
    public function createAuthor(AuthorRequest $authorRequest): bool
    {
        try {
            $dateBirth = DateTime::createFromFormat('d/m/Y', $authorRequest->dateBirth);

            $author = new Author();
            $author->author_name = $authorRequest->name;
            $author->author_nationality = $authorRequest->nationality;
            $author->author_date_birth = $dateBirth->format('Y-m-d');
            return $author->save();
        } catch (\PDOException $exception) {
            return false;
        }
    }

    /**
     * Returns all registered authors.
     * @return Author[]
     */
    public function getAuthors()
    {
        return Author::all()->all();
    }
}
