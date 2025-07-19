<?php

namespace App\Repositories\Gender;

use App\Http\Requests\Gender\GenderRequest;

interface GenderRepository
{
    public function createGenders(GenderRequest $genderRequest): bool;
}
