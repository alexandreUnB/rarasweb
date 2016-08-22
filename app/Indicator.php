<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    protected $table = 'indicators';

    protected $fillable = ['year', 'amount', 'reference', 'disorder_id', 'indicatorType_id', 'indicatorSource_id'];

    public static $rules = [
        'year' => 'required|digits:4',
        'amount' => 'required|numeric|min:1|max:1000000000',
        'reference' => 'required|min:3|max:1000',
        'disorder_id' => 'required',
        'indicatorType_id' => 'required',
        'indicatorSource_id' => 'required',
    ];

    public static $messages = [
        'year.required' => 'É necessário informar o ano do indicador',
        'year.digits' => 'O ano do indicador deve ter 4 dígitos',
        'amount.required' => 'É necessário informar a quantidade do indicador',
        'amount.numeric' => 'A quantidade do indicador deve conter somente números',
        'amount.min' => 'A quantidade do indicador deve ser no mínimo 1',
        'amount.max' => 'A quantidade do indicador deve ser no máximo 1000000000 (1 bilhão)',
        'reference.required' => 'É necessário informar a referência do indicador',
        'reference.min' => 'A referência do indicador deve ter no mínimo 3 caracteres',
        'reference.max' => 'A referência do indicador deve ter no máximo 1000 caracteres',
        'disorder_id.required' => 'É necessário informar a que desordem o indicador se refere',
        'indicatorType_id.required' => 'É necessário informar qual o tipo do indicador',
        'indicatorSource_id.required' => 'É necessário informar qual a fonte do indicador',
    ];

    public function disorder()
    {
        return $this->belongsTo('rarasweb\Disorder', 'disorder_id');
    }

    public function indicatorType()
    {
        return $this->belongsTo('rarasweb\IndicatorType' , 'indicatorType_id');
    }

    public function indicatorSource()
    {
        return $this->belongsTo('rarasweb\IndicatorSource' , 'indicatorSource_id');
    }
}
