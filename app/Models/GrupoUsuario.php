<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GrupoUsuario extends Pivot
{
    use HasFactory;
    protected $table = 'grupos_usuarios';
    protected $fillable = ['usuario_id', 'grupo_id'];
    public $incrementing = true;
}
