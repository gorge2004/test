<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DiaSemanaUsuarioLaborable extends Pivot
{
    use HasFactory;
    protected $table = 'dias_semanas_laborable';
    protected $fillable = ['usuario_id', 'dia_semana_id'];
    public $incrementing = true;

}
