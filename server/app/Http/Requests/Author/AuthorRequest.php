<?php

namespace App\Http\Requests\Author;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * @property string name
 * @property string nationality
 * @property \DateTime dateBirth
 */
class AuthorRequest extends FormRequest
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
            'nationality' => strip_tags($this->nationality)
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
            'nationality' => ['required', 'string', 'max:255'],
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
            'name.string' => "O nome informado deve ser um texto!",
            'name.required' => "O campo 'nome' é obrigatório!",
            'name.max' => "O campo 'nome' deve ter no máximo 255 caracteres!",

            'nationality.string' => "A nacionalidade informada deve ser um texto!",
            'nationality.required' => "O campo 'nacionalidade' é obrigatório!",
            'nationality.max' => "O campo 'nacionalidade' deve ter no máximo 255 caracteres!",

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
