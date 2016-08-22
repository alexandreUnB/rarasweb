<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $table = 'specialties';

    protected $fillable = ['name', 'cbo'];

    public static $rules = [
        'name' => 'required|min:5|max:50|unique:specialties,name',
        'cbo' => 'required|size:7|unique:specialties,cbo',
    ];

    public static $messages = [
        'name.required' => 'É necessário informar o nome da especialidade',
        'name.min' => 'A especialidade deve ter no mínimo 5 caracteres',
        'name.max' => 'A especialidade deve ter no máximo 50 caracteres',
        'name.unique' => 'Já existe uma especialidade com esse nome',
        'cbo.required' => 'É necessário informar o CBO da especialidade',
        'cbo.size' => 'O CBO deve conter 7 caracteres',
        'cbo.unique' => 'Já existe uma especialidade com esse CBO',
    ];

    public function disorders()
    {
        return $this->belongsToMany('rarasweb\Disorder', 'disorder_specialty', 'specialty_id', 'disorder_id');
    }

    public function professionals()
    {
        return $this->belongsToMany('rarasweb\Professional', 'professional_specialty',
            'specialty_id', 'professional_id');
    }

    public function treatmentCenters()
    {
        return $this->belongsToMany('rarasweb\TreatmentCenter', 'specialty_treatmentcenter',
            'specialty_id', 'treatmentCenter_id');
    }
}
