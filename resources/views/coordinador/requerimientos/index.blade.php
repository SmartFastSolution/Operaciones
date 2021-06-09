@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-store"></i> Requerimientos</li>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
@endsection
@section('requerimiento', 'active')
@section('productos', 'active')
@section('content')
@section('titulo', '| Requerimientos')
<div>
	<h1 class="text-danger text-center">Administración de Requerimientos</h1>
	@livewire('coordinador.requerimiento.requerimiento')
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script>
	<script type="text/javascript">
		let sectores = @json($sectores);
		let tipos = @json($tipos);
		const requerimiento = new Vue({
		  el: "#requerimiento",

		data:{
		detalle_actividad:'',
		center: { lat: -2.219662, lng: -79.929179 },
		puntuacion: { lat:'' , lng:''  },

        tipos:tipos,
        requerimiento:'',
        sectores:sectores,
         config: {
        toolbar: [
          ['Bold', 'Italic', 'Underline', 'Strike', 'Styles', 'TextColor', 'BGColor', 'UIColor' , 'JustifyLeft' , 'JustifyCenter' , 'JustifyRight' , 'JustifyBlock' , 'BidiLtr' , 'BidiRtl' , 'NumberedList' , 'BulletedList' , 'Outdent' , 'Indent' , 'Blockquote' , 'CreateDiv','Format','Font','FontSize']
        ],
    	},
        sector:'',

		  },
		  methods:{
		  	sectorEmit(){
		  		Livewire.emit('cargarSector', this.sector);
		  	},
		  	requerimientoEmit(){
		  		Livewire.emit('cargarRequerimiento', this.requerimiento);
		  	},
		  	clicked(e){
				this.center = {
				lat: e.latLng.lat(),
				lng: e.latLng.lng()
				};
				this.puntuacion = {
				lat: e.latLng.lat(),
				lng: e.latLng.lng()
				};
		  		Livewire.emit('cargarUbicacion', this.puntuacion);

			},
			limpiarCampos(){
				this.center = {
					lat: -2.219662,
					lng: -79.929179 
				};
				this.puntuacion = {
					lat: '',
					lng: ''
				};
				this.requerimiento = '';
				this.detalle_actividad ='';
				this.sector ='';
			},
			cargarDatos(datos){
				this.center = {
				lat: datos.latitud,
				lng: datos.longitud 
				};
				this.puntuacion = {
				lat: datos.latitud,
				lng: datos.longitud
				};
				this.requerimiento     = datos.tipo;
				this.detalle_actividad =datos.observacion_requerimiento;
				this.sector            =datos.sector;
			}
		  }
		
		});

		Livewire.on('guardarObservacion', function () {
		  Livewire.emit('createRequerimiento', requerimiento.detalle_actividad);
			
		});

		Livewire.on('limpiarCampo', function () {
			requerimiento.limpiarCampos();			
		});

		Livewire.on('editarRequerimiento', function (datos) {
			// console.log(datos.latitud)
			requerimiento.cargarDatos(datos);			
		});

		Livewire.on('actualizarObservacion', function () {
		  Livewire.emit('updaRequerimiento', requerimiento.detalle_actividad);
			
		});
	</script>
@endsection