<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'apellidos', 'email'];
    public function grupo(){
        return $this->belongsToMany(Grupo::class,GrupoUsuario::class, 'usuario_id' ,'grupo_id'  );
    }

    public function diasPuntualesLaborales(){
        return $this->belongsToMany(DiaPuntual::class, DiaPuntualLaborable::class, 'usuario_id', 'dias_puntuales_id');
    }
    public function diasSemanaUsuarioLaborales(){
        return $this->belongsToMany(DiaSemana::class, DiaSemanaUsuarioLaborable::class);
    }
    public function  excepcionesLaborables(){
        return $this->hasMany(Excepcion::class)->where('laborable', true)->where('aprobado', true);
    }
    public function  excepcionesNoLaborables(){
        return $this->hasMany(Excepcion::class)->where('laborable', false)->where('aprobado', true) ;
    }
}
