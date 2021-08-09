@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-arrow-circle-right"></i> Egresos</li>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
@endsection
@section('bodega', 'active')
@section('egresos', 'active')
@section('content')
@section('titulo', '| Egresos')
<div>
	<h1 class="text-danger text-center">EGRESOS</h1>
	@livewire('coordinador.producto.egresos')
</div>
@endsection
@section('js')
    <script type="text/javascript">
	let productos    = @json($productos);
	let medidas      = @json($medidas);
	let conversiones = @json($conversiones);
	const egresos = new Vue({
	  el: "#egresos",
	  name:"Egresos",
	  data:{
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
	  methods:{
	  	changeUnidad(){
	  		let find  = this.productos.filter(x => x.id == this.producto_id );
	  		this.medida = find[0].medida;
	  		this.unidad_id = find[0].medida_id;
	  		this.conversion();
	  	},
	  	 conversion(){
	  		// console.log(find[0])
	  		this.cantidad_real = this.calcularfactor();
	  		// this.unidad_id = find[0].medida_id;
	  	},
	  	calcularfactor(){
	  		let find  = this.conversiones.filter(x => x.medida_base == this.medida.id   &&  x.medida_conversion == this.unidad_id);
	  		if (find.length == 1) {
	  			let real = find[0].factor * this.cantidad;
	  			return real;
	  		} else {
	  			return 0;
	  		}

	  	},
	  	agregarItem(){
	  		if (this.producto_id === '') {
	  			iziToast.error({
                title: 'Operaciones',
                message: 'No has seleccionado un Producto',
                position: 'topRight'
              });
	  		}else{
	  			let find  = this.items.filter(x => x.id == this.producto_id );

	  			if (find.length == 1) {
	  				iziToast.error({
                title: 'Operaciones',
                message: 'Este producto ya esta en la lista',
                position: 'topRight'
              });
	  			return
	  			}else if(this.cantidad_real === 0){
			  		iziToast.error({
		                title: 'Operaciones',
		                message: 'No puedes agregar una cantidad de 0',
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
	  			let producto  = this.productos.filter(x => x.id == this.producto_id );
	  			// console.log(producto)
	  			// if (producto[0].cantidad < this.cantidad_real){
	  			// iziToast.error({
      //           title: 'Operaciones',
      //           message: 'La cantidad seleccionada supera el stock',
      //           position: 'topRight'
      //         });
	  			// return
	  			// }
	  			let valorxunidad = producto[0].presentacion /  producto[0].precio_venta;
	  			let total = Number(valorxunidad * this.cantidad_real).toFixed(3);
	  			let item = {
	  				id: this.producto_id, nombre:producto[0].nombre, medida_base:this.unidad_id, medida_conversion: this.medida.id , cantidad_unidad: Number(this.cantidad), cantidad_base:this.cantidad_real, medida_real:producto[0].medida.simbolo,  total:total
	  			}
	  			this.items.push(item);
	  			console.log(item);
	  			// }
					this.cantidad      = 1;
					this.producto_id   = '';
					this.unidad_id     = '';
					this.cantidad_real = null;
					this.medida        = {};

	  		}
	  	},
	  	cambioCantidad(index){
	  		let producto  = this.productos.filter(x => x.id == this.items[index].id );
	  		let total = Number(this.items[index].cantidad) * producto[0].precio_venta;
	  		this.items[index].total = total.toFixed(2);
	  	},
	  	incremento(index){

					let cantidad               = this.items[index].cantidad + 1;
					let producto               = this.productos.filter(x => x.id == this.items[index].id );
					let total                  = Number(cantidad) * producto[0].precio_venta;
					this.items[index].cantidad = cantidad;
					this.items[index].total    = total.toFixed(2);

	  	},
	  	decremento(index){

					let cantidad               = this.items[index].cantidad - 1;
					let producto               = this.productos.filter(x => x.id == this.items[index].id );
					let total                  = Number(cantidad) * producto[0].precio_venta;
					this.items[index].cantidad = cantidad;
					this.items[index].total    = total.toFixed(2);
	  	},
	  	eliminarProducto(index){
          this.items.splice(index, 1);

	  	},
	  	generarEgreso(){
	  		if (this.codigo === '') {
	  		iziToast.error({
                title: 'Operaciones',
                message: 'No has agregado el codigo del egreso',
                position: 'topRight'
              });
	  		}else if (this.descripcion === ''){
	  		iziToast.error({
                title: 'Operaciones',
                message: 'No has agregado la descripción',
                position: 'topRight'
              });
	  		}else if (this.total_egreso === ''){
	  		iziToast.error({
                title: 'Operaciones',
                message: 'No has agregado el total de egreso',
                position: 'topRight'
              });
	  		}else if (this.items.length == 0){
	  		iziToast.error({
                title: 'Operaciones',
                message: 'No has seleccionado ningun producto',
                position: 'topRight'
              });
	  		}else{
	  			this.creating = true;
	  			let datos = {
	  				codigo: this.codigo,
	  				descripcion: this.descripcion,
	  				items: this.items,
	  				total_egreso: this.total_egreso,
	  			}
	  			Livewire.emit('guardarEgreso',datos);
	  			 this.codigo = '';
				this.descripcion = '';
				this.items = [];
				this.total_egreso = '';

	  			this.creating = false;


	  		}

	  	},
	  	resetInput(){
	  		 this.codigo = '';
				this.descripcion = '';
				this.items = [];
				this.total_egreso = '';
	  	},
	  	actualizarEgreso(){
	  			if (this.codigo === '') {
	  		iziToast.error({
                title: 'Operaciones',
                message: 'No has agregado el codigo del egreso',
                position: 'topRight'
              });
	  		}else if (this.descripcion === ''){
	  		iziToast.error({
                title: 'Operaciones',
                message: 'No has agregado la descripción',
                position: 'topRight'
              });
	  		}else if (this.total_egreso === ''){
	  		iziToast.error({
                title: 'Operaciones',
                message: 'No has agregado el total de egreso',
                position: 'topRight'
              });
	  		}else if (this.items.length == 0){
	  		iziToast.error({
                title: 'Operaciones',
                message: 'No has seleccionado ningun producto',
                position: 'topRight'
              });
	  		}else{
	  			this.updating = true;
	  			let datos = {
	  				codigo: this.codigo,
	  				descripcion: this.descripcion,
	  				items: this.items,
	  				total_egreso: this.total_egreso,
	  			}
	  			Livewire.emit('actualizarEgreso',datos);
	  			 this.codigo = '';
				this.descripcion = '';
				this.items = [];
				this.total_egreso = '';
	  			this.updating = false;


	  		}
	  	},
	  	editarEgreso(datos){
	  			this.egreso_id = datos.egreso.id;
	  			this.codigo = datos.egreso.codigo;
				this.descripcion = datos.egreso.descripcion;
				this.total_egreso = datos.egreso.total_egreso;
	  			this.cargarItems(datos.items);
	  			this.updateMode = true;
	  	},
	  	cargarItems(items){
	  	let set = this;
	  	items.forEach(function(item) {
	  	let producto  = set.productos.filter(x => x.id == item.id );

		let valorxunidad = producto[0].presentacion /  producto[0].precio_venta;
		let total = Number(valorxunidad * item.pivot.cantidad_real).toFixed(3);
		let ite = {
			id: producto[0].id, nombre:producto[0].nombre, medida_base:set.unidad_id, medida_conversion: set.medida.id , cantidad_unidad: Number(set.cantidad), cantidad_base:item.pivot.cantidad_real, medida_real:producto[0].medida.simbolo,  total:total
		}
		set.items.push(ite);
	  	});

	  	}
	  }
	});

	  	Livewire.on('editarEgreso',function(datos) {
	  		egresos.editarEgreso(datos);
	  		console.log(datos);
	  	});

</script>
@endsection
