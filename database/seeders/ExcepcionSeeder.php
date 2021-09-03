<?php

namespace Database\Seeders;

use App\Models\Excepcion;
use App\Models\Usuario;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class ExcepcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $anio = Carbon::now()->format('Y');
       $jazmin = Usuario::where('nombre', 'jazmin')->first();

        $periods = CarbonPeriod::create($anio.'-12-23', ($anio+1).'-01-02' );
        foreach( $periods as $period){
            $exception_array = [
                'nota' => 'excepciones de anio nuevo',
                'fecha' => $period,
                'observacion' => 'convenio con jazmin',
                'aprobado' => true, 'laborable' => false, 'usuario_id' => $jazmin->id
            ];
            Excepcion::firstOrCreate($exception_array);
        }
    }
}
