<?php

use App\Sector;
use App\TipoRequerimiento;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $sectors = array('La Chala', 'Las Malvinas', 'La Atarazana',' Mucho Lote','Orquideaz', 'Ceibos');
         $tipos = array('Pago de Agua', 'Pago de Luz', 'Arriendo', 'Recargas', 'Consumo', 'Reportes');
       
         foreach ($sectors as $sector) {
           DB::table('sectors')->insert([
					'nombre'      => $sector,
					'descripcion' => 'Descripcion del sector',
					'estado'      => 'on',
            ]);
        }



          foreach ($tipos as $tipo) {
           DB::table('tipo_requerimientos')->insert([
					'nombre'          => $tipo,
					'parametrizacion' => $tipo,
					'descripcion'     => 'Descripcion del Tipo',
					'estado'          => 'on',
            ]);
        }

        $sectores = Sector::pluck('id');
        $reque = TipoRequerimiento::pluck('id');

        foreach ($sectores as $key => $sector) {
             factory(\App\Requerimiento::class)->times(10)->create([
                             'sector_id' => $sector,
            ]);
            
        }
    }
}
