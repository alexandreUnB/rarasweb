<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
    protected $table = 'signs';

    protected $fillable = ['name', 'frequency'];

    public static $rules = [
        'name' => 'required|min:5|max:120',
        'frequency' => 'required',
    ];

    public static $messages = [
        'name.required' => 'É necessário informar um nome para o sinal',
        'name.min' => 'O nome da sinal deve ter no mínimo 5 caracteres',
        'name.max' => 'O nome da sinal deve ter no máximo 120 caracteres',
        'frequency.required' => 'É necessário informar uma frequência para o sinal',
    ];

    public function disorders()
    {
        return $this->belongsToMany('App\Disorder', 'disorder_sign', 'sign_id', 'disorder_id');
    }
}