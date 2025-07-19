<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @property string $name
 * @property string $cpf
 * @property string $email
 * @property string $password
 * @property string $telephone
 * @property \DateTime $dateBirth
 */
class UserRequest extends FormRequest
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
            'password' => strip_tags($this->password)
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
            'cpf' => ['required', 'digits:11', 'unique:users,user_cpf'],
            'email' => ['required', 'email', 'max:255', 'unique:users,user_cpf'],
            'password' => ['required', 'string', 'max:255'],
            'telephone' => ['digits:11'],
            'dateBirth' => ['required', 'date_format:d/m/Y']
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
            'name.string' => "Nome informado inválido!",
            'name.required' => "O campo 'nome' é obrigatório!",
            'name.max' => "O campo 'nome' deve ter no máximo :max caracteres!",

            'cpf.required' => "O campo 'cpf' é obrigatório!",
            'cpf.digits' => "O campo 'cpf' deve ter :digits caracteres e ser composto apenas por números!",
            'cpf.unique' => "Este CPF já existe na base de dados!",

            'email.email' => "Email informado inválido!",
            'email.required' => "O campo 'email' é obrigatório!",
            'email.max' => "O campo 'email' deve ter no máximo :max caracteres!",

            'password.string' => "Senha informada inválida!",
            'password.required' => "O campo 'senha' é obrigatório!",
            'password.max' => "O campo 'senha' deve ter no máximo :max caracteres!",

            'telephone.digits' => "O telefone deve conter :digits dígitos e apenas números!",

            'dateBirth.date_format' => "A data de nascimento informada deve estar no formato Dia/Mês/Ano",
            'dateBirth.required' => "O campo 'Data de Nascimento' é obrigatório!"
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
