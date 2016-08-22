<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class DisorderReference extends Model
{
    protected $table = 'disorder_reference';
    
    protected $fillable = ['disorder_id','reference_id'];

    protected $primaryKey = ['disorder_id','reference_id'];

    public $incrementing = false;

}
