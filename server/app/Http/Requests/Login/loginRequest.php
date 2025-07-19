<?php

namespace App\Http\Requests\Login;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @property string $email
 * @property string $password
 */
class loginRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
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
            'email.required' => "O campo 'email' é obrigatório!",
            'email.email' => "O email informado é inválido!",

            'password.required' => "O campo 'senha' é obrigatório!",
            'password.string' => "A senha informada não possui um formato válido!",
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
