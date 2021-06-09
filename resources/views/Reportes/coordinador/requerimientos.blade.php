<div class="container">
    <h5 style="text-align: center"><strong>REPORTE DE REQUERIMIENTOS</strong></h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Codigo</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Cuenta</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Codigo Catastral</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Nombres</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Cedula</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Telefonos</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Correos</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Direccion</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Sector</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Fecha Maxima</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Tipo de Requerimiento</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Detalles</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Observacion</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Geolocalizacion Latitud</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Geolocalizacion Longitud</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Estado</th>


                <th style="vertical-align: middle; background-color: #D44C4C" scope="col"> Detalle Atencion</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col"> Observacion de Atencion</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col"> Fecha de Atencion</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col"> Distancia</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Geolocalizacion Latitud Atencion</th>
                <th style="vertical-align: middle; background-color: #D44C4C" scope="col">Geolocalizacion Longitud Atencion</th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($requerimientos as $element)
            <tr>
                <td>{{$element['codigo']}} </td>
                <td>{{$element['cuenta']}} </td>
                <td>{{ $element['codigo_catastral'] }}</td>
                <td>{{ $element['nombres'] }}</td>
                <td>{{ $element['cedula'] }}</td>
                <td>{{ $element['telefonos'] }}</td>
                <td>{{ $element['correos'] }}</td>
                <td>{{ $element['direccion'] }}</td>
                <td>{{ $element['sector'] }}</td>
                <td>{{ $element['fecha_maxima'] }}</td>
                <td>{{ $element['requerimiento'] }}</td>
                <td>{{ $element['detalle'] }}</td>
                <td> {!! $element['observacion'] !!}</td>
                <td>{{ $element['latitud'] }}</td>
                <td>{{ $element['longitud'] }}</td>
                <td class="text-center">
                    {{ $element['estado'] }}
                </td>
                @if ($element['atencion'])

                <td>{{ $element['atencion']['detalle'] }}</td>
                <td>{!!  $element['atencion']['observacion']  !!}</td>
                <td>{{ $element['atencion']['fecha_atencion'] }}</td>
                <td>@if ( $element['atencion']['distancia'] < 0)

                   {{number_format($element['atencion']['distancia'] * 1000, 2)}} KM
                   @else
                   {{ $element['atencion']['distancia'] }} MTS
                @endif
            </td>
                <td>{{ $element['atencion']['latitud'] }}</td>
                <td>{{ $element['atencion']['longitud'] }}</td>
                   
                @endif

            </tr>
            @endforeach
        </tbody>
    </table>
</div>