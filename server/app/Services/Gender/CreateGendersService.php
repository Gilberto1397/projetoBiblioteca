<?php

namespace App\Services\Gender;

use App\Http\Requests\Gender\GenderRequest;
use App\Repositories\Gender\GenderRepository;

class CreateGendersService
{
    private GenderRepository $genderRepository;

    public function __construct(GenderRepository $genderRepository)
    {
        $this->genderRepository = $genderRepository;
    }

    /**
     * @param  GenderRequest  $genderRequest
     * @return object
     */
    public function createGenders(GenderRequest $genderRequest)
    {
        $response = (object)[
            'message' => 'Gênero criado com sucesso!',
            'statusCode' => 201,
            'error' => false
        ];
        $saved = $this->genderRepository->createGenders($genderRequest);

        if (!$saved) {
            $response = (object)[
                'message' => 'Falha ao criar genêro',
                'statusCode' => 500,
                'error' => true
            ];
        }

        return $response;

    }
}
