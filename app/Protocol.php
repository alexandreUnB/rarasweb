<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $table = 'protocols';
    
    protected $fillable = ['document', 'name_pdf', 'disorder_id'];

    public static $rules = [
        'document' => 'required|min:10|max:50',
        'pdf' => 'required|mimes:pdf|max:5000',
        'disorder_id' => 'required|unique:protocols,disorder_id',
    ];

    public static $messages = [
        'document.required' => 'É necessário informar a portaria que aprovou o protocolo',
        'document.min' => 'A portaria deve ter no mínimo 10 caracteres',
        'document.max' => 'A portaria deve ter no máximo 50 caracteres',
        'pdf.required' => 'É necessário fazer o upload do arquivo do protocolo',
        'pdf.mimes' => 'O arquivo do protocolo deve estar no formato PDF',
        'pdf.size' => 'O arquivo do protocolo deve ser de no máximo 5MB',
        'disorder_id.required' => 'É necessário escolher uma doença para associar ao protocolo',
        'disorder_id.unique' => 'A doença escolhida já tem protocolo cadastrado',
    ];

    public function disorder()
    {
        return $this->belongsTo('rarasweb\Disorder', 'disorder_id');
    }
}
