<?php

namespace Tests\Feature;

use App\Models\DiaPuntual;
use App\Models\DiaSemana;
use App\Models\Excepcion;
use App\Models\Grupo;
use App\Models\Guardia;
use App\Models\Usuario;
use Carbon\Carbon;
use Database\Seeders\DiaPuntualSeeder;
use Database\Seeders\DiaSemanaSeeder;
use Database\Seeders\ExcepcionSeeder;
use Database\Seeders\UsuariosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GrupoTest extends TestCase
{
    use RefreshDatabase;



    public function test_check_grupo_emtpy()
    {

        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
    }
    public function test_create_a_grupo_to_new_guardia_check_if_guardia_id_number()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $this->seed(ExcepcionSeeder::class);

        $response = $this->post(
            route('grupos.store'),
            ['guardia_id' => 'asd']
        );
        $erros = session('errors');
        $this->assertTrue($erros->get('guardia_id')[0] == "The guardia id must be a number.", 'Error equivocado en la verificacion el id sea numero.');
        $this->assertTrue(Usuario::all()->count() > 0, 'Error equivocado, en la verificacion de usuarios si existen.');
        $this->assertTrue(DiaSemana::all()->count() > 0, 'Error equivocado, en la verificacion  de dias de semanas si existen.');
        $this->assertTrue(DiaPuntual::all()->count() > 0, 'Error equivocado, en la verificacion de dias puntuales si existen.');
    }
    public function test_create_a_grupo_to_new_guardia_check_if_guardia_id_exist()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $this->seed(ExcepcionSeeder::class);

        $response = $this->post(
            route('grupos.store'),
            ['guardia_id' => 1]
        );
        $erros = session('errors');
        $this->assertTrue($erros->get('guardia_id')[0] == "The selected guardia id is invalid.", 'Error equivocado, en la verificacion si existe.');
        $this->assertTrue(Usuario::all()->count() > 0, 'Error equivocado, en la verificacion de usuarios si existen.');
        $this->assertTrue(DiaSemana::all()->count() > 0, 'Error equivocado, en la verificacion  de dias de semanas si existen.');
        $this->assertTrue(DiaPuntual::all()->count() > 0, 'Error equivocado, en la verificacion de dias puntuales si existen.');
    }
    public function test_create_a_grupo_to_new_guardia_check_usuarios()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $this->seed(ExcepcionSeeder::class);
        //domingo
        $date = new Carbon('2021-08-29');
        $guardia = Guardia::create([
            'fecha' => $date
        ]);
        $response = $this->post(
            route('grupos.store'),
            ['guardia_id' => $guardia->id]
        );
        $grupo = Grupo::first();
        $this->assertTrue(Guardia::all()->count() > 0, 'Error equivocado, en la verificacion de guadia si existen.');
        $this->assertTrue(Usuario::all()->count() > 0, 'Error equivocado, en la verificacion de usuarios si existen.');
        $this->assertTrue(DiaSemana::all()->count() > 0, 'Error equivocado, en la verificacion  de dias de semanas si existen.');
        $this->assertTrue(DiaPuntual::all()->count() > 0, 'Error equivocado, en la verificacion de dias puntuales si existen.');
        $this->assertTrue($grupo->usuarios->count()== 3 , 'No se asignaron correctamente los usuarios' );
    }

    public function test_create_a_grupo_to_new_guardia_monday_Jazmin_usuarios_skip_by_exepciones()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $this->seed(ExcepcionSeeder::class);
        //lunes, jazmin no trabaja tiene exepcion por la fecha, solo tendri que trabajar fanny y benicio
        $date = new Carbon('2021-12-27');
        $guardia = Guardia::create([
            'fecha' => $date
        ]);
        $response = $this->post(
            route('grupos.store'),
            ['guardia_id' => $guardia->id]
        );
        $grupo = Grupo::first();
        $this->assertTrue(Guardia::all()->count() > 0, 'Error equivocado, en la verificacion de guadia si existen.');
        $this->assertTrue(Usuario::all()->count() > 0, 'Error equivocado, en la verificacion de usuarios si existen.');
        $this->assertTrue(DiaSemana::all()->count() > 0, 'Error equivocado, en la verificacion  de dias de semanas si existen.');
        $this->assertTrue(DiaPuntual::all()->count() > 0, 'Error equivocado, en la verificacion de dias puntuales si existen.');
        $this->assertTrue($grupo->usuarios->count()==2 , 'No se asignaron correctamente los usuarios' );
        $this->assertTrue($grupo->usuarios->contains(function($usuario, $key){
            return $usuario->nombre == 'benicio';
        } ) , 'No se asigno a benicio.' );
        $this->assertTrue($grupo->usuarios->contains(function($usuario, $key){
            return $usuario->nombre == 'fanny';
        } ) , 'No se asigno a fanny.' );
        $this->assertTrue(!$grupo->usuarios->contains(function($usuario, $key){
            return $usuario->nombre == 'jazmin';
        } ) , 'se asigno a jazmin.' );
    }
    public function test_create_a_grupo_to_new_guardia_monday_only_jazmin_usuarios_skip_by_exepciones()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $this->seed(ExcepcionSeeder::class);
        //lunes, solo jazmin
        $date = new Carbon('2021-08-30');
        $guardia = Guardia::create([
            'fecha' => $date
        ]);
        $response = $this->post(
            route('grupos.store'),
            ['guardia_id' => $guardia->id]
        );
        $grupo = Grupo::first();
        $this->assertTrue(Guardia::all()->count() > 0, 'Error equivocado, en la verificacion de guadia si existen.');
        $this->assertTrue(Usuario::all()->count() > 0, 'Error equivocado, en la verificacion de usuarios si existen.');
        $this->assertTrue(DiaSemana::all()->count() > 0, 'Error equivocado, en la verificacion  de dias de semanas si existen.');
        $this->assertTrue(DiaPuntual::all()->count() > 0, 'Error equivocado, en la verificacion de dias puntuales si existen.');
        $this->assertTrue($grupo->usuarios->count()==1 , 'No se asignaron correctamente los usuarios' );

        $this->assertTrue($grupo->usuarios->contains(function($usuario, $key){
            return $usuario->nombre == 'jazmin';
        } ) , 'No se asigno a jazmin.' );
    }
    public function test_create_a_grupo_to_new_guardia_monday_no_body_to_assign_by_exepciones()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $this->seed(ExcepcionSeeder::class);
        //lunes, solo jazmin
        $date = new Carbon('2021-08-30');

        $guardia = Guardia::create([
            'fecha' => $date
        ]);
        $jazmin = Usuario::where('nombre', 'jazmin')->first();

        //crear excepcion a jazmin
        Excepcion::create([
            'nota' => 'excepciones de jazmin no puede trabajar',
            'fecha' => $date,
            'observacion' => 'jazmin de reposo',
            'aprobado' => true, 'laborable' => false, 'usuario_id' => $jazmin->id
        ]);
        $response = $this->post(
            route('grupos.store'),
            ['guardia_id' => $guardia->id]
        );
        $grupo = Grupo::first();
        $response->assertSessionHasErrors(['grupo' => 'No hay usuario disponible para esa fecha.']);
        $this->assertTrue(Guardia::all()->count() > 0, 'Error equivocado, en la verificacion de guadia si existen.');
        $this->assertTrue(Usuario::all()->count() > 0, 'Error equivocado, en la verificacion de usuarios si existen.');
        $this->assertTrue(DiaSemana::all()->count() > 0, 'Error equivocado, en la verificacion  de dias de semanas si existen.');
        $this->assertTrue(DiaPuntual::all()->count() > 0, 'Error equivocado, en la verificacion de dias puntuales si existen.');
        $this->assertTrue($grupo == null , 'se creo un grupo de usuario.' );


    }
    public function test_create_a_grupo_to_new_guardia_monday_no_jazmin_to_assign_by_exepciones_instead_of_benicio()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        /* $this->seed(ExcepcionSeeder::class); */
        //lunes, solo jazmin
        $date = new Carbon('2021-08-30');

        $guardia = Guardia::create([
            'fecha' => $date
        ]);
        $jazmin = Usuario::where('nombre', 'jazmin')->first();
        $benicio = Usuario::where('nombre', 'benicio')->first();

        //crear excepcion a jazmin
        Excepcion::create([
            'nota' => 'excepciones de jazmin no puede trabajar',
            'fecha' => $date,
            'observacion' => 'jazmin de reposo',
            'aprobado' => true, 'laborable' => false, 'usuario_id' => $jazmin->id
        ]);
         //crear excepcion a benicio
         Excepcion::create([
            'nota' => 'excepciones de benicio puede trabajar',
            'fecha' => $date,
            'observacion' => 'Benicio',
            'aprobado' => true, 'laborable' => true, 'usuario_id' => $benicio->id
        ]);
        $response = $this->post(
            route('grupos.store'),
            ['guardia_id' => $guardia->id]
        );
        $grupo = Grupo::first();
        $this->assertTrue(Guardia::all()->count() > 0, 'Error equivocado, en la verificacion de guadia si existen.');
        $this->assertTrue(Excepcion::all()->count() == 2, 'No se crearon las excepciones');
        $this->assertTrue(Usuario::all()->count() > 0, 'Error equivocado, en la verificacion de usuarios si existen.');
        $this->assertTrue(DiaSemana::all()->count() > 0, 'Error equivocado, en la verificacion  de dias de semanas si existen.');
        $this->assertTrue(DiaPuntual::all()->count() > 0, 'Error equivocado, en la verificacion de dias puntuales si existen.');
        $this->assertTrue($grupo->usuarios->count()==1 , 'no se creo un grupo de usuario.' );
        $this->assertTrue($grupo->usuarios->contains(function($usuario, $key){
            return $usuario->nombre == 'benicio';
        } ) , 'No se asigno a benicio.' );


    }
}
