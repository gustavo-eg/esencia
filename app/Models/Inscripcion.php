<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;
    public function recepcionistas(){
        return $this->belongsTo(Recepcionista::class,'id_recepcionista');
    }
}
