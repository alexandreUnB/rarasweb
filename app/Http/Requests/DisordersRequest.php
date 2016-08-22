<?php

namespace rarasweb\Http\Requests;

use rarasweb\Http\Requests\Request;

class DisordersRequest extends Request
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
            'orphanumber'=>'required|min:2|max:6',
            'desorder_type'=>'required',

        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'O Nome da desordem não pode ser vazio.',
            'orphanumber.required'=>'O Orphanumber não pode ser vazio.',
            'disorder_type.required'=>'O Tipo da desordem não pode ser vazio.',
        ];
    }
}
