<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $table = 'references';
    
    protected $fillable = ['source', 'reference', 'map_relation'];

    public static $rules = [
        'source' => 'required',
        'reference' => 'required|min:2|max:10',
        'map_relation' => 'min:5|max:100',
    ];

    public static $messages = [
        'source.required' => 'É necessário informar a fonte da referência',
        'reference.required' => 'É necessário informar a referência',
        'reference.min' => 'A referência deve ter no mínimo 2 caracteres',
        'reference.max' => 'A referência deve ter no máximo 10 caracteres',
        'map_relation.min' => 'O map relation referência deve ter no mínimo 5 caracteres',
        'map_relation.max' => 'O map relation referência deve ter no máximo 100 caracteres',
    ];

    public function disorders()
    {
        return $this->belongsToMany('App\Disorder', 'disorder_reference', 'reference_id', 'disorder_id');
    }
}
