<div class="container">
    <h5 style="text-align: center"><strong>REPORTE DE ESTUDIANTES</strong></h5>

    <table id="myTable1" class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Unidad Educativa</th>
                <th scope="col">Nombre Estudiante</th>
                <th scope="col">Apellido Estudiante</th>
                <th scope="col">Correo</th>
                <th scope="col">Estado</th>
                <th scope="col">Curso</th>
                <th scope="col">Materia</th>
                <th scope="col">Ultimo Acceso</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($estudiantes as $element)
            <tr>
                <td>{{$element['instituto']}}</td>
                <td>{{$element['user_nombre']}} </td>
                <td>{{ $element['user_apellido'] }}</td>
                <td>{{ $element['email'] }}</td>
                <td class="text-center">{{ $element['estado'] }}</td>
                <td>{{$element['nombre_curso']}}</td>
                <td>{{$element['nombre_materia']}}</td>
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