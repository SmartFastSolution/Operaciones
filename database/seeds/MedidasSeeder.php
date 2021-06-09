<?php

use App\ConversionUnidad;
use App\Medida;
use Illuminate\Database\Seeder;

class MedidasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'CUCHARADITA',
				'simbolo'     => 'cua',
				'descripcion' => 'CUCHARADITA',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
               $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'CUCHARADA',
				'simbolo'     => 'cu',
				'descripcion' => 'CUCHARADA',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
        $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'UNIDAD',
				'simbolo'     => 'und',
				'descripcion' => 'UNIDAD',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
                $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'TAZA',
				'simbolo'     => 'ta',
				'descripcion' => 'TAZA',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
             $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'JIGGER',
				'simbolo'     => 'ji',
				'descripcion' => 'JIGGER',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'ONZA FLUIDA (fl oz)',
				'simbolo'     => 'floz',
				'descripcion' => 'ONZA FLUIDA',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'PINTA (2 copas)',
				'simbolo'     => 'pt',
				'descripcion' => 'PINTA',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'GALON (4 cuartos)',
				'simbolo'     => 'gal',
				'descripcion' => 'GALON (4 cuartos)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'KILILITRO (kl)',
				'simbolo'     => 'kl',
				'descripcion' => 'KILILITRO (kl)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'HECTOLITRO (hL)',
				'simbolo'     => 'hl',
				'descripcion' => 'HECTOLITRO (hL)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'DECALITRO (daL)',
				'simbolo'     => 'dal',
				'descripcion' => 'DECALITRO (daL)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'LITRO (L)',
				'simbolo'     => 'l',
				'descripcion' => 'LITRO (L)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'DECILITRO (dL)',
				'simbolo'     => 'dl',
				'descripcion' => 'DECILITRO (dL)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);

            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'CENTILITRO (cL)',
				'simbolo'     => 'cl',
				'descripcion' => 'CENTILITRO (cL)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'MILILITRO (mL) o Centimetro Cubico (cc)',
				'simbolo'     => 'ml',
				'descripcion' => 'MILILITRO (mL) o Centimetro Cubico (cc)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'TONELADA METRICA (t)',
				'simbolo'     => 't',
				'descripcion' => 'TONELADA METRICA (t)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'KILOGRAMO (kG)',
				'simbolo'     => 'kg',
				'descripcion' => 'KILOGRAMO (kG)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'HECTOGRAMO (hG)',
				'simbolo'     => 'hg',
				'descripcion' => 'HECTOGRAMO (hG)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);

            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'DECAGRAMO (Dg)',
				'simbolo'     => 'Dg',
				'descripcion' => 'DECAGRAMO (Dg)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);

            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'GRAMOS (g)',
				'simbolo'     => 'g',
				'descripcion' => 'GRAMOS (g)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'DECIGRAMO (dG)',
				'simbolo'     => 'dg',
				'descripcion' => 'DECIGRAMO (dG)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'CENTIGRAMO (cG)',
				'simbolo'     => 'cg',
				'descripcion' => 'CENTIGRAMO (cG)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);

            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'MILIGRAMO (mG)',
				'simbolo'     => 'mg',
				'descripcion' => 'MILIGRAMO (mG)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);

            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'ONZA PESO (oz)',
				'simbolo'     => 'oz',
				'descripcion' => 'ONZA PESO (oz)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'LIBRA (lb)',
				'simbolo'     => 'lb',
				'descripcion' => 'LIBRA (lb)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'ARROBA (a)',
				'simbolo'     => 'a',
				'descripcion' => 'ARROBA (a)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);
            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'STONE (st)',
				'simbolo'     => 'st',
				'descripcion' => 'STONE (st)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);

            $medida1 = DB::table('medidas')->insert([
				'magnitud'    => 'MASA',
				'unidad'      => 'COPA (c)',
				'simbolo'     => 'c',
				'descripcion' => 'COPA (c)',
				'estado'      => 'on',
				'created_at'  => now(),
				'updated_at'  => now()
        ]);


            $medidas = Medida::pluck('id');
            foreach ($medidas as $id) {
            		$conversion                    = new ConversionUnidad;
					$conversion->medida_base       = $id;
					$conversion->medida_conversion = $id;
					$conversion->factor            = 1;
					$conversion->save();
            }


    }
}
