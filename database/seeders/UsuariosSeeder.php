<?php

namespace Database\Seeders;

use App\Models\DiaPuntual;
use App\Models\DiaSemana;
use App\Models\Usuario;
use Illuminate\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios_array = [
            [
                'nombre' => 'Margarita',
                'apellido' => '1',
                'email' => 'email@example.com',

            ],
            [
                'nombre' => 'gregorio',
                'apellido' => '2',
                'email' => 'email2@example.com',

            ],
            [
                'nombre' => 'esteban',
                'apellido' => '3',
                'email' => 'email3@example.com',

            ],
            [
                'nombre' => 'jazmin',
                'apellido' => '4',
                'email' => 'email4@example.com',

            ],
            [
                'nombre' => 'fanny',
                'apellido' => '5',
                'email' => 'email5@example.com',

            ],
            [
                'nombre' => 'benicio',
                'apellido' => '6',
                'email' => 'email6@example.com',

            ],
        ];
        $dias_laborables = [
             'Margarita'=> [
                'dias_semana' => ['miercoles', 'sabado', 'domingo'],
                'dias_puntuales' => []

            ],
             'gregorio' => [
                'dias_semana' => [ 'sabado', 'domingo'],
                'dias_puntuales' => []
            ],
             'esteban' => [
                'dias_semana' => [ 'sabado', 'domingo'],
                'dias_puntuales' => []
            ],
            'jazmin'  => [
                'dias_semana' => ['lunes', 'martes', 'miercoles', 'jueves', 'viernes'],
                'dias_puntuales' => []
            ],
             'fanny' =>[
                'dias_semana' => ['jueves'],
                'dias_puntuales' => [2, 3, 5, 7, 20, 21, 22, 23, 24, 25, 26, 27, 28]
            ],
              'benicio' => [
                'dias_semana' => ['jueves'],
                'dias_puntuales' => [2, 3, 5, 7, 20, 21, 22, 23, 24, 25, 26, 27, 28]
            ],
        ];

        foreach ($usuarios_array as $usuario_array) {
            $usuario = Usuario::firstOrCreate($usuario_array);
            $diasPuntuales = DiaPuntual::whereIn('dia', $dias_laborables[$usuario->nombre]['dias_puntuales'])->get();
            $diasemanales = DiaSemana::whereIn('nombre',  $dias_laborables[$usuario->nombre]['dias_semana'])->get();
            $usuario->diasSemanaUsuarioLaborales()->attach($diasemanales);
            $usuario->diasPuntualesLaborales()->attach($diasPuntuales);
        }
    }
}
