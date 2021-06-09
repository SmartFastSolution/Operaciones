@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-map"></i> Mapa de requerimientos</li>
@endsection
@section('content')
<h2 class="text-center font-weight-bold text-danger">MAPA DE REQUERIMIENTOS</h2>
@livewire('operador.requerimientos.lista-requerimientos')
@section('requerimiento', 'active')
@section('ver_mapa', 'active')
@section('titulo', '| Mapa')

@endsection
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
</style>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>
<script type="text/javascript">
    "use strict";

 var toggle_sidebar_mini = function(mini) {
    let body = $("body");

  
      body.addClass("sidebar-mini");
      body.removeClass("sidebar-show");
      // sidebar_nicescroll.remove();
      // sidebar_nicescroll = null;
      $(".main-sidebar .sidebar-menu > li").each(function() {
        let me = $(this);

        if (me.find("> .dropdown-menu").length) {
          me.find("> .dropdown-menu").hide();
          me.find("> .dropdown-menu").prepend(
            '<li class="dropdown-title pt-3">' + me.find("> a").text() + "</li>"
          );
        } else {
          me.find("> a").attr("data-toggle", "tooltip");
          me.find("> a").attr("data-original-title", me.find("> a").text());
          $("[data-toggle='tooltip']").tooltip({
            placement: "right"
          });
        }
      });
    
  };
 toggle_sidebar_mini(true);

    // $(".select-layout[value|='1']").prop("checked", true);
    // toggle_sidebar_mini(true);
let center = { lat: @json(Auth::user()->latitud), lng: @json(Auth::user()->longitud) };
console.log(center);
let mapa = new Vue({
el: "#mapa",
    data:{
        center: { lat: -2.219662, lng: -79.929179 },
        markers:[],
        index:null,
        index2:null,
        infoWindowPos: null,
          infoWinOpen: false,
          currentMidx: null,
          datosget:false,
          requerimiento:{},
          img_requerimient:[],
          img_atencion:[],
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
        if (mapa.estado === 'ejecutado') {
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
      this.img_requerimient = [];
      this.img_atencion     = [];
              this.datosget = false;

    },
      cargarRequerimiento(id, index){
        let set = this;
        let url = '/coordinador/requerimiento/'+id+'/informacion';
            axios.get(url).then(response => {
              this.datosget = true;
              this.requerimiento    = response.data.requerimiento
              this.img_requerimient = response.data.img_requerimient
              this.img_atencion     = response.data.img_atencion
            console.log(response.data); 
        }).catch(function(error){

        });
        $('#datos-tab2').tab('show')
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
       mapa.cargarPuntos(mapas.mapas);
  });
</script>
@endsection