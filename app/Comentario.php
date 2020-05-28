<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    protected $fillable = [
    	'proyecto_id','user_id','comentario'
    ];

    public function Usuario()
    {
    	// return 'dfsdf';
    	return $this->belongsTo('App\User','user_id','id');
    }
}
