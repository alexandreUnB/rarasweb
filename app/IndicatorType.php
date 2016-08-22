<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class IndicatorType extends Model
{
    protected $table = 'indicator_types';

    protected $fillable = ['name'];

    public static $rules = [
        'name' => 'required|min:5|max:45|unique:indicator_types,name'
    ];

    public static $messages = [
        'name.required' => 'É necessário informar o tipo de indicador',
        'name.min' => 'O tipo de indicador deve ter no mínimo 5 caracteres',
        'name.max' => 'O tipo de indicador deve ter no máximo 45 caracteres',
        'name.unique' => 'Já existe um tipo de indicador cadastrado com esse nome',
    ];

    public function indicators()
    {
        return $this->hasMany('rarasweb\Indicator', 'indicatorType_id');
    }
}
