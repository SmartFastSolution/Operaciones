@extends('layouts.landing.nav')
@section('content')
 <!-- ======= Header ======= -->
  <header id="header" class="header-transparent">
    <div class="container">

      <div id="logo" class="pull-left">
        <a href="index.html"><img src="{{ asset('img/logo.png') }}" width="50" alt=""></a>
        <!-- Uncomment below if you prefer to use a text logo -->
        <!--<h1><a href="#hero">Regna</a></h1>-->
      </div>

      <nav id="nav-menu-container">
        <ul class="nav-menu">
          <li class="menu-active"><a href="{{ route('index') }}">Inicio</a></li>
          <li><a href="#about">Sobre Nosotros</a></li>
          <li><a href="#services">Servicios</a></li>
          <li><a href="#portfolio">Portfolio</a></li>
          <li><a href="#team">Equipo</a></li>
          <li><a href="#contact">Contactanos</a></li>
          <li id="novedades"><a href="{{ route('novedades') }}">Novedades</a></li>
           @guest
            <li class="nav-item">
              <li><a href="{{ route('login') }}">Inicia Sesion</a>
            </li>
            @else

      
              @role('admin|super-admin')
              <li><a href="{{ route('admin.index') }}">Administrador</a></li>
              @endrole

              @role('coordinador')
              <li><a href="{{ route('coordinador.index') }}">Coordinador</a></li>
              
              @endrole
              @role('operador')
              <li><a href="{{ route('operador.index') }}">Operador</a></li>
              @endrole
              <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >Cerrar Sesion</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
              </li>
          </li>
          @endif
        </ul>
      </nav><!-- #nav-menu-container -->
    </div>
  </header><!-- End Header -->
<!-- ======= Hero Section ======= -->
<section id="hero">
    <div class="hero-container" data-aos="zoom-in" data-aos-delay="100">
        <h1>Bienvenido a Operaciones</h1>
        {{-- <h2>We are team of</h2> --}}
        {{-- <a href="#about" class="btn-get-started">Get Started</a> --}}
    </div>
    </section><!-- End Hero Section -->
    <main id="main">
       @include('landing.sections.about')
       @include('landing.sections.facts')
       @include('landing.sections.services')
       @include('landing.sections.call-to-action')
       @include('landing.sections.portafolio')
       @include('landing.sections.team')
       @include('landing.sections.contact')
    </main><!-- End #main -->
    @endsection