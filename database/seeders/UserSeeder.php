<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //creacion de usuarios iniciales
         User::create([
            'name' => 'Admin',
            'email' => 'admin@iglebetel.com',
            'password' => Hash::make('adminEsencia'),
        ]);
        User::create([
            'name' => 'Leila',
            'email' => 'lelis.bf87@gmail.com',
            'password' => Hash::make('32625546'),
        ]);
        User::create([
            'name' => 'Claudia',
            'email' => 'claudiacampoya42@gmail.com',
            'password' => Hash::make('juancarlos'),
        ]);
        //para ejecutar al inicio
        //php artisan db:seed --class=UserSeeder
    }
}