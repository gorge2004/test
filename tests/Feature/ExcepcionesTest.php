<?php

namespace Tests\Feature;

use App\Models\Excepcion;
use App\Models\Grupo;
use App\Models\Usuario;
use Carbon\Carbon;
use Database\Seeders\DiaPuntualSeeder;
use Database\Seeders\DiaSemanaSeeder;
use Database\Seeders\ExcepcionSeeder;
use Database\Seeders\UsuariosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ExcepcionesTest extends TestCase
{
    use RefreshDatabase;

    /*  */
    public function test_create_new_exepcion_all_ok()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $usuario = Usuario::where('nombre', 'jazmin')->first();
        /* lunes */
        $date = new Carbon('2021-12-27');
        $response = $this->post(route('excepciones.store'), [
            'usuario_id' => $usuario->id,
            'fecha' => $date,
            'laborable' => false,
            'nota' => 'cita medico',
            'observacion' => 'ok',
            'aprobado' => true
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success', 'se ha creado correctamente la excepcion.');
        $this->assertTrue(Excepcion::all()->count() == 1, 'se ha creado correctamente la excepcion.');
        $this->assertTrue($usuario->excepcionesNoLaborables->count() == 1, 'se ha asignado correctamente las excepciones.');
    }

    public function test_create_new_exepcion_not_laborable_user_not_date_working_get_exception()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $usuario = Usuario::where('nombre', 'jazmin')->first();
        /* domingo */
        $date = new Carbon('2021-12-26');
        $response = $this->post(route('excepciones.store'), [
            'usuario_id' => $usuario->id,
            'fecha' => $date,
            'laborable' => false,
            'nota' => 'no disponible',
            'observacion' => 'ok',
            'aprobado' => true
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['excepcion' => 'el usuario no trabaja ese dia.']);
        $this->assertTrue(Excepcion::all()->count() == 0, 'se ha creado correctamente la excepcion.');
        $this->assertTrue($usuario->excepcionesNoLaborables->count() == 0, 'se ha asignado correctamente las excepciones.');
    }
    public function test_create_new_exepcion_laborable_to_user_in_date_not_work()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $usuario = Usuario::where('nombre', 'jazmin')->first();
        /* domingo */
        $date = new Carbon('2021-12-26');
        $response = $this->post(route('excepciones.store'), [
            'usuario_id' => $usuario->id,
            'fecha' => $date,
            'laborable' => true,
            'nota' => 'disponible',
            'observacion' => 'ok',
            'aprobado' => true
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success', 'se ha creado correctamente la excepcion.');
        $this->assertTrue(Excepcion::all()->count() == 1, 'se ha creado correctamente la excepcion.');
        $this->assertTrue($usuario->excepcionesLaborables->count() == 1, 'se ha asignado correctamente las excepciones.');
    }

    public function test_create_new_exepcion_not_laborable_user_already_has_exception_for_date_get_exception()
    {
        $this->assertTrue(Grupo::all()->count() == 0, 'Hay grupos creados.');
        $this->assertTrue(Usuario::all()->count() == 0, 'Hay usuarios previos al test');
        $this->seed(DiaPuntualSeeder::class);
        $this->seed(DiaSemanaSeeder::class);
        $this->seed(UsuariosSeeder::class);
        $this->seed(ExcepcionSeeder::class);

        $usuario = Usuario::where('nombre', 'jazmin')->first();
        /* domingo */
        $date = new Carbon('2021-12-28');
        $response = $this->post(route('excepciones.store'), [
            'usuario_id' => $usuario->id,
            'fecha' => $date,
            'laborable' => false,
            'nota' => 'no disponible',
            'observacion' => 'ok',
            'aprobado' => true
        ]);
        $response->assertRedirect();
        $response->assertSessionHasErrors(['excepcion' => 'el usuario ya tiene una excepcion para ese dia.']);
        $this->assertTrue(Excepcion::all()->count() > 0, 'se ha creado correctamente la excepcion.');
    }
}
