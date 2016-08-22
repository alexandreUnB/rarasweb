<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class SpecialtyTreatmentCenter extends Model
{
    protected $table = 'specialty_treatmentcenter';

    protected $fillable = ['specialty_id','treatmentcenter_id'];

    protected $primaryKey = ['specialty_id','treatmentcenter_id'];

    public $incrementing = false;

}
