<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;
    protected $fillable = [ 'guardia_id', 'nombre'];
    public function usuarios(){
        return $this->belongsToMany(Usuario::class, GrupoUsuario::class);
    }
}
