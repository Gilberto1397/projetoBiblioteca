<?php

namespace App\Http\Requests\Loan;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @property integer $user
 * @property array $bookList
 */
class LoanRequest extends FormRequest
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
            'user' => ['required', 'integer', 'exists:users,user_id'],
            'bookList' => ['required'],
            'bookList.*.id' => ['integer', 'exists:books,book_id'],
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
            'user.required' => "O campo 'Usuário' é obrigatório!",
            'user.integer' => "O usuário informado é inválido!",
            'user.exists' => "O usuário informado não está cadastrado no sistema!",

            'bookList.required' => "O campo 'Livros' é obrigatório!",
            'bookList.*.id.integer' => "Valor inválido para o livro informado! ':input'",
            'bookList.*.id.exists' => "O seguinte código de livro não está cadastrado no sistema: :input"
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
