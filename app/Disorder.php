<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Disorder extends Model
{
    protected $table = 'disorders';
    
    protected $fillable = ['name', 'name_portuguese', 'orphanumber', 'description', 'drugs', 'procedures', 'references', 'disorderType_id'];

    protected $casts = [
        'orphanumber' => 'string',
    ];

    public static $rules = [
        'name' => 'required|min:4|max:120|unique:disorders,name',
        'name_portuguese' => 'min:4|max:120|unique:disorders,name_portuguese',
        'orphanumber' => 'required|digits_between:1,6|unique:disorders,orphanumber',
        'description' => 'max:10000',
        'drugs' => 'max:5000',
        'procedures' => 'max:5000',
        'references' => 'max:5000',
        'disorderType_id' => 'required',
    ];

    public static $messages = [
        'name.required' => 'É necessário informar um nome para a desordem',
        'name.min' => 'O nome da desordem deve ter no mínimo 5 caracteres',
        'name.max' => 'O nome da desordem deve ter no máximo 120 caracteres',
        'name.unique' => 'Já existe uma desordem cadastrada com esse nome',
        'name_portuguese.min' => 'O nome em português da desordem deve ter no mínimo 5 caracteres',
        'name_portuguese.max' => 'O nome em português da desordem deve ter no máximo 120 caracteres',
        'name_portuguese.unique' => 'Já existe uma desordem cadastrada com esse nome em português',
        'orphanumber.required' => 'É necessário informar um orphanumber para a desordem',
        'orphanumber.digits_between' => 'O orphanumber da desordem deve ter no máximo 6 dígitos',
        'orphanumber.unique' => 'Já existe uma desordem cadastrada com esse orphanumber',
        'description.max' => 'A descrição da desordem deve ter no máximo 10000 caracteres',
        'drugs.max' => 'Os medicamentos da desordem devem ter no máximo 5000 caracteres',
        'procedures.max' => 'Os procedimentos da desordem devem ter no máximo 5000 caracteres',
        'references.max' => 'A referência bibliográfica da desordem deve ter no máximo 5000 caracteres',
        'disorderType_id.required' => 'É necessário escolher um tipo para a desordem',
    ];

    public function disorderType()
    {
        return $this->belongsTo('App\DisorderType', 'disorderType_id');
    }

    public function protocol()
    {
        return $this->hasOne('App\Protocol', 'disorder_id');
    }

    public function synonyms()
    {
        return $this->hasMany('App\Synonymous', 'disorder_id');
    }

    public function signs()
    {
        return $this->belongsToMany('App\Sign', 'disorder_sign', 'disorder_id', 'sign_id');
    }

    public function references()
    {
        return $this->belongsToMany('App\Reference', 'disorder_reference', 'disorder_id', 'reference_id');
    }

    public function indicators()
    {
        return $this->hasMany('App\Indicator', 'disorder_id');
    }

}
