@extends('layouts.landing.nav')
@section('titulo', '| Novedades')

@section('css')
<style type="text/css">
    .image {
  width: 100px;
  height: 100px;
  background-size: contain;
  cursor: pointer;
  margin: 10px;
  border-radius: 3px;
}
#header {
position: relative !important;
}
</style>
@endsection

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
          <li><a href="/#about">Sobre Nosotros</a></li>
          <li><a href="/#services">Servicios</a></li>
          <li><a href="/#portfolio">Portfolio</a></li>
          <li><a href="/#team">Equipo</a></li>
          <li><a href="/#contact">Contactanos</a></li>
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
<main id="main" class="mt-5">
  <h1 class="text-center text-danger font-weight-bold">COORDINADORES DISPONIBLES</h1>
  @livewire('component.mapa-coordinadores')
  </main><!-- End #main -->
@endsection
  @section('js')
  <script type="text/javascript">
  $("#header").removeClass("header-transparent");
  $(".nav-menu li").removeClass("menu-active");

  $(".nav-menu #novedades").addClass("menu-active");
  let center = { lat: -2.194958, lng: -79.893421 };
  console.log(center);
  let mapa = new Vue({
  el: "#mapa",
      data:{
      center: center,
      markers:[],
      index:null,
      index2:null,
      infoWindowPos: null,
      infoWinOpen: false,
      currentMidx: null,
      datosget:false,
      coordinador:{},
      img:[],
      infoOptions: {
      content: '',
      //optional: offset infowindow so it visually sits nicely on top of our marker
        pixelOffset: {
        width: 0,
        height: -35
        }
      },
  },
  mounted: function(){
  // this.geolocate();
  if (center.lat == null) {
  this.geolocate();
  } else {
  this.center =  center;
  }
  this.obtenerMapas();
  console.log('Componente montado')
  },
  methods:{
  onClick(i) {
  this.index = i;
  },
  onClick2(i) {
  this.index2 = i;
  },
  obtenerMapas(){
  setTimeout(function(){
  Livewire.emit('obtenerMapas');
    }, 1000);
  },
  cargarPuntos(mapas){
      this.markers = [];
      let set = this;
      // console.log(mapas);
      mapas.forEach(function(mapa){
        let center = {
        lat: mapa.latitud,
        lng: mapa.longitud
      };
      let icon = 'http://maps.google.com/mapfiles/kml/paddle/red-circle.png';
      if (mapa.estado === 'on') {
      icon = 'http://maps.google.com/mapfiles/kml/paddle/grn-circle.png'
      }
      let marker = {
        position: center, img: icon, requerimiento_id: mapa.id
      };
      // console.log(marker);
      set.markers.push(marker);
      set.center = center;
      
      });
  },
    geolocate: function() {
      navigator.geolocation.getCurrentPosition(position => {
      this.center = {
      lat: position.coords.latitude,
      lng: position.coords.longitude
      };
      });
    },
      resetInput(){
          this.requerimiento    = {};
          this.img     = [];
          this.datosget = false;
      },
  cargarRequerimiento(id, index){
      let set = this;
      let url = '/coordinador/'+id+'/informacion';
      axios.get(url).then(response => {
      // console.log(response.data);

      this.datosget = true;
      this.coordinador    = response.data.coordinador
      this.img = response.data.img
      // this.img_atencion     = response.data.img_atencion
      }).catch(function(error){
      });
      // $('#datos-tab2').tab('show')
      $('#modaldetalles').modal('show');
  },
  formatdistancia(distancia){
  if (distancia < 1) {
  let calculo = distancia * 1000;
  return calculo+ ' MTS'
  } else {
  return distancia+ ' KM'
  }
  }
  }
  });
  Livewire.on('mapas', function (mapas) {
    // console.log(mapas)
  mapa.cargarPuntos(mapas.mapas);
  });
  </script>
  @endsection