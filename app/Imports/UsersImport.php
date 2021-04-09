<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        return new User([
             'nombres'  =>  $row['nombres'],
             'cedula'   =>  $row['cedula'],
             'username' =>  $row['username'],
             'email'    =>  $row['email'],
             'password' =>  Hash::make('12345678'),
             'estado'   =>  'on',
        ]);
    }
    
}
