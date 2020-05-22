<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Soporte extends Model
{
    protected $fillable = [
    	'reporte_id', 'archivo','tipo'
    ];
}
