<div class="container">
    <h5 style="text-align: center"><strong>REPORTE DE PRODUCTOS</strong></h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="15" style="vertical-align: middle; background-color: #D44C4C" scope="col">Nombre</th>
                <th width="15" style="vertical-align: middle; background-color: #D44C4C" scope="col">Presentación</th>
                <th width="20" style="vertical-align: middle; background-color: #D44C4C" scope="col">Unidad de Medida</th>
                <th width="15" style="vertical-align: middle; background-color: #D44C4C" scope="col">Stock</th>
                <th width="15" style="vertical-align: middle; background-color: #D44C4C" scope="col">Cantidad</th>
                <th width="15" style="vertical-align: middle; background-color: #D44C4C" scope="col">Precio de Compra</th>
                <th width="15" style="vertical-align: middle; background-color: #D44C4C" scope="col">Precio de Venta</th>
                <th width="15" style="vertical-align: middle; background-color: #D44C4C" scope="col">Iva(%)</th>
                
                <th width="15" style="vertical-align: middle; background-color: #D44C4C" scope="col">Cuenta Contable</th>
                <th width="15" style="vertical-align: middle; background-color: #D44C4C" scope="col">Estado</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $producto)
            <tr>
                <td>{{$producto['nombre']}} </td>
                <td>{{ $producto['presentacion'] }}</td>
                <td>{{ $producto['unidad'] }}</td>
                <td>{{ $producto['stock'] }}</td>
                <td>{{ $producto['cantidad'] }}</td>
                <td>{{ $producto['precio_compra'] }}</td>
                <td>{{ $producto['precio_venta'] }}</td>
                <td>{{ $producto['iva'] }}</td>
                <td>{{ $producto['cuenta_contable'] }}</td>
                <td>{{ $producto['estado'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>