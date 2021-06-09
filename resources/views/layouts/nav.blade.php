<!DOCTYPE html>
<html lang="es">
  <!-- Copied from http://radixtouch.in/templates/admin/aegis/source/light/blank.html by Cyotek WebCopy 1.7.0.600, Saturday, September 21, 2019, 2:51:57 AM -->
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
    <div >
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
              <li>
                <form class="form-inline mr-auto">
                  <div class="search-element">
                    <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                    <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                    </button>
                  </div>
                </form>
              </li>
               
              {{-- <li class="nav-link text-dark font-weight-bold"><a href=" " class="nav-link">CALENDARIO</a> </li> --}}
            </ul>
    {{--         @role('coordinador')
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
              <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user text-dark">
                {{ Auth::user()->nombres }}
                @if (Auth::user()->avatar)
                <img alt="image" id="navbar-act" src="{{ Auth::user()->avatar }}" class="user-img-radious-style">
                @else
                <img alt="image" src="{{ Avatar::create(Auth::user()->nombres)->setChars(2) }}" class="user-img-radious-style">
                @endif
                <span class="d-sm-none d-lg-inline-block"></span></a>
                <div class="dropdown-menu dropdown-menu-right pullDown">
                  <div class="dropdown-title">Hola {{ Auth::user()->nombres }}</div>
                  @role('super-admin')
                  <a href="{{ route('admin.perfil.me') }}" class="dropdown-item has-icon"> <i class="far fa-user"></i> Perfil </a>
                  @endrole
                  @role('admin')
                  <a href="{{ route('admin.perfil.me') }}" class="dropdown-item has-icon"> <i class="far fa-user"></i> Perfil </a>
                  @endrole
                  @role('coordinador')
                  <a href="{{ route('coordinador.perfil.me') }}" class="dropdown-item has-icon"> <i class="far fa-user"></i> Perfil </a>
                  @endrole
                   @role('operador')
                    <a href="{{ route('operador.perfil.me') }}" class="dropdown-item has-icon"> <i class="far fa-user"></i> Perfil </a>
                    @endrole
                  {{-- <a href="timeline.html" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i> Actividades</a> --}}
                  {{-- <a href="" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>Configuracion</a> --}}
                  <div class="dropdown-divider"></div>
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesion
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
                <li class="@yield('adminindex')"><a class="nav-link" href="{{ route('admin.index') }}"><i class=" fa fa-tachometer-alt"></i><span>Inicio</span></a></li>
                <li class="menu-header">Administracion</li>
                <li class="dropdown @yield('usuarios')">
                  <a href="#" class="nav-link has-dropdown "><i class="fas fa-users"></i><span>Usuarios</span></a>
                  <ul class="dropdown-menu  ">
                    <li><a class="nav-link" href="{{ route('usuario.index') }}">Lista de Usuarios</a></li>
                  </ul>
                </li>
                <li class="dropdown @yield('sectores')">
                  <a href="#" class="nav-link has-dropdown "><i class="fas fa-map"></i><span>Sectores</span></a>
                  <ul class="dropdown-menu  ">
                    <li><a class="nav-link" href="{{ route('sector.index') }}">Lista de Sectores</a></li>
                  </ul>
                </li>
                <li class="dropdown @yield('medidas')">
                  <a href="#" class="nav-link has-dropdown "><i class="fas fa-weight"></i><span>Medidas</span></a>
                  <ul class="dropdown-menu  ">
                    <li><a class="nav-link" href="{{ route('medida.index') }}">Unidades de Medidas</a></li>
                  </ul>
                </li>
                <li class="dropdown @yield('tipos-registro')">
                  <a href="#" class="nav-link has-dropdown "><i class="fas fa-clipboard-list"></i><span>Requerimientos</span></a>
                  <ul class="dropdown-menu  ">
                    <li><a class="nav-link" href="{{ route('tipo-requerimiento.index') }}">Requerimientos</a></li>
                  </ul>
                </li>
                @endrole
                @role('admin')
                <li class="menu-header">Admin</li>
                @endrole
                @role('coordinador')
                 <li class="@yield('adminindex')"><a class="nav-link" href="{{ route('coordinador.index') }}"><i class=" fa fa-tachometer-alt"></i><span>Inicio</span></a></li>
                <li class="menu-header">Coordinador</li>
                
                <li class="dropdown @yield('requerimiento')">
                  <a href="#" class="nav-link has-dropdown "><i class="fas fa-clipboard-list"></i><span>Requerimientos</span></a>
                  <ul class="dropdown-menu  ">
                    <li class="@yield('productos')"><a class="nav-link" href="{{ route('coordinador.requerimiento.index') }}">Requerimientos</a></li>
                    {{-- <li class="@yield('atencion')"><a class="nav-link" href="{{ route('coordinador.producto.ingreso') }}">Atencion Requerimiento</a></li> --}}
                    <li class="@yield('asignacion')"><a class="nav-link" href="{{ route('coordinador.requerimiento.asignar') }}">Asignar Requerimientos</a></li>
                    <li class="@yield('ver_mapa')"><a class="nav-link" href="{{ route('coordinador.mapa') }}">Ver Mapa</a></li>
                    <li class="@yield('calendario')"><a class="nav-link" href="{{ route('coordinador.calendario') }}">Calendario</a></li>
                  </ul>
                </li>
                <li class="dropdown @yield('bodega')">
                  <a href="#" class="nav-link has-dropdown "><i class="fas fa-store"></i><span>Bodega</span></a>
                  <ul class="dropdown-menu  ">
                    <li class="@yield('productos')"><a class="nav-link" href="{{ route('coordinador.producto.index') }}">Productos</a></li>
                    <li class="@yield('ingresos')"><a class="nav-link" href="{{ route('coordinador.producto.ingreso') }}">Ingresos</a></li>
                    <li class="@yield('egresos')"><a class="nav-link" href="{{ route('coordinador.producto.egreso') }}">Egresos</a></li>
                  </ul>
                </li>
                @endrole
                 @role('operador')
                <li class="menu-header">Operador</li>
                 
                 <li class="@yield('adminindex')"><a class="nav-link" href="{{ route('operador.index') }}"><i class=" fa fa-tachometer-alt"></i><span>Inicio</span></a></li>
                @endrole
              </ul>
            </aside>
          </div>
          <!-- Main Content -->
          <div class="main-content">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                  @role('super-admin|admin')
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="fas fa-tachometer-alt"></i> Inicio</a></li>
                  @endrole
                  @role('coordinador')
                <li class="breadcrumb-item"><a href="{{ route('coordinador.index') }}"><i class="fas fa-tachometer-alt"></i> Inicio</a></li> 
                  @endrole
                  @role('operador')
                <li class="breadcrumb-item"><a href="{{ route('operador.index') }}"><i class="fas fa-tachometer-alt"></i> Inicio</a></li>
                  
                  @endrole
                @yield('breadcrumb')
              </ol>
            </nav>
            @yield('content')
            
            <div class="settingSidebar">
              <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
              </a>
              <div class="settingSidebar-body ps-container ps-theme-default">
                <div class=" fade show active">
                  <div class="setting-panel-header">Panel de Configuración
                  </div>
                  <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Seleccionar diseño</h6>
                    <div class="selectgroup layout-color w-50">
                      <label class="selectgroup-item">
                        <input type="radio" name="value" value="1" class="selectgroup-input select-layout" checked="">
                        <span class="selectgroup-button">Claro</span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="value" value="2" class="selectgroup-input select-layout">
                        <span class="selectgroup-button">Oscuro</span>
                      </label>
                    </div>
                  </div>
                  <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Color de la barra lateral</h6>
                    <div class="selectgroup selectgroup-pills sidebar-color">
                      <label class="selectgroup-item">
                        <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                      </label>
                      <label class="selectgroup-item">
                        <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked="">
                        <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip" data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                      </label>
                    </div>
                  </div>
                  <div class="p-15 border-bottom">
                    <h6 class="font-medium m-b-10">Color del tema</h6>
                    <div class="theme-setting-options">
                      <ul class="choose-theme list-unstyled mb-0">
                        <li title="white" class="active">
                          <div class="white"></div>
                        </li>
                        <li title="cyan">
                          <div class="cyan"></div>
                        </li>
                        <li title="black">
                          <div class="black"></div>
                        </li>
                        <li title="purple">
                          <div class="purple"></div>
                        </li>
                        <li title="orange">
                          <div class="orange"></div>
                        </li>
                        <li title="green">
                          <div class="green"></div>
                        </li>
                        <li title="red">
                          <div class="red"></div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="p-15 border-bottom">
                    <div class="theme-setting-options">
                      <label>
                        <span class="control-label p-r-20">Mini barra lateral</span>
                        <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input" id="mini_sidebar_setting">
                        <span class="custom-switch-indicator"></span>
                      </label>
                    </div>
                  </div>
                  <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                    <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                      <i class="fas fa-undo"></i> Restore Default
                    </a>
                  </div>
                </div>
              </div>
            </div>
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
    <!-- Copied from http://radixtouch.in/templates/admin/aegis/source/light/blank.html by Cyotek WebCopy 1.7.0.600, Saturday, September 21, 2019, 2:51:57 AM -->
  </html>