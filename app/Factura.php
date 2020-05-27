<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $fillable =[
    	'proyecto_id','fecha','monto'
    ];
}
