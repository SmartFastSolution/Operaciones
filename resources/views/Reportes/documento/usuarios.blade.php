<div class="container">
    <h5 style="text-align: center"><strong>REPORTE DE USUARIOS</strong></h5>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="vertical-align: middle;" scope="col">Nombres</th>
                <th style="vertical-align: middle;" scope="col">Usuario</th>
                <th style="vertical-align: middle;" scope="col">Correo</th>
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