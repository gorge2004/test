<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DiaPuntualLaborable extends Pivot
{
    use HasFactory;
    protected $table = 'dias_puntuales_laborales_usuarios';
    protected $fillable = ['usuario_id', 'dias_puntuales_id'];
    public $incrementing = true;

}
