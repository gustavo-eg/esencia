<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepcionista extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'apellido'];

    //tiene muchas inscripciones
    public function inscripciones(){
        return $this->hasMany(Inscripcion::class,'id');
    }

    //tiene muchos pagos
    public function pagos(){
        return $this->hasMany(Pago::class,'id');
    }
}
