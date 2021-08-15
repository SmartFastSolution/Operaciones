<?php

namespace App\Traits;

use App\Egreso;
use App\Product;
use App\Atencion;

trait RequerimientoTrait
{
    /**
     * Undocumented function
     *
     * @param Object $request
     * @param Atencion $atencion
     * @return void
     */
    public function storeEgreso($request, Atencion $atencion)
    {
        $egreso               = new Egreso;
        $egreso->codigo       = $request->codigo;
        $egreso->descripcion  = $request->descripcion;
        $egreso->atencion_id  = $atencion->id;
        $egreso->total_egreso = $request->total_egreso;
        $egreso->save();
        $productos = json_decode($request->items, true);
        $relacion = $this->convArray($productos);
        foreach ($productos as $key => $producto) {
            $produc           = Product::find($producto['id']);
            $cantidad         = intval($produc->cantidad) - $producto['cantidad_unidad'];
            $stock            = $cantidad / $produc->presentacion;
            $produc->cantidad = $cantidad;
            $produc->stock    = $stock;
            $produc->save();
        }
        $egreso->productos()->sync($relacion);
    }
    public function convArray($productos)
    {
        $relacion = [];
        foreach ($productos as $key => $producto) {
            $relacion[$producto['id']] = array(
                "cantidad"      => $producto['cantidad_unidad'],
                "cantidad_real" => $producto['cantidad_base'],
                "total"         => $producto['total'],
                'created_at' => now(),
                'updated_at' => now(),
            );
        }
        return $relacion;
    }
}
