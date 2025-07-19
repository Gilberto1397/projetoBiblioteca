<?php

namespace App\Http\Requests\Publisher;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @property integer $id
 * @property string $name
 * @property string $countryOrigin
 * @property int $allPublishers
 */
class PublisherFiltersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'allPublishers' => ['integer', 'nullable', 'boolean'],
            'id' => ['integer', 'nullable'],
            'name' => ['string', 'nullable', 'max:255'],
            'countryOrigin' => ['string', 'nullable', 'max:255']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'allPublishers.integer' => "O parâmetro 'allPublishers' informado deve ser um número!",
            'allPublishers.boolean' => "O parâmetro 'allPublishers' é inválido!",

            'id.integer' => "O id informado deve ser um número!",

            'name.string' => "O nome informado deve ser um texto!",

            'countryOrigin.string' => "O nome do país de origem deve ser um texto! :input"
        ];
    }

    /**
     * Função para enviar as mensagens de erro em caso de falha na validação.
     * @param  Validator  $validator
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator)
    {
        $data = [
            'messages' => $validator->errors()->getMessages(),
            'error' => true
        ];

        throw new ValidationException($validator, new Response($data, 422));
    }
}
