<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table='doctor';
    protected $primaryKey='id';
    public $timestamps=false;
}
