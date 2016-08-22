<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class Law extends Model
{
    protected $table = 'laws';

    protected $fillable = ['name_law', 'name_pdf', 'resume'];

    public static $rules = [
        'name_law' => 'required|min:10|max:50|unique:laws,name_law',
        'pdf' => 'required|mimes:pdf|max:5000',
        'resume' => 'required|min:10|max:5000',
    ];

    public static $messages = [
        'name_law.required' => 'É necessário informar o nome da lei',
        'name_law.min' => 'O nome da lei deve ter no mínimo 10 caracteres',
        'name_law.max' => 'O nome da lei deve ter no máximo 50 caracteres',
        'name_law.unique' => 'Já existe uma lei cadastrada com esse nome',
        'pdf.required' => 'É necessário fazer o upload do arquivo da lei',
        'pdf.mimes' => 'O arquivo da lei deve estar no formato PDF',
        'pdf.size' => 'O arquivo da lei deve ser de no máximo 5MB',
        'resume.required' => 'É necessário preencher o resumo da lei',
        'resume.min' => 'O resumo da lei deve ter no mínimo 10 caracteres',
        'resume.max' => 'O resumo da lei deve ter no máximo 5000 caracteres',
    ];
}
