<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGrupoRequest;
use App\Models\Grupo;
use App\Models\Guardia;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGrupoRequest $request)
    {
        $usuarios =  Usuario::all();
        $guardia = Guardia::find($request->guardia_id);
        $fecha = new Carbon($guardia->fecha);
        $usuario_guardia = new Collection();
        foreach ($usuarios as $usuario){

            $conditionalByExceciones = $this->checkExcepciones($usuario, $fecha);
            if (($this->checkUsuarioIsCorrectToDate($usuario, $fecha) && $conditionalByExceciones ) || ($usuario->excepcionesLaborables &&  $usuario->excepcionesLaborables->contains(function($excepcion, $key)use($fecha){
                return $excepcion->fecha == $fecha;

            })) ) {
               $usuario_guardia->push($usuario);
            }
        }
        if ($usuario_guardia->count() > 0) {
            $grupo = Grupo::create([
                'guardia_id' =>$guardia->id,
                'nombre' => $guardia->fecha,
            ]);
            $grupo->usuarios()->attach($usuario_guardia);

        }else{
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'grupo' => ['No hay usuario disponible para esa fecha.'],
             ]);
             throw $error;
        }

        return redirect()->route('grupos.index')->with('success', 'Se ha creado correctamente el grupo para la guardia seleccionada.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    //check if usuario may join to group()
    public function checkUsuarioIsCorrectToDate($usuario, $fecha){

        return $this->checkIfDayOfWeekIsAllowed($usuario->diasSemanaUsuarioLaborales, $fecha) || $this->checkIfSpecifiedDayIsAllowed($usuario->diasPuntualesLaborales, $fecha);
    }
    /* check if usuario has excepciones for date */
    public function checkExcepciones($usuario, $fecha){

        if ($usuario->excepcionesNoLaborables && $usuario->excepcionesNoLaborables->contains(function($excepcion, $key)use($fecha){
            return $excepcion->fecha == $fecha;

        })) {
           return false;
        }
        return true;
    }
    public function checkIfDayOfWeekIsAllowed($dias, $fecha){
        if (!$dias) {
            return false;
        }
        return $dias->contains(function($dia,$key) use ($fecha){
            return $dia->valor == $fecha->dayOfWeek;
        });
    }
    public function checkIfSpecifiedDayIsAllowed($dias, $fecha){
        if (!$dias) {
            return false;
        }
        return $dias->contains(function($dia,$key) use ($fecha){
            return $dia->dia == $fecha->format('d');
        });
    }

}
