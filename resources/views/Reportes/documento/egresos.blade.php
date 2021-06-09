<div class="container">
    <h5 style="text-align: center"><strong>REPORTE DE EGRESOS</strong></h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th width="10" style="vertical-align: middle; background-color: #D44C4C" scope="col">Codigo</th>
                <th width="75" style="vertical-align: middle; background-color: #D44C4C" scope="col">Descripción</th>
                <th width="20" style="vertical-align: middle; background-color: #D44C4C" scope="col">Productos</th>
                <th width="20" style="vertical-align: middle; background-color: #D44C4C" scope="col">Total</th>
            
            </tr>
        </thead>
        <tbody>
            @foreach ($egresos as $egreso)
            <tr>
                <td>{{$egreso['codigo']}} </td>
                <td>{{ $egreso['descripcion'] }}</td>
                <td>{{ $egreso['productos_count'] }}</td>
                <td>{{ $egreso['total_egreso'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>