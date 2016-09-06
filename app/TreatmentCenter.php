<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TreatmentCenter extends Model
{
    protected $table = 'treatment_centers';

    protected $fillable = ['name', 'abbreviation', 'address', 'number', 'complement', 'postal_code', 'neighborhood',
        'city', 'uf', 'cep', 'contact1', 'contact2', 'ddd', 'phone_number', 'general_number', 'extension', 'email',
        'site', 'latitude', 'longitude', 'cnes', 'open24'];

    public static $rules = [
        'name' => 'required|min:8|max:200|unique:treatment_centers,name',
        'abbreviation' => 'min:2|max:20',
        'address' => 'required|min:5|max:100',
        'number' => 'numeric|digits_between:1,5',
        'complement' => 'min:2|max:60',
        'postal_code' => 'numeric|digits_between:2,8',
        'neighborhood' => 'min:3|max:30',
        'city' => 'required|min:3|max:45',
        'uf' => 'required|alpha|size:2',
        'cep' => 'required|numeric|digits:8',
        'contact1' => 'min:5|max:50',
        'contact2' => 'min:5|max:50',
        'ddd' => 'required|numeric|digits:2',
        'phone_number' => 'required|numeric|digits_between:7,9',
        'general_number' => 'numeric|digits_between:7,9',
        'extension' => 'numeric|digits_between:2,4',
        'email' => 'email|min:8|max:40',
        'site' => 'url|min:10|max:60',
        'latitude' => 'min:8|max:20',
        'longitude' => 'min:8|max:20',
        'cnes' => 'min:3|max:45',
    ];
    
    public static $messages = [
        'name.required' => 'É necessário informar o nome do centro de tratamento',
        'name.min' => 'O nome do centro de tratamento deve ter no mínimo 8 caracteres',
        'name.max' => 'O nome do centro de tratamento deve ter no máximo 200 caracteres',
        'name.unique' => 'Já existe um centro de tratamento cadastrado com esse nome',
        'abbreviation.min' => 'A sigla do centro de tratamento deve ter no mínimo 2 caracteres',
        'abbreviation.max' => 'A sigla do centro de tratamento deve ter no máximo 20 caracteres',
        'address.required' => 'É necessário informar o endereço do centro de tratamento',
        'address.min' => 'O endereço do centro de tratamento deve ter no mínimo 5 caracteres',
        'address.max' => 'O endereço do centro de tratamento deve ter no máximo 100 caracteres',
        'number.numeric' => 'O número do centro de tratamento deve conter apenas números',
        'number.digits_between' => 'O número do centro de tratamento deve ter entre 1 e 5 dígitos',
        'complement.min' => 'O complemento do centro de tratamento deve ter no mínimo 2 caracteres',
        'complement.max' => 'O complemento do centro de tratamento deve ter no máximo 60 caracteres',
        'postal_code.numeric' => 'A caixa postal do centro de tratamento deve conter apenas números',
        'postal_code.digits_between' => 'A caixa postal do centro de tratamento deve ter entre 2 e 8 dígitos',
        'neighborhood.min' => 'O bairro do centro de tratamento deve ter no mínimo 3 caracteres',
        'neighborhood.max' => 'O bairro do centro de tratamento deve ter no máximo 30 caracteres',
        'city.required' => 'É necessário informar a cidade do centro de tratamento',
        'city.min' => 'A cidade do centro de tratamento deve ter no mínimo 3 caracteres',
        'city.max' => 'A cidade do centro de tratamento deve ter no máximo 45 caracteres',
        'uf.required' => 'É necessário informar a UF do centro de tratamento',
        'uf.alpha' => 'A UF do centro de tratamento deve conter apenas letras',
        'uf.size' => 'A UF do centro de tratamento deve ser de tamanho 2',
        'cep.required' => 'É necessário informar o CEP do centro de tratamento',
        'cep.numeric' => 'O CEP do centro de tratamento deve conter apenas números',
        'cep.digits' => 'O CEP do centro de tratamento deve ter exatamente 8 dígitos',
        'contact1.min' => 'O nome do responsável pelo centro de tratamento deve ter no mínimo 5 caracteres',
        'contact1.max' => 'O nome do responsável pelo centro de tratamento deve ter no máximo 50 caracteres',
        'contact2.min' => 'O nome do responsável pelo centro de tratamento deve ter no mínimo 5 caracteres',
        'contact2.max' => 'O nome do responsável pelo centro de tratamento deve ter no máximo 50 caracteres',
        'ddd.required' => 'É necessário informar o DDD do centro de tratamento',
        'ddd.numeric' => 'O DDD do centro de tratamento deve conter apenas números',
        'ddd.digits' => 'O DDD do centro de tratamento deve ter exatamente 2 dígitos',
        'phone_number.required' => 'É necessário informar o telefone principal do centro de tratamento',
        'phone_number.numeric' => 'O telefone principal do centro de tratamento deve conter apenas números',
        'phone_number.digits_between' => 'O telefone principal do centro de tratamento deve ter entre 7 e 9 dígitos',
        'general_number.numeric' => 'O telefone geral do centro de tratamento deve conter apenas números',
        'general_number.digits_between' => 'O telefone geral do centro de tratamento deve ter entre 7 e 9 dígitos',
        'extension.numeric' => 'O ramal do centro de tratamento deve conter apenas números',
        'extension.digits_between' => 'O ramal do centro de tratamento deve ter entre 2 e 4 dígitos',
        'email.email' => 'O email do centro de tratamento deve ser um endereço válido',
        'email.min' => 'O email do centro de tratamento deve ter no mínimo 8 caracteres',
        'email.max' => 'O email do centro de tratamento deve ter no máximo 40 caracteres',
        'site.url' => 'O site do centro de tratamento deve ser uma URL válida',
        'site.min' => 'O site do centro de tratamento deve ter no mínimo 10 caracteres',
        'site.max' => 'O site do centro de tratamento deve ter no máximo 60 caracteres',
        'latitude.min' => 'A latitude do centro de tratamento deve ter no mínimo 8 caracteres',
        'latitude.max' => 'A latitude do centro de tratamento deve ter no máximo 20 caracteres',
        'longitude.min' => 'A longitude do centro de tratamento deve ter no mínimo 8 caracteres',
        'longitude.max' => 'A longitude do centro de tratamento deve ter no máximo 20 caracteres',
        'cnes.min' => 'O CNES do centro de tratamento deve ter no mínimo 3 caracteres',
        'cnes.max' => 'O CNES do centro de tratamento deve ter no máximo 45 caracteres',
    ];

    public function specialties()
    {
        return $this->belongsToMany('App\Specialty', 'specialty_treatmentcenter',
            'treatmentcenter_id', 'specialty_id');
    }
}
