<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;
    protected $table="productos";
    protected $filliable=[
        "id",
        "nombre",
        "cantidad",
        "existencias_bodega",
        "disponible_bodega",
        "costo",
        "precio_venta",
        "created_at",
        "updated_at"
    ];
}
