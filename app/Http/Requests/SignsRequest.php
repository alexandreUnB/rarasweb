<?php

namespace rarasweb\Http\Requests;

use rarasweb\Http\Requests\Request;

class SignsRequest extends Request
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
            'name'=>'required',
            'frequency'=>'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'O Nome do sinal não pode ser vazio.',
            'frequency.required'=>'A Frequência não pode ser vazia.',
        ];
    }
}