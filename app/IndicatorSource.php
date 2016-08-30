<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IndicatorSource extends Model
{
    protected $table = 'indicator_sources';

    protected $fillable = ['abbreviation', 'name'];

    public static $rules = [
        'name' => 'required|min:2|max:200|unique:indicator_sources,name',
        'abbreviation' => 'required|min:2|max:20|unique:indicator_sources,abbreviation',
    ];

    public static $messages = [
        'name.required' => 'É necessário informar o nome completo da fonte de indicador',
        'name.min' => 'O nome da fonte de indicador deve ter no mínimo 2 caracteres',
        'name.max' => 'O nome da fonte de indicador deve ter no máximo 200 caracteres',
        'name.unique' => 'Já existe uma fonte de indicador cadastrada com esse nome',
        'abbreviation.required' => 'É necessário informar a sigla da fonte de indicador',
        'abbreviation.min' => 'A sigla da fonte de indicador deve ter no mínimo 2 caracteres',
        'abbreviation.max' => 'A sigla da fonte de indicador deve ter no máximo 20 caracteres',
        'abbreviation.unique' => 'Já existe uma fonte de indicador cadastrada com essa sigla',
    ];

    public function indicators()
    {
        return $this->hasMany('App\Indicator', 'indicatorSource_id');
    }
}
