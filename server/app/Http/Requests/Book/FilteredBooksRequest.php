<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @property string $title
 * @property int $author
 * @property int $gender
 * @property string $isbn
 * @property int $allBooks
 */
class FilteredBooksRequest extends FormRequest
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
            'allBooks' => ['integer', 'boolean'],
            'title' => ['string', 'nullable', 'max:255'],
            'author' => ['integer', 'nullable'],
            'gender' => ['integer', 'nullable'],
            'isbn' => ['string', 'nullable']
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
            'allBooks.integer' => "O parâmetro 'allBooks' informado deve ser um número!",
            'allBooks.boolean' => "O parâmetro 'allBooks' é inválido!",

            'title.string' => "O título informado é inválido!",
            'author.integer' => "O autor informado é inválido!",
            'gender.integer' => "O gênero informado é inválido!",
            'isbn.string' => "O código ISBN informado é inválido!"
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
