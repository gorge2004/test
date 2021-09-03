<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaSemana extends Model
{
    use HasFactory;
    protected $table= 'dias_semanas';
    protected $fillable = ['nombre', 'valor'];

    public function usuarios(){
        return $this->belongsToMany(Usuarios::class)->using(DiaSemanaUsuarioNoLaborable::class);
    }

}
