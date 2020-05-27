<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    protected $fillable =[
    	'proyecto_id','fecha','monto'
    ];
}
