<div class="container">
    <h5 style="text-align: center"><strong>REPORTE DE DOCENTES</strong></h5>
    <table id="myTable1" class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Unidad Educativa</th>
                <th scope="col">Nombre Docente</th>
                <th scope="col">Apellido Docente</th>
                <th scope="col">Estado</th>
                <th scope="col">Curso</th>
                <th scope="col">Materia</th>
                <th scope="col">Paralelos</th>
                <th scope="col">Ultimo Acceso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($docentes as $element)
            <tr>
                <td>{{$element['instituto']}}</td>
                <td>{{$element['user_nombre']}} </td>
                <td>{{$element['user_apellido'] }}</td>
                <td>{{$element['estado'] }}</td>
                <td>{{$element['nombre_curso']}}</td>
                <td>{{$element['nombre_materia']}}</td>
                <td >@foreach ($paralelos = \DB::table('distribuciondo_nivel')->where('distribuciondo_id', $element['id'])->get() as $key => $paralelo)
                    <span class="badge badge-success">{{ $paralelo->nivel_nombre }}</span> @if( (count($paralelos) - 1)  > $key) @endif
                @endforeach</td>
                <td >{{Carbon\Carbon::parse($element['access_at'])->diffForHumans()}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>