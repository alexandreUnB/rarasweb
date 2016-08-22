<?php

namespace rarasweb;

use Illuminate\Database\Eloquent\Model;

class ProfessionalSpecialty extends Model
{
    protected $table = 'professional_specialty';

    protected $fillable = ['professional_id','specialty_id'];

    protected $primaryKey = ['professional_id','specialty_id'];

    public $incrementing = false;

}
