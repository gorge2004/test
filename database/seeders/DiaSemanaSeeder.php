<?php

namespace Database\Seeders;

use App\Models\DiaSemana;
use Illuminate\Database\Seeder;

class DiaSemanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arrayDiaSemana = [
            ['nombre' => 'domingo', 'valor' => 0],
            ['nombre' => 'lunes', 'valor' => 1],
            ['nombre' => 'martes', 'valor' => 2],
            ['nombre' => 'miercoles', 'valor' => 3],
            ['nombre' => 'jueves', 'valor' => 4],
            ['nombre' => 'viernes', 'valor' => 5],
            ['nombre' => 'sabado', 'valor' => 6],
        ];
        foreach ($arrayDiaSemana as $dia){
            DiaSemana::firstOrCreate($dia);
        }
    }
}
