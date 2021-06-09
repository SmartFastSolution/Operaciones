@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('coordinador.requerimiento.index') }}"><i class="fas fa-clipboard-list"></i> Requerimientos</a></li>
<li class="breadcrumb-item"><a href="{{ route('coordinador.requerimiento.show', $id) }}"><i class="fas fa-clipboard-list"></i> Requerimiento # {{ $id }}</a></li>
<li class="breadcrumb-item active" aria-current="page"> Editar Atención </li>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
<style type="text/css">
	<style>
    .drop-active {
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        position: fixed;
        z-index: 9999;
        opacity: 0.6;
        text-align: center;
        background: #000;
    }
    .drop-active h3 {
        margin: -0.5em 0 0;
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        -webkit-transform: translateY(-50%);
        -ms-transform: translateY(-50%);
        transform: translateY(-50%);
        font-size: 40px;
        color: #fff;
        padding: 0;
    }
</style>
</style>
@endsection
@section('requerimiento', 'active')
@section('requerimientos', 'active')
@section('content')
@section('titulo', '| Asignacion')
<div  id="atencion">
	<h1 class="text-danger text-center">REQUERIMIENTO # {{ $id }}</h1>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="p-2">
					<div class="card-head"></div>
					<div class="card-body">
						<h3 class="text-center">DATOS DE LA ATENCIÓN</h3>
						<div class="form-row">
							@role('coordinador')
							<div class="form-group col-sm-12 col-lg-4">
								<label for="inputAddress">OPERADOR</label>
								<model-list-select :list="operadores"
								v-model="operador_id"
								:class="hasOperador"
								option-value="id"
								option-text="nombres"
								placeholder="Elije Un Operador"
								
								{{-- @input="operadorEmit" --}}
								>
								<p class="error-message text-danger font-weight-bold" v-if="errors.operador_id">@{{ errors.operador_id[0] }}</p>
									
							</div>
							@endrole
							<div class="form-group col">
								<label for="inputAddress">Fecha de Atencion</label>
								<input type="date" v-model="fecha_atencion" class="form-control @error('fecha_atencion') is-invalid @enderror"  placeholder="">
								<p class="error-message text-danger font-weight-bold" v-if="errors.fecha_atencion">@{{ errors.fecha_atencion[0] }}</p>

								
							</div>
							
							<div class="form-group col-sm-12 col-md-12">
								<label for="inputEmail4">Detalle</label>
								<p class="error-message text-danger font-weight-bold" v-if="errors.detalle_atencion">@{{ errors.detalle_atencion[0] }}</p>
								<textarea  cols="30" rows="10" v-model="detalle_atencion"  placeholder="Agregar detalle del requerimiento" class="form-control"></textarea>
								
								
							</div>
							<div class="form-group col-sm-12 col-md-12">
								<label for="inputEmail4">Observacion</label>
								<p class="error-message text-danger font-weight-bold" v-if="errors.observacion">@{{ errors.observacion[0] }}</p>
								<vue-ckeditor v-model="observacion" :config="config"/>
								
							</div>
							   <div class="form-group col-sm-12 col-md-12">
            <label >Ubicación Georeferenciada</label>
            <gmap-map
              :center="center"
              :zoom="12"
              style="width:100%;  height: 350px;"
              @click="clicked"
              >
              <gmap-marker
                v-if="puntuacion.lat !== ''"
                :position="puntuacion"
                icon="https://maps.google.com/mapfiles/kml/paddle/grn-circle.png"
              ></gmap-marker>
            </gmap-map>
			<p class="error-message text-danger font-weight-bold" v-if="errors.latitud">@{{ errors.latitud[0] }}</p>
			<p class="error-message text-danger font-weight-bold" v-if="errors.longitud">@{{ errors.longitud[0] }}</p>

          </div>
							
							<div class="form-group col-sm-12 col-lg-6">
								<h2 for="inputAddress">AGREGAR EGRESO <input type="checkbox" v-model="has_egreso" class="form-check-inline"></h2>
								
								
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card">
				<div class="p-2">
					<div class="card-head"><h2 class="text-center text-danger font-weight-bold">CARGA DE ARCHIVOS</h2></div>
					<div class="card-body">
						<div class="multiple-uploader">
							<div v-show="$refs.uploader && $refs.uploader.dropActive" class="drop-active">
								<h3>Deja caer aquí los archivos</h3>
							</div>
							<table class="table table-condensed" v-if="imagenes.length">
								<tr>
									<th>Nombre</th>
									<th class="text-right">Acciones</th>
								</tr>
								<tr v-for="file in imagenes" :key="file.id">
									<td>@{{ file.name }}</td>
									<td class="text-right">
										<button
										class="btn btn-danger btn-sm"
										@click.exact="$refs.uploader.remove(file)"
										>
										<i class="fas fa-trash"></i> Eliminar</button
										>
									</td>
								</tr>
							</table>
							<div class="alert alert-info text-center" v-else>
								Todavía no has subido ningún archivo
							</div>
							<div class="card">
								<div class="card-body">
									<div class="text-center justify-content-center align-content-center card-title">
										<div class="col-12 p-4">
											<button type="button" class="btn brand-color btn-lg">
											<label class="btn" for="uploader" style="background: #2ab27b; color: white !important; cursor: pointer;">
												<i class="fas fa-upload"></i> Seleccionar documentos
											</label>
											</button>
										</div>
									</div>
									<hr />
									{{-- <button @click="upload" class="btn btn-success">Subir archivos</button> --}}
								</div>
							</div>
							<div class="upload">
								<div class="btn-group">
									<file-upload
									class="btn btn-primary dropdown-toggle"
									style="display: none"
									input-id="uploader"
									:extensions="extensions"
									:accept="mime_types"
									:multiple="multiple"
									:directory="directory"
									{{-- :drop="true" --}}
									:drop-directory="dropDirectory"
									v-model="imagenes"
									{{-- @input-filter="inputFilter" --}}
									ref="uploader"
									:size="1024"
									>
									</file-upload>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-8 col-sm-12" v-if="has_egreso">
			<div class="card">
				<div class="p-2">
					<div class="card-head"><h2 class="text-center text-danger font-weight-bold">EGRESO</h2></div>
					<div class="card-body">
						<h2 class="text-center text-danger font-weight-bold">DATOS DEL EGRESO</h2>
						<div class="form-row">
							<div class="form-group col-lg-6 col-sm-12">
								<label>Codigo de Egreso</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-key"></i>
										</div>
									</div>
									<input type="text" v-model="egreso.codigo" class="form-control text-right">
								</div>
								<p class="error-message text-danger font-weight-bold" v-if="errors.codigo">@{{ errors.codigo[0] }}</p>

							</div>
							<div class="form-group col-lg-6 col-sm-12">
								<label>Total de Egreso</label>
								<div class="input-group">
									<div class="input-group-prepend">
										<div class="input-group-text">
											<i class="fas fa-usd-square"></i>
										</div>
									</div>
									<input type="number" v-model="egreso.total_egreso" class="form-control text-right">

								</div>
								<p class="error-message text-danger font-weight-bold" v-if="errors.total_egreso">@{{ errors.total_egreso[0] }}</p>

							</div>
						
							<div class="form-group col-lg-12 col-sm-12">
								<label for="">Descripción del Egreso</label>
								<textarea name="" id="" cols="30" rows="10" class="form-control" v-model="egreso.descripcion"></textarea>
								<p class="error-message text-danger font-weight-bold" v-if="errors.descripcion">@{{ errors.descripcion[0] }}</p>

							</div>
						</div>
						<div class="border p-2">
							<h4 class="text-center text-danger font-weight-bold">PRODUCTOS</h4>
							<div class="form-row justify-content-center">
								<div class="form-group col-lg-4 col-sm-12">
									<select name="" v-model="egreso.producto_id" id="" class="form-control" @change="changeUnidad">
										<option value="" selected="" disabled="">SELECCIONA UN PRODUCTO</option>
										<option v-for="(producto, index) in productos" :value="producto.id"> @{{ producto.nombre }}, @{{ producto.medida.simbolo }}</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-sm-12">
									<input type="number" class="form-control text-right" v-model="egreso.cantidad" min="1" @change="conversion" placeholder="cantidad">
								</div>
								<div class="form-group col-lg-3 col-sm-12">
									<select name="" id="" v-model="egreso.unidad_id" class="custom-select" @change="conversion">
										<option value="" selected="" disabled="">Seleccione Unidad Base</option>
										<option v-for="(unidad, index) in medidas" :value="unidad.id"> @{{ unidad.unidad }}, @{{ unidad.simbolo }}</option>
									</select>
								</div>
								<div class="form-group col-lg-2 col-sm-12">
									<input type="number" class="form-control text-right" disabled="" v-model="egreso.cantidad_real" min="1" placeholder="Cant">
								</div>
								<div class="form-group col-lg-2 col-sm-12">
									<button class="btn btn-danger" @click.prevent="agregarItem()">Agregar</button>
								</div>
							</div>
							<h3 class="text-danger font-italic text-center">Productos</h3>
							<div class="table-responsive">
								<table class="table table-striped">
									<thead class="text-light-all bg-dark">
										<tr>
											<th class="text-center">Producto</th>
											{{-- <th>Cantidad</th> --}}
											<th class="text-center">Cantidad</th>
											{{-- <th>Precio</th> --}}
											<th class="text-center">Total($)</th>
											<th>Borrar</th>
										</tr>
									</thead>
									<tbody>
										<tr v-for="(product, index) in egreso.items">
											<td>@{{ product.nombre }}</td>
											{{--     <td width="150">
												@{{ product.cantidad_unidad }}
											</td> --}}
											<td class="text-center">@{{ product.cantidad_base }} (@{{ product.medida_real }})</td>
											<td class="text-center">@{{ product.total }}</td>
											<td width="25"><button class="btn btn-danger" @click.prevent="eliminarProducto(index)"><i class="fa fa-trash"></i></button></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
	<div class="row justify-content-center">
		<button class="btn btn-success" :disabled="buttonDisable" @click.prevent="submitAtencion()">Actualizar Atencion</button>
	</div>
</div>
@endsection
@section('js')
<script src="https://cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script>
<script type="text/javascript">
	let id           = @json($id);
	let at   = @json($atencion);
	let atencionID   = @json($atencion->id);

	let operadores   = @json($operadores);
	let productos    = @json($productos);
	let conversiones = @json($conversiones);
	let medidas      = @json($medidas);
	let operador     = @json($requerimiento->operador_id);
	let hasoperador  ='form-control disabled';
	if (operador == null) {
		hasoperador = 'form-control ';
		operador    = '';
	} 
	
	let link = '{{ route('coordinador.requerimiento.show', $id) }}';
	console.log(link);

	const atencion = new Vue({
	  el: "#atencion",
	  data:{
	  	egreso:{
		  	codigo:'',
		  	descripcion:'',
		  	total_egreso:'',
		  	productos:productos,
		  	medidas:medidas,
		  	conversiones:conversiones,
		  	items:[],
		  	medida:{},
		  	atencion_id:'',
		  	egreso_id:'',
		  	producto_id:'',
		  	cantidad: 1,
		  	cantidad_real: null,
		  	unidad_id:'',
		  	updateMode: false,
		  	creating:false,
			updating:false,
	  	},
	  	center: { lat: at.latitud, lng: at.longitud },
		puntuacion: { lat:at.latitud , lng:at.longitud  },
	  	files:[],
	  	productos:productos,
	  	conversiones:conversiones,
	  	medidas:medidas,
	  	hasOperador:hasoperador,
	  	operadores:operadores,
	  	operador_id:operador,
	  	has_egreso: false,
	  	detalle_atencion: at.detalle,
		observacion: at.observacion,
		fecha_atencion: at.fecha_atencion,
	  	config: {
        toolbar: [
          ['Bold', 'Italic', 'Underline', 'Strike', 'Styles', 'TextColor', 'BGColor', 'UIColor' , 'JustifyLeft' , 'JustifyCenter' , 'JustifyRight' , 'JustifyBlock' , 'BidiLtr' , 'BidiRtl' , 'NumberedList' , 'BulletedList' , 'Outdent' , 'Indent' , 'Blockquote' , 'CreateDiv','Format','Font','FontSize']
        ],
    	},
	  	imagenes:[],
	  	errors:[],
	  	buttonDisable:false,
	  	multiple: true,
                directory: false,
                drop: true,
                dropDirectory: true,
                name: "file",
                mime_types: "application/vnd.ms-excel,application/msword,application/pdf,image/png,image/gif,image/jpeg,image/webp",
                extensions: "xls,doc,docx,pdf,jpg,jpeg,png",

	 //  	coordinador:coordinador,
		// operador:operador,

	  },

	  methods:{
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
	  	onFiles(e)
	  	{
	  		// let archivos = [];
	  		let set = this;

	  		for (var i = 0; i < e.target.files.length; i++) {
	  		set.imagenes[i] = e.target.files[i];
	  			
	  		}
	  		// console.log(archivos);

	  		// archiv
	  		// archivos.forEach(function(index){           
     //  });
	  	},
	  	  inputFilter(newFile, oldFile, prevent) {
                if (newFile && !oldFile) {
                    if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
                        return prevent();
                    }
                    if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
                        return prevent();
                    }
                    if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(newFile.name)) {
                        return prevent();
                    }
                }
                if (newFile && (!oldFile || newFile.file !== oldFile.file)) {
                    newFile.blob = "";
                    let URL = window.URL || window.webkitURL;
                    if (URL && URL.createObjectURL) {
                        newFile.blob = URL.createObjectURL(newFile.file);
                    }
                }
            },
	  	submitAtencion(){
	  		if (this.egreso.items.length <= 0 && this.has_egreso == true) {
	  			return iziToast.error({
                title: 'Operaciones',
                message: 'No has agregado un productoa la lista',
                position: 'topRight'
              });
	  		}
		   this.buttonDisable = true;
	  		let set = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                // let url = if (true) {}
                let data = new FormData();
            	data.append('numero',this.imagenes.length );

                for (var i = 0; i < this.imagenes.length; i++) {
                data.append('imagenes[]', this.imagenes[i].file);
                }
            	data.append('operador_id',set.operador_id );
            	data.append('detalle_atencion',set.detalle_atencion );
            	data.append('observacion',set.observacion );
            	data.append('fecha_atencion',set.fecha_atencion );
            	data.append('latitud',set.puntuacion.lat );
            	data.append('longitud',set.puntuacion.lng );
            	data.append('egreso',set.has_egreso );
            	if (set.has_egreso) {
            	data.append('codigo',set.egreso.codigo );
            	data.append('descripcion',set.egreso.descripcion );
            	data.append('total_egreso',set.egreso.total_egreso );
            	} 
            	data.append('items', JSON.stringify(set.egreso.items));
                axios.post('/coordinador/requerimiento/'+id+'/atencion/'+atencionID+'/update', data, config)
                    .then(function (res) {
                    	// console.log(res.data)
		                this.buttonDisable=true;
		                let link ='{{ route('coordinador.requerimiento.show', $id) }}';
  		      			window.location = link;
                    })
                    .catch(function (error) {
                         if (error.response.status === 422) {
		                    set.errors = error.response.data.errors;
		                }
		                set.buttonDisable=false;
                    });
	  	},

	  	  	changeUnidad(){
	  		let find  = this.productos.filter(x => x.id == this.egreso.producto_id );
	  		this.egreso.medida = find[0].medida;
	  		this.egreso.unidad_id = find[0].medida_id;
	  		this.conversion();
	  	},
	  	 conversion(){
	  		// console.log(find[0])
	  		this.egreso.cantidad_real = this.calcularfactor();
	  		// this.unidad_id = find[0].medida_id;
	  	},
	  	calcularfactor(){
	  		let find  = this.conversiones.filter(x => x.medida_base == this.egreso.medida.id   &&  x.medida_conversion == this.egreso.unidad_id);
	  		if (find.length == 1) {
	  			let real = find[0].factor * this.egreso.cantidad;
	  			return real;
	  		} else {
	  			return 0;
	  		}
	  		
	  	},
	  	agregarItem(){
	  		if (this.egreso.producto_id === '') {
	  			iziToast.error({
                title: 'Operaciones',
                message: 'No has seleccionado un Producto',
                position: 'topRight'
              });
	  		}else{
	  			let find  = this.egreso.items.filter(x => x.id == this.egreso.producto_id );
	  			if (find.length == 1) {
	  				iziToast.error({
                title: 'Operaciones',
                message: 'Este producto ya esta en la lista',
                position: 'topRight'
              });
	  			return
	  			}
	  		
	  			// if (find.length == 1) {
	  			// 	let can = (find[0].cantidad + Number(this.cantidad));
	  			// 	find[0].cantidad = can;
	  			// 	let producto  = this.productos.filter(x => x.id == this.producto_id );
	  			// 	let total = (producto[0].precio_venta * this.cantidad);
	  			// 	find[0].total = find[0].total + total;
	  			// } else {
	  			let producto  = this.productos.filter(x => x.id == this.egreso.producto_id );
	  			// console.log(producto)
	  			if (producto[0].cantidad < this.egreso.cantidad_real){
	  			iziToast.error({
                title: 'Operaciones',
                message: 'La cantidad seleccionada supera el stock',
                position: 'topRight'
              });
	  			return
	  			}
	  			let valorxunidad = producto[0].presentacion /  producto[0].precio_venta;
	  			let total = Number(valorxunidad * this.egreso.cantidad_real).toFixed(3);
	  			let item = {
	  				id: this.egreso.producto_id, nombre:producto[0].nombre, medida_base:this.egreso.unidad_id, medida_conversion: this.egreso.medida.id , cantidad_unidad: Number(this.egreso.cantidad), cantidad_base:this.egreso.cantidad_real, medida_real:producto[0].medida.simbolo,  total:total
	  			}
	  			this.egreso.items.push(item);
	  			console.log(item);
	  			// }
					this.egreso.cantidad      = 1;
					this.egreso.producto_id   = '';
					this.egreso.unidad_id     = '';
					this.egreso.cantidad_real = null;
					this.egreso.medida        = {};
	  			
	  		}
	  	},
	  	cambioCantidad(index){
	  		let producto  = this.productos.filter(x => x.id == this.egreso.items[index].id );
	  		let total = Number(this.egreso.items[index].cantidad) * producto[0].precio_venta;
	  		this.egreso.items[index].total = total.toFixed(2);  		
	  	},
	  	eliminarProducto(index){
          this.egreso.items.splice(index, 1);   

	  	},
	  	
	  	resetInput(){
	  		 this.egreso.codigo = '';
				this.egreso.descripcion = '';
				this.egreso.items = [];
				this.egreso.total_egreso = '';
	  	},
	  	cargarItems(items){
	  	let set = this;
	  	items.forEach(function(item) {
	  	let producto  = set.productos.filter(x => x.id == item.id );
	
		let valorxunidad = producto[0].presentacion /  producto[0].precio_venta;
		let total = Number(valorxunidad * item.pivot.cantidad_real).toFixed(3);
		let ite = {
		id: producto[0].id, nombre:producto[0].nombre, medida_base:set.egreso.unidad_id, medida_conversion: set.egreso.medida.id , cantidad_unidad: Number(set.egreso.cantidad), cantidad_base:item.pivot.cantidad_real, medida_real:producto[0].medida.simbolo,  total:total
		}
		set.egreso.items.push(ite);
	  	});
	
	  	}
	  }
	
	});

if (at.egreso != null) {
		egreso                       = at.egreso;
		atencion.egreso.codigo       = egreso.codigo;
		atencion.egreso.descripcion  = egreso.descripcion;
		atencion.egreso.total_egreso = egreso.total_egreso;
		atencion.has_egreso =  true;
	  	atencion.cargarItems(egreso.productos);

		// console.log(egreso);
	}

</script>
@endsection