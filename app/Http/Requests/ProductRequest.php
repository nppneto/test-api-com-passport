<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|min:3|max:80|unique:products',
            'description' => 'max:255',
            'price' => 'required',
        ];
    }

    /**
     * Verifica��o de falha na valida��o da requisi��o
     * $toBeValidated = O que tenho para ser validado (todos os campos da requisi��o)
     * $alreadyValidated = O que tenho validado (retorna somente os campos que passaram nas regras de valida��o)
     * @todo Implementa��o de um FormRequest base, para extender essa fun��o para todos.
     */
    public function fails()
    {
        $toBeValidated = $this->validationData();
        $alreadyValidated = $this->validated();

        $hasDiff = array_diff($alreadyValidated, $toBeValidated);

        if ($hasDiff) {
            return true;
        }

        return false;
    }
}
