<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $fillable =[
    	'proyecto_id','fecha','monto'
    ];
}
