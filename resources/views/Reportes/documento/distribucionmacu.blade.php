<div class="container">
    <h5 style="text-align: center"><strong>REPORTE DE MATERIAS</strong></h5>
    <table id="myTable" class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Unidad Educativa</th>
                <th scope="col">Materia</th>
                <th scope="col">Curso</th>
                <th scope="col">CONTENIDO DE LA MATERIA</th>
                <th scope="col">Taller Por Contenido</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($talleres as $element)
            <tr>
                <td>{{$element['instituto']}}</td>
                <td>{{$element['nombre_materia']}}</td>
                <td>{{$element['nombre_curso']}}</td>
                <td>{{$element['unidad']}}</td>
                <td class="text-center">{{$taller = App\Taller::where('contenido_id', $element['unidad_id'])->count()}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>