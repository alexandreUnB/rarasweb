<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class IndicatorSource extends Model
{
    protected $table = 'indicator_sources';

    protected $fillable = ['abbreviation', 'name'];

    public static $rules = [
        'abbreviation' => 'required|min:2|max:20|unique:indicator_sources,abbreviation',
        'name' => 'required|min:2|max:45|unique:indicator_sources,name',
    ];

    public static $messages = [
        'abbreviation.required' => 'É necessário informar a sigla da fonte de indicador',
        'abbreviation.min' => 'A sigla da fonte de indicador deve ter no mínimo 2 caracteres',
        'abbreviation.max' => 'A sigla da fonte de indicador deve ter no máximo 20 caracteres',
        'abbreviation.unique' => 'Já existe uma fonte de indicador cadastrada com essa sigla',
        'name.required' => 'É necessário informar o nome completo da fonte de indicador',
        'name.min' => 'O nome da fonte de indicador deve ter no mínimo 2 caracteres',
        'name.max' => 'O nome da fonte de indicador deve ter no máximo 45 caracteres',
        'name.unique' => 'Já existe uma fonte de indicador cadastrada com esse nome',
    ];

    public function indicators()
    {
        return $this->hasMany('rarasweb\Indicator', 'indicatorSource_id');
    }
}
