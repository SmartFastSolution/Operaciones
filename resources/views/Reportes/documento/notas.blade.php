<div class="container">
    <h5 style="text-align: center"><strong>REPORTE ESTUDIANTES/TALLERES</strong></h5>
    <table id="myTable1" class="table table-hover">
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
    </table>
</div>