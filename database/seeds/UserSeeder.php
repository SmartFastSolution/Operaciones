<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           app()[PermissionRegistrar::class]->forgetCachedPermissions();

     
        $role1 = Role::create(['name' => 'coordinador']);
      
        $role2 = Role::create(['name' => 'admin']);
       
        $role3 = Role::create(['name' => 'super-admin']);

        $role4 = Role::create(['name' => 'operador']);
        
        DB::table('users')->insert([
         
             'cedula'          => '12345678',
             'username'         =>'administrador',
             'nombres'         =>'Administrador',
             'domicilio'       => 'Guayaqyil',
             'telefono'        => '098765432',
             'celular'         => '049876543',
             'email'           => 'admin@operador.com',
             'password'        => Hash::make('12345678'),
             'estado'          => 'on',
             'created_at'      => now(),
             'updated_at'      => now()
             ]);

            $user = User::find(1);
            $user->assignRole($role3);

            DB::table('users')->insert([
         
             'cedula'          => '0987654321',
             'username'         =>'cordinador',
             'nombres'         =>'Cordinador',
             'domicilio'       => 'Guayaqyil',
             'telefono'        => '098765432',
             'celular'         => '049876543',
             'email'           => 'cordinador@operador.com',
             'password'        => Hash::make('12345678'),
             'estado'          => 'on',
             'created_at'      => now(),
             'updated_at'      => now()
             ]);

            $user = User::find(2);

            $user->assignRole($role1);


            DB::table('users')->insert([
         
             'cedula'          => '0985624521',
             'username'         =>'operador',
             'nombres'         =>'operador',
             'domicilio'       => 'Guayaqyil',
             'telefono'        => '098765432',
             'celular'         => '049876543',
             'email'           => 'operador@operador.com',
             'password'        => Hash::make('12345678'),
             'estado'          => 'on',
             'created_at'      => now(),
             'updated_at'      => now()
             ]);

             $user = User::find(3);

            $user->assignRole($role4);



    }
}
