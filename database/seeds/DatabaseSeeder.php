<?php

use Illuminate\Database\Seeder;

use App\User;

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
            'tipo' => 1
        ]);
    }
}
