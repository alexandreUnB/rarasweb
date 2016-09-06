<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Synonymous extends Model
{
    protected $table = 'synonyms';
    
    protected $fillable = ['name', 'disorder_id'];

    public static $rules = [
        'name' => 'required|min:2|max:150',
    ];

    public static $messages = [
        'name.required' => 'É necessário informar o nome do sinônimo',
        'name.min' => 'O sinônimo deve ter no mínimo 2 caracteres',
        'name.max' => 'O sinônimo deve ter no máximo 150 caracteres',
    ];

    public function disorder()
    {
        return $this->belongsTo('App\Disorder', 'disorder_id');
    }
}
