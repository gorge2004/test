<?php

namespace Database\Seeders;

use App\Models\DiaPuntual;
use Illuminate\Database\Seeder;

class DiaPuntualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ( $i = 1; $i <32;$i++) {
            DiaPuntual::firstOrCreate(['dia' => $i]);
        }
    }
}
