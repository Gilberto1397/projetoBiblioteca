<?php

namespace App\Repositories\Gender;

use App\Http\Requests\Gender\GenderRequest;
use App\Models\Gender;
use Illuminate\Support\Facades\DB;

class GenderRepositoryEloquent implements GenderRepository
{
    /**
     * @param  GenderRequest  $genderRequest
     * @throw PDOException
     * @return bool
     */
    public function createGenders(GenderRequest $genderRequest): bool
    {
        try {
            $genres = [];

            if (!empty($genderRequest->listNames)) {
                foreach ($genderRequest->listNames as $name) {
                    $genres[] = ['gender_name' => $name['name']];
                }
            } elseif (!empty($genderRequest->singleName)) {
                $genres[] = ['gender_name' => $genderRequest->singleName];
            }

            return Gender::insert($genres);
        } catch (\PDOException $exception) {
            return false;
        }
    }
}
