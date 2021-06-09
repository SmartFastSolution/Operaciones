<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Requerimiento;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Requerimiento::class, function (Faker $faker) {
    return [
       'codigo'                => $faker->randomNumber($nbDigits = 3),
		'codigo_catastral'      => $faker->randomNumber($nbDigits = 8),
		'nombres'               => $faker->name($gender ='female'),
		'telefonos'             => $faker->randomNumber($nbDigits = 8),
		'correos'               =>  $faker->safeEmail,
		'direccion'             => $faker->sentence(),
		// 'sector_id'             => $faker->numberBetween(1, 5),
		'tipo_requerimiento_id' => $faker->numberBetween(1, 6),
		'detalle'               => $faker->sentence(),
		'cedula'                => $faker->randomNumber($nbDigits = 8),
		'observacion'           => $faker->sentence(),
		'fecha_maxima'          => $faker->dateTimeBetween('-4 week', '+1 week'),
		'latitud'               => -2.219662,
		'longitud'              => -79.929179,
		'estado'                => 'pendiente',
    ];
});
