<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class DisorderSign extends Model
{
    protected $table = 'disorder_sign';
    
    protected $fillable = ['disorder_id','sign_id'];

    protected $primaryKey = ['disorder_id','sign_id'];

    public $incrementing = false;
}
