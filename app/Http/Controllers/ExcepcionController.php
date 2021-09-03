<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExepcionRequest;
use App\Models\Excepcion;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExcepcionController extends Controller
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
    public function store(StoreExepcionRequest $request)
    {
        $grupoHelper = new GrupoController();
        $usuario = Usuario::find($request->usuario_id);
        $fecha = new Carbon($request->fecha);
        $laborable = $grupoHelper->checkUsuarioIsCorrectToDate($usuario,$fecha );
        if ($request->laborable && $laborable  ) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'excepcion' => ['ya el usuario trabaja ese dia.'],
             ]);
             throw $error;
        }else if(!$request->laborable && !$laborable ){
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'excepcion' => ['el usuario no trabaja ese dia.'],
             ]);
             throw $error;
        }
        $excepciones = Excepcion::where('usuario_id', $request->usuario_id)->where('fecha', $request->fecha)->get();
        if ($excepciones->count()> 0 ) {
            $error = \Illuminate\Validation\ValidationException::withMessages([
                'excepcion' => ['el usuario ya tiene una excepcion para ese dia.'],
             ]);
             throw $error;
        }
        Excepcion::Create($request->all());


        return redirect()->route('excepciones.index')->with('success', 'se ha creado correctamente la excepcion.');

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
}
