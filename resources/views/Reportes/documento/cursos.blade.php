<div class="container">
    <h5 style="text-align: center"><strong>REPORTE DOCENTE/ESTUDIANTE</strong></h5>
    <table id="myTable1" class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Unidad Educativa</th>
                <th scope="col">Nombre Docente</th>
                <th scope="col">Apellido Docente</th>
                <th scope="col">Materia</th>
                <th scope="col">Curso</th>
                <th scope="col">Nombre Estudiante</th>
                <th scope="col">Apellido Estudiante</th>
                <th scope="col">Paralelo</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alumnos as $element)
            <tr>
                <td>{{$element['instituto']}}</td>
                <td>{{$element['docente_nombre']}} </td>
                <td>{{ $element['docente_apellido'] }}</td>
                <td>{{$element['materia']}}</td>
                <td>{{ $element['curso'] }}</td>
                <td>{{$element['estudiamte_nombre']}} </td>
                <td>{{ $element['estudiamte_apellido'] }}</td>
                <td class="text-center"><span class="badge badge-danger">{{ $element['nivel_nombre'] }}</span></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>