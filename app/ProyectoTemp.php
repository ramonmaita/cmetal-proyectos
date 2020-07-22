<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectoTemp extends Model
{
    protected $fillable = [
        'fecha_inicio', 'fecha_fin', 'nombre', 'direccion', 'descripcion', 'gastos_generales', 'descuento', 'utilidad', 'gasto_estimado', 'estatus','empresa_id'
    ];
}
