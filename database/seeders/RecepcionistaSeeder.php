<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Recepcionista;

class RecepcionistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //llenado inicial de las recepionistas que inscriben
        Recepcionista::create([
            'nombre' => 'Claudia',
            'apellido' => 'Campopya'
        ]);
        Recepcionista::create([
            'nombre' => 'Leila',
            'apellido' => 'Farfán'
        ]);
        Recepcionista::create([
            'nombre' => 'Natalia',
            'apellido' => 'Barrionuevo'
        ]);
        

    }
}
