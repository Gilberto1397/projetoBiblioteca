<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;


/**
 * @property string $title
 * @property string $isbn
 * @property \DateTime $publicationDate
 * @property integer $inStock
 * @property integer $author
 * @property integer[] $publishersList
 * @property integer $gender
 */
class BookRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'isbn' => ['required', 'string', 'max:255'],
            'publicationDate' => ['required', 'date_format:d/m/Y'],
            'inStock' => ['required', 'integer'],
            'author' => ['required', 'integer', 'exists:authors,author_id'],
            'publishersList' => ['required'],
            'publishersList.*' => ['integer', 'exists:publishers,publisher_id'],
            'gender' => ['required', 'integer', 'exists:genres,gender_id']
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
            'title.string' => "O título informado é inválido!",
            'title.required' => "O campo 'título' é obrigatório!",
            'title.max' => "O campo 'título' deve ter no máximo 255 caracteres!",

            'isbn.string' => "O ISBN informado é inválido!",
            'isbn.required' => "O campo 'ISBN' é obrigatório!",
            'isbn.max' => "O campo 'ISBN' deve ter no máximo 255 caracteres!",

            'publicationDate.date_format' => "A data de publicação informada deve estar no formato Dia/Mês/Ano",
            'publicationDate.required' => "O campo 'Data de Publicação' é obrigatório!",

            'inStock.integer' => "A quantidade de livros em estoque informada é inválida!",
            'inStock.required' => "O campo 'Quantidade em Estoque' é obrigatório!",

            'author.required' => "O campo 'Autor' é obrigatório!",
            'author.integer' => "O autor informado é inválido!",
            'author.exists' => "O autor informado para este livro não está cadastrado no sistema!",

            'publishersList.required' => "O campo 'Editora' é obrigatório!",
            'publishersList.*.integer' => "A editora informada é inválida!",
            'publishersList.*.exists' => "A editora :input informada para este livro não está cadastrada no sistema!",

            'gender.required' => "O campo 'Gênero' é obrigatório!",
            'gender.integer' => "O gênero informado é inválido!",
            'gender.exists' => "O gênero informado para este livro não está cadastrado no sistema!"
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'title' => strip_tags($this->title),
            'isbn' => strip_tags($this->isbn)
        ]);
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
