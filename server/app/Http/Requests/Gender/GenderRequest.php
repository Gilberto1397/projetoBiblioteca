<?php

namespace App\Http\Requests\Gender;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @property array $listNames
 * @property string $singleName
 */
class GenderRequest extends FormRequest
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
        if (!empty($this->listNames)) {
            $listsNames = [];

            foreach ($this->listNames as $name) {
                $listsNames[]['name'] = strip_tags($name['name']);
            }
            $this->merge([
                'listNames' => $listsNames,
            ]);
        }

        if (!empty($this->singleName)) {
            $this->merge([
                'singleName' => strip_tags($this->singleName)
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'listNames.*.name' => ['required', 'string', 'max:255'],
            'singleName' => ['required_without:listNames', 'string', 'max:255']
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
            'listNames.*.name.required' => "É obrigatório informar ao menos um nome!",
            'listNames.*.name.string' => "Todos os nomes informados devem ser um texto! Valor errado: :input",
            'listNames.*.name.max' => "O nome informado deve ter no máximo 255 caracteres!",

            'singleName.string' => "O nome informado deve ser um texto!",
            'singleName.required_without' => "O campo 'nome' é obrigatório!",
            'singleName.max' => "O nome informado deve ter no máximo 255 caracteres!"
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

        throw new ValidationException($validator, new Response($data, 406));
    }
}
