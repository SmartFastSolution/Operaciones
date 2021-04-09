<div class="container">
    <h2 style="text-align: center"><strong>REPORTE CALIFICACIONES</strong></h2>
    <h4 style="text-align: center"><strong>{{ $titulos['instituto'] }}</strong></h4>
    <h4 style="text-align: center"><strong>{{ $titulos['materia'] }} |  </strong> Paralelo: <strong>{{ $titulos['paralelo'] }}</strong></h4>
<table  class="table table-hover">
                <thead>
                    <tr>
                        <th >Curso</th>
                        <th >Nombre Alumno</th>
                        <th >Apellido Alumno</th>
                        <th>Unidad</th>
                        <th>Taller </th>
                        <th>Enunciado </th>
                        <th>Calificacion </th>
                        <th>Observaciones </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($calificaciones as $taller1)
                    <tr>
                        <td>{{$taller1['cur_nombre']}}</td>
                        <td>{{$taller1['alumno']}}</td>
                        <td>{{$taller1['apelli'] }}</td>
                        <td>{{$taller1['conte_name']}}</td>
                        <td>{{$taller1['nombre']}}</td>
                        <td>
                            <div class="truncate-overflow">
                                {!!$taller1['enunciado']!!}
                            </div>
                        </td>
                        <td class="text-center">{{$taller1['calificacion']}}</td>
                        <td class="text-center">{{$taller1['retroalimentacion']}}</td>
    
                    </tr>
                    @endforeach
                </tbody>
            </table>
    {{-- <table id="myTable1" class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th  style="vertical-align: middle;" scope="col">Unidad Educativa</th>
                <th  style="vertical-align: middle;" scope="col">Curso</th>
                <th class="text-center"  style="vertical-align: middle;" scope="col">Paralelo</th>
                <th  style="vertical-align: middle;" scope="col">Nombre</th>
                <th  style="vertical-align: middle;" scope="col">Apellido</th>
                <th  style="vertical-align: middle;" scope="col">Materia</th>
                <th  style="vertical-align: middle;" scope="col">Contenido</th>
                <th  style="vertical-align: middle;" scope="col">Taller</th>
                <th class="text-center" style="vertical-align: middle;" scope="col">Calificacion</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($talleres as $element)
            <tr>
                <td>{{$element['instituto']}}</td>
                <td>{{$element['nombre_curso']}}</td>
                <td class="text-center">{{$element['paralelo']}} </td>
                <td>{{$element['alumno']}}</td>
                <td>{{$element['apelli']}}</td>
                <td>{{$element['nombre_materia']}}</td>
                <td>{{$element['unidad']}}</td>
                <td>{{$element['nombre']}}</td>
                <td class="text-center">{{$element['calificacion']}}</td>
            </tr>
            @endforeach
        </tbody>
    </table> --}}
</div>