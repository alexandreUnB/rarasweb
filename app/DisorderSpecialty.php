<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class DisorderSpecialty extends Model
{
    protected $table = 'disorder_specialty';

    protected $fillable = ['disorder_id','specialty_id'];

    protected $primaryKey = ['disorder_id','specialty_id'];

    public $incrementing = false;
}
