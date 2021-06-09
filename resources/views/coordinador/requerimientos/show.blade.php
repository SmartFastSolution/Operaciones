@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('coordinador.requerimiento.index') }}"><i class="fas fa-clipboard-list"></i> Requerimientos</a></li>
<li class="breadcrumb-item active" aria-current="page"> {{ $id }}</li>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
@endsection
@section('requerimiento', 'active')
@section('productos', 'active')
@section('content')
@section('titulo', '| Requerimiento')
<div>
	@livewire('coordinador.requerimiento.requerimiento-detalles', [$id, $requerimiento->operador_id])
</div>
@endsection

@section('js')
<script type="text/javascript">
	@if (Session::has('error'))
  
          iziToast.error({
                title: 'Operaciones',
                message: 'Este Requerimiento ya fue Atendido',
                position: 'topRight'
              });
    
@endif

	let coordenada = @json($requerimiento);
	const mapa = new Vue({
	  el: "#mapa",
	  data:{
		center: { lat: coordenada.latitud, lng: coordenada.longitud },
	}
	
	});
</script>
<script src="https://cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script>
	<script type="text/javascript">
		let operadores = @json($operadores);
		let operador_id = @json($requerimiento->operador_id);
		let estado = @json($requerimiento->estado);
		const requerimiento = new Vue({
		  el: "#requerimiento",
		data:{
		detalle_actividad:'',
		center: { lat: -2.219662, lng: -79.929179 },
		puntuacion: { lat:'' , lng:''  },
        operador_id:operador_id,
        operadores:operadores,
        estado:estado,
        markers:[],
        config: {
        toolbar: [
          ['Bold', 'Italic', 'Underline', 'Strike', 'Styles', 'TextColor', 'BGColor', 'UIColor' , 'JustifyLeft' , 'JustifyCenter' , 'JustifyRight' , 'JustifyBlock' , 'BidiLtr' , 'BidiRtl' , 'NumberedList' , 'BulletedList' , 'Outdent' , 'Indent' , 'Blockquote' , 'CreateDiv','Format','Font','FontSize']
        ],
    	},
		  },
		  methods:{
		  	operadorEmit(){
		  		Livewire.emit('cargarOperador', this.operador_id);
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
				this.operador_id = '';
				this.detalle_actividad ='';
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
				this.operador_id       = datos.operador_id;
				this.detalle_actividad = datos.observacion_requerimiento;
			}
		  }
		});
		
			const atencion_mapa = new Vue({
			  el: "#atencion",
			  data:{
			  	center: { lat: -2.219662,
					lng: -79.929179  },
						position: { lat: -2.219662,
					lng: -79.929179  },
				imgatencion : '',
				imgreq : '',

			  }, 
			  mounted: function () {
			  	setTimeout(function(){
		  		Livewire.emit('createMapaAtencion');
			  	 }, 1000);

			  },
			  methods:{

			  }
			
			});

		Livewire.on('guardarObservacion', function () {
		  Livewire.emit('createRequerimiento', requerimiento.detalle_actividad);
			
		});

		Livewire.on('limpiarCampo', function () {
			requerimiento.limpiarCampos();			
		});

		Livewire.on('editarAtencion', function (datos) {
			// console.log(datos.latitud)
			requerimiento.cargarDatos(datos);			
		});

		Livewire.on('mapaAtencion', function (datos) {


			atencion_mapa.center.lat = datos.atencion.latitud;			
			atencion_mapa.center.lng = datos.atencion.longitud;	
			atencion_mapa.imgatencion= '';	

			atencion_mapa.position.lat = datos.requerimiento.latitud;			
			atencion_mapa.position.lng = datos.requerimiento.longitud;			
			atencion_mapa.imgreq= '';	
						
		});

		Livewire.on('actualizarObservacion', function () {
		  Livewire.emit('updaAtencion', requerimiento.detalle_actividad);
			
		});
	</script>
	<script type="text/javascript">
		
	</script>
@endsection
