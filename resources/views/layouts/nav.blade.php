<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Operador @yield('titulo')</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.cs') }}s">
    <link rel="stylesheet" href="{{ asset('css/components.css') }}">
    <!-- Custom style CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('bundles/izitoast/css/iziToast.min.css') }}">
    @livewireStyles
    @yield('css')
    <link rel="icon" type="img/png" href="{{ asset('img/logo.png') }}">
</head>

<body>
    <div class="loader"></div>
    <div>
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
              collapse-btn"> <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a></li>
                        {{-- <li class="nav-link text-dark font-weight-bold"><a href=" " class="nav-link">CALENDARIO</a> </li> --}}
                    </ul>
                    {{-- @role('coordinador')
            <ul class="navbar-nav navbar-left">
              <li class="dropdown">
              <a href="{{ route('coordinador.calendario') }}"  class="nav-link dropdown-toggle nav-link-lg nav-link-user text-dark">
                Calendario</a></li>
            </ul>
            @endrole --}}
                </div>
                <ul class="navbar-nav navbar-right">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                        </li>
                    @else
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user text-dark">
                                {{ Auth::user()->nombres }}
                                @if (Auth::user()->avatar)
                                    <img alt="image" id="navbar-act" src="{{ Auth::user()->avatar }}"
                                        class="user-img-radious-style">
                                @else
                                    <img alt="image" src="{{ Avatar::create(Auth::user()->nombres)->setChars(2) }}"
                                        class="user-img-radious-style">
                                @endif
                                <span class="d-sm-none d-lg-inline-block"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right pullDown">
                                <div class="dropdown-title">Hola {{ Auth::user()->nombres }}</div>
                                @role('super-admin')
                                <a href="{{ route('admin.perfil.me') }}" class="dropdown-item has-icon"> <i
                                        class="far fa-user"></i> Perfil </a>
                                @endrole
                                @role('admin')
                                <a href="{{ route('admin.perfil.me') }}" class="dropdown-item has-icon"> <i
                                        class="far fa-user"></i> Perfil </a>
                                @endrole
                                @role('coordinador')
                                <a href="{{ route('coordinador.perfil.me') }}" class="dropdown-item has-icon"> <i
                                        class="far fa-user"></i> Perfil </a>
                                @endrole
                                @role('operador')
                                <a href="{{ route('operador.perfil.me') }}" class="dropdown-item has-icon"> <i
                                        class="far fa-user"></i> Perfil </a>
                                @endrole
                                {{-- <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i> Actividades</a> --}}
                                {{-- <a href="" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>Configuracion</a> --}}
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                                    Cerrar Sesion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">

                        <a href="{{ route('index') }}">
                            <img alt="image" src="{{ asset('img/logo.png') }}" class="header-logo">

                            <span class="logo-name">Operaciones</span>
                        </a>
                    </div>
                    <div class="sidebar-user">
                        <div class="sidebar-user-picture">
                            @if (Auth::user()->avatar)
                                <img alt="image" id="sidebar-act" src="{{ Auth::user()->avatar }}">
                            @else
                                <img alt="image" src="{{ Avatar::create(Auth::user()->nombres)->setChars(2) }}">
                            @endif
                        </div>
                        <div class="sidebar-user-details">
                            <div class="user-name">{{ Auth::user()->nombres }}</div>
                            @role('super-admin|admin')
                            <div class="user-role">Administrador</div>
                            @endrole
                            @role('coordinador')
                            <div class="user-role">Coordinador</div>
                            @endrole
                            @role('operador')
                            <div class="user-role">Operador</div>
                            @endrole
                        </div>
                    </div>
                    <ul class="sidebar-menu">
                        @role('super-admin')
                        <li class="{{ active('admin') }}"><a class=" nav-link"
                                href="{{ route('admin.index') }}"><i
                                    class=" fa fa-tachometer-alt"></i><span>Inicio</span></a></li>
                        <li class="menu-header">Administracion</li>
                        @foreach ($menuData[0]->administrador as $menu)
                            @include('layouts.partials.menuHorizontal', ['menu' => $menu])
                        @endforeach
                        @endrole
                        @role('coordinador')
                        <li class="{{ active('coordinador') }}"><a class="nav-link"
                                href="{{ route('coordinador.index') }}"><i
                                    class=" fa fa-tachometer-alt"></i><span>Inicio</span></a></li>
                        <li class="menu-header">Coordinador</li>
                        @foreach ($menuData[0]->coordinador as $coordinador)
                            @include('layouts.partials.menuHorizontal', ['menu' => $coordinador])
                        @endforeach
                        @endrole
                        @role('operador')
                        <li class="menu-header">Operador</li>
                        <li class="@yield('adminindex')"><a class="nav-link" href="{{ route('operador.index') }}"><i
                                    class=" fa fa-tachometer-alt"></i><span>Inicio</span></a></li>
                        @endrole
                    </ul>
                </aside>
            </div>
            <!-- Main Content -->
            <div class="main-content">
                @include('layouts.partials.breadcrumb')
                @yield('content')
                @include('layouts.partials.panelSetting')
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2021 <div class="bullet"></div> Design By <a href="#">Anthony Medina</a>
                </div>
                <div class="footer-right">
                </div>
            </footer>
        </div>
    </div>
    <!-- General JS Scripts -->
    <!-- General JS Scripts -->
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <!-- JS Libraies -->
    <!-- Page Specific JS File -->
    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/fonts.js') }}"></script>
    @livewireScripts
    <script type="text/javascript" src="{{ asset('bundles/izitoast/js/iziToast.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('js/eventos.js') }}"></script>
    @yield('js')
</body>

</html>
