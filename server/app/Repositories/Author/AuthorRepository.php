<?php

namespace App\Repositories\Author;

use App\Http\Requests\Author\AuthorRequest;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

interface AuthorRepository
{
    /**
     * Create a new author in the database.
     * @param  AuthorRequest  $authorRequest
     * @return bool
     */
    public function createAuthor(AuthorRequest $authorRequest):bool;

    /**
     * Returns all registered authors.
     * @return Author[]
     */
    public function getAuthors();
}
