<?php

namespace App\Http\Requests\Publisher;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @property string $name
 * @property string $countryOrigin
 */
class PublisherRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => strip_tags($this->name),
            'countryOrigin' => strip_tags($this->countryOrigin)
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'countryOrigin' => ['required', 'string', 'max:255']
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
            'name.string' => "O nome informado deve ser um texto!",
            'name.required' => "O campo 'nome' é obrigatório!",
            'name.max' => "O nome informado deve ter no máximo 255 caracteres!",

            'countryOrigin.string' => "O nome do país de origem deve ser um texto!",
            'countryOrigin.required' => "O campo 'país de origem' é obrigatório!",
            'countryOrigin.max' => "O país de origem informado deve ter no máximo 255 caracteres!"
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
