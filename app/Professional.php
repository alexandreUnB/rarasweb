<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    protected $table = 'professionals';

    protected $fillable = ['name', 'surname', 'active', 'council_number', 'city',
        'uf', 'email', 'profession', 'telephone', 'ddd', 'facebook', 'twitter'];

    public static $rules = [
        'name' => 'required|min:2|max:100',
        'surname' => 'required|min:2|max:100',
        'active' => 'required',
        'council_number' => 'numeric|digits_between:2,5|unique:professionals,council_number',
        'city' => 'min:2|max:45',
        'uf' => 'alpha|size:2',
        'email' => 'email|min:8|max:40',
        'profession' => 'min:2|max:40',
        'telephone' => 'numeric|digits_between:7,9',
        'ddd' => 'numeric|digits:2',
        'facebook' => 'url|min:10|max:60',
        'twitter' => 'url|min:10|max:60',
    ];

    public static $messages = [
        'name.required' => 'É necessário informar o nome do profissional',
        'name.min' => 'O nome do profissional deve ter no mínimo 2 caracteres',
        'name.max' => 'O nome do profissional deve ter no máximo 100 caracteres',
        'surname.required' => 'É necessário informar o sobrenome do profissional',
        'surname.min' => 'O sobrenome do profissional deve ter no mínimo 2 caracteres',
        'surname.max' => 'O sobrenome do profissional deve ter no máximo 100 caracteres',
        'active.required' => 'É necessário informar se o profissional está ativo ou não',
        'council_number.numeric' => 'O número do conselho do profissional deve conter apenas números',
        'council_number.digits_between' => 'O número de conselho do profissional deve ter entre 2 e 5 dígitos',
        'council_number.unique' => 'Já existe um profissional cadastrado com esse número de conselho',
        'city.min' => 'A cidade do profissional deve ter no mínimo 2 caracteres',
        'city.max' => 'A cidade do profissional deve ter no máximo 45 caracteres',
        'uf.alpha' => 'A UF do profissional deve conter apenas letras',
        'uf.size' => 'A UF do profissional deve ser de tamanho 2',
        'email.email' => 'O email do profissional deve ser um endereço válido',
        'email.min' => 'O email do profissional deve conter no mínimo 8 caracteres',
        'email.max' => 'O email do profissional deve conter no máximo 40 caracteres',
        'profession.min' => 'A ocupação do profissional deve ter no mínimo 2 caracteres',
        'profession.max' => 'A ocupação do profissional deve ter no máximo 40 caracteres',
        'telephone.numeric' => 'O telefone do profissional deve conter apenas números',
        'telephone.digits_between' => 'O telefone do profissional deve ter entre 7 e 9 dígitos',
        'ddd.numeric' => 'O DDD do profissional deve conter apenas números',
        'ddd.digits' => 'O DDD do profissional deve ter exatamente 2 dígitos',
        'facebook.url' => 'O Facebook do profissional deve ser uma URL válida',
        'facebook.min' => 'O Facebook do profissional deve ter no mínimo 10 caracteres',
        'facebook.max' => 'O Facebook do profissional deve ter no máximo 60 caracteres',
        'twitter.url' => 'O Twitter do profissional deve ser uma URL válida',
        'twitter.min' => 'O Twitter do profissional deve ter no mínimo 10 caracteres',
        'twitter.max' => 'O Twitter do profissional deve ter no máximo 60 caracteres',
    ];

    public function specialties()
    {
        return $this->belongsToMany('rarasweb\Specialty', 'professional_specialty', 'professional_id', 'specialty_id');
    }
}
