<?php

namespace rarasweb\Http\Requests;

use rarasweb\Http\Requests\Request;

class SynonymsRequest extends Request
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
            'synonymous'=>'required|unique:synonyms' //'required|min:3' limita a quantidade de caracteres
        ];
    }
}
