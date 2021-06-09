<div class="container">
    <h5 style="text-align: center"><strong>REPORTE DE USUARIOS</strong></h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="vertical-align: middle;" scope="col">Nombres</th>
                <th style="vertical-align: middle;" scope="col">Usuario</th>
                <th style="vertical-align: middle;" scope="col">Correo</th>
                <th style="vertical-align: middle;" scope="col">Telefono</th>
                <th style="vertical-align: middle;" scope="col">Domicilio</th>
                <th style="vertical-align: middle;" scope="col">Sector</th>
                <th style="vertical-align: middle;" scope="col">Actividad</th>
                <th style="vertical-align: middle;" scope="col">Detaller De Actividad</th>
                <th style="vertical-align: middle;" scope="col">Horario de Atencion</th>
                <th style="vertical-align: middle;" scope="col">Geolocalizacion Latitud</th>
                <th style="vertical-align: middle;" scope="col">Geolocalizacion Longitud</th>
                <th class="px-4 py-2 text-center ">Rol</th>
                <th style="vertical-align: middle;" scope="col">Estado</th>
                <th style="vertical-align: middle;" scope="col">Ultimo Acceso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $element)
            <tr>
                <td>{{$element['nombres']}} </td>
                <td>{{ $element['username'] }}</td>
                <td>{{ $element['email'] }}</td>
                <td>{{ $element['telefono'] }}</td>
                <td>{{ $element['domicilio'] }}</td>
                <td>{{ $element['sector'] }}</td>
                <td>{{ $element['actividad_personal'] }}</td>
                <td> {!! $element['detalle_actividad'] !!}</td>
                <td>{{ $element['horario_atencion'] }}</td>
                <td>{{ $element['latitud'] }}</td>
                <td>{{ $element['longitud'] }}</td>
                <td class="p-0 text-center">@if ($element->hasRole('operador'))
                    <div >Operador</div>
                    @elseif ($element->hasRole('admin'))
                    <div >Administrador</div>
                    @elseif ($element->hasRole('coordinador'))
                    <div >Coordinador</div>
                    @endif
                </td>
                <td class="text-center">
                    {{ $element['estado'] }}
                </td>
                <td>
                    @isset ($element['access_at'])
                    {{Carbon\Carbon::parse($element['access_at'])->diffForHumans()}}
                    @else
                    Sin Ingreso
                    @endisset
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>