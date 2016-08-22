<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class IndicatorSource extends Model
{
    protected $table = 'indicator_sources';

    protected $fillable = ['name'];

    public static $rules = [
        'name' => 'required|min:2|max:45|unique:indicator_sources,name'
    ];

    public static $messages = [
        'name.required' => 'É necessário informar a fonte de indicador',
        'name.min' => 'A fonte de indicador deve ter no mínimo 2 caracteres',
        'name.max' => 'A fonte de indicador deve ter no máximo 45 caracteres',
        'name.unique' => 'Já existe uma fonte de indicador cadastrada com esse nome',
    ];

    public function indicators()
    {
        return $this->hasMany('rarasweb\Indicator', 'indicatorSource_id');
    }
}
