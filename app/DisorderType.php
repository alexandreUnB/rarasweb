<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisorderType extends Model
{
    protected $table = 'disorder_types';

    protected $fillable = ['name'];

    public static $rules = [
        'name' => 'required|min:5|max:100|unique:disorder_types,name',
    ];

    public static $messages = [
        'name.required' => 'É necessário informar o nome do tipo de desordem',
        'name.min' => 'O tipo de desordem deve ter no mínimo 5 caracteres',
        'name.max' => 'O tipo de desordem deve ter no máximo 100 caracteres',
        'name.unique' => 'Já existe um tipo de desordem com esse nome',
    ];

    public function disorders()
    {
        return $this->hasMany('App\Disorder', 'disorderType_id');
    }
}
