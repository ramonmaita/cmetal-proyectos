<?php

use Illuminate\Database\Seeder;

use App\User;

use App\Metrado;

use App\Empresa;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::insert([
            'nombre' => 'Ramon',
        	'apellido' => 'Maita',
        	'email' => 'ramonmaita06@gmail.com',
        	'password' => bcrypt('maita123486'),
            'estatus' => 1,
            'tipo' => 0,
            'empresa_id' => 0
        ]);

        User::insert([
            'nombre' => 'Super Admin',
            'apellido' => 'CMETAL',
            'email' => 'superadmin@cmetal.com.pe',
            'password' => bcrypt('admincmetal'),
            'estatus' => 1,
            'tipo' => 0,
            'empresa_id' => 0
        ]);

        User::insert([
            'nombre' => 'Admin',
            'apellido' => 'CMETAL',
            'email' => 'admin@cmetal.com.pe',
            'password' => bcrypt('admincmetal'),
            'estatus' => 1,
            'tipo' => 1,
            'empresa_id' => 1
        ]);

        User::insert([
            'nombre' => 'Supervisor',
            'apellido' => 'CMETAL',
            'email' => 'supervisor@cmetal.com.pe',
            'password' => bcrypt('admincmetal'),
            'estatus' => 1,
            'tipo' => 2,
            'empresa_id' => 1
        ]);

        User::insert([
            'nombre' => 'Cliente',
            'apellido' => 'CMETAL',
            'email' => 'cliente@cmetal.com.pe',
            'password' => bcrypt('admincmetal'),
            'estatus' => 1,
            'tipo' => 3,
            'empresa_id' => 1
        ]);

        Empresa::insert([
            'nombre' => 'CMETAL',
            'descripcion' => 'METAL',
            'sector' => 'METALICO',
            'estatus' => '1'
        ]);

        Metrado::insert([
            'nombre' => 'Global'
        ]);
        Metrado::insert([
            'nombre' => 'Día'
        ]);
        Metrado::insert([
            'nombre' => 'Ml'
        ]);
        Metrado::insert([
            'nombre' => 'M2'
        ]);
        Metrado::insert([
            'nombre' => 'M3'
        ]);
        Metrado::insert([
            'nombre' => 'Bolsa'
        ]);
        Metrado::insert([
            'nombre' => 'Kg'
        ]);
        Metrado::insert([
            'nombre' => 'Unidad'
        ]);
        Metrado::insert([
            'nombre' => 'Pieza'
        ]);
        Metrado::insert([
            'nombre' => 'Punto'
        ]);
        Metrado::insert([
            'nombre' => 'Km'
        ]);
    }
}
