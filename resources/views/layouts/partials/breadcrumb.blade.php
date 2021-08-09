<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @role('super-admin|admin')
        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="fas fa-tachometer-alt"></i>
                Inicio</a></li>
        @endrole
        @role('coordinador')
        <li class="breadcrumb-item"><a href="{{ route('coordinador.index') }}"><i class="fas fa-tachometer-alt"></i>
                Inicio</a></li>
        @endrole
        @role('operador')
        <li class="breadcrumb-item"><a href="{{ route('operador.index') }}"><i class="fas fa-tachometer-alt"></i>
                Inicio</a></li>

        @endrole
        @yield('breadcrumb')
    </ol>
</nav>
