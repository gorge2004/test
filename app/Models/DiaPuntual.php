<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaPuntual extends Model
{
    use HasFactory;
    protected $table = 'dias_puntuales';
    protected $fillable = ['dia'];
}
