<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excepcion extends Model
{
    use HasFactory;
    protected $table = 'exceptiones';
    protected $fillable = ['nota', 'fecha', 'observacion', 'aprobado', 'laborable', 'usuario_id', 'gerente_id'];
    protected $dates = ['fecha'];
    public function usuario(){
        return $this->belongsTo(Usuario::class);
    }

    public function gerente(){
        return $this->belongsTo(Usuario::class, 'gerente_id');
    }
}
