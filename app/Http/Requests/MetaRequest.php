<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MetaRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'inscricoes' => 'required|integer',
            'entrevistas' => 'required|integer',
            'aprovados' => 'required|integer',
            'data_de_entrega' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'inscricoes.required' => 'Inscrições é um campo obrigatório',
            'inscricoes.integer' => 'Inscrições deve ser um valor inteiro',
            'entrevistas.required' => 'Entrevistas é um campo obrigatório',
            'entrevistas.integer' => 'Entrevistas deve ser um valor inteiro',
            'aprovados.required' => 'Aprovados é um campo obrigatório',
            'aprovados.integer' => 'Aprovados deve ser um valor inteiro',
            'data_de_entrega.required' => 'Data de entrega é um campo obrigatório',
        ];
    }
}
