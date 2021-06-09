	const datos = new Vue({
	  el: "#datos",
	  data:{
	  	telefono:'',
	  	direccion:'',
	  	sector:'',
	  	foto:null,
		actividad_personal:'',
		detalle_actividad:'',
		horario_atencion:'',
		options: sectores,
		        config: {
        toolbar: [
          ['Bold', 'Italic', 'Underline', 'Strike', 'Styles', 'TextColor', 'BGColor', 'UIColor' , 'JustifyLeft' , 'JustifyCenter' , 'JustifyRight' , 'JustifyBlock' , 'BidiLtr' , 'BidiRtl' , 'NumberedList' , 'BulletedList' , 'Outdent' , 'Indent' , 'Blockquote' , 'CreateDiv','Format','Font','FontSize']
        ],
        height: 200,
        // extraPlugins: 'colorbutton,colordialog'
      }
	  },
	  mounted: function() {
			this.telefono           = user.telefono;
			this.direccion          = user.domicilio;
			this.sector             = user.sector_id;
			this.actividad_personal = user.actividad_personal;
			this.detalle_actividad = user.detalle_actividad;
			this.horario_atencion   = user.horario_atencion;
	  },
	  methods:{
	  	onSelect(){
	  		console.log('seleccionado')
	  	},
	  	  getImage(event){
		  	console.log('hola')
                //Asignamos la imagen a  nuestra data
                this.foto = event.target.files[0];
                console.log(this.foto)
                iziToast.info({
						title: 'PesPlanet',
						message: 'Imagen Seleccionada',
						position: 'topRight'
						});
                // this.updateAvatar()
            },
	  	guardarDatos(){
	  		let datos = {
	  			telefono: this.telefono,
				direccion: this.direccion,
				sector: this.sector,
				actividad_personal: this.actividad_personal,
				detalle_actividad: this.detalle_actividad,
				horario_atencion: this.horario_atencion,
				foto: this.foto
	  		}

				Livewire.emit('guardarDatos', datos)

	  	},
	  	cargarAvatar(){

	  	}
	  }
	
	});

	const mapa = new Vue({
		el: "#mapa",
		data:{
			center: { lat: -2.219662, lng: -79.929179 },
			position: null,
			infoWindowPos: null,
			infoWinOpen: false,
			infoOptions: {
			content: '',
			pixelOffset: {
			width: 0,
			height: -35
			}
			},
		},
			mounted() {
			this.geolocate();
			},
			methods: {
			clicked(e){
				this.center = {
				lat: e.latLng.lat(),
				lng: e.latLng.lng()
				};
			},
			toggleInfoWindow: function() {
			this.infoWindowPos = this.position;
			this.infoOptions.content = '<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createmateria" ><i class="fa fa-user-plus"></i> Crear Materia </button>';
			//check if its the same marker that was selected if yes toggle
			this.infoWinOpen = true;
			this.currentMidx = idx;
			},
			geolocate: function() {
				if (user.latitud && user.longitud) {
						this.center = {
						lat: user.latitud,
						lng: user.longitud
						};
				} else {
					this.center = {
						lat: -2.219662,
						lng: -79.929179
						};
				}
			},
			guardarUbicacion(){
				console.log('hola')
				Livewire.emit('guardarUbicacion', this.center)
			}
		}
});
	const galeria = new Vue({
	  el: "#galeria",
	  data:{
	  	    images: [
    ],
    index: null
	  },
	    methods: {
    onClick(i) {
      this.index = i;
    }
  },
	});
	
	Livewire.on('actualizar', function (data){
	$("#navbar-act").attr("src", data.avatar);
	$("#sidebar-act").attr("src", data.avatar);
   });

$(document).ready(function() {
	Livewire.emit('enviarImagenes');   
});
Livewire.on('imagenes', function (imagenes){
	galeria.images = imagenes.mensaje;
   });