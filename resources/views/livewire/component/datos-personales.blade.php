<div>
	<h2 class="text-center font-weight-bold text-danger">DATOS PERSONALES</h2>
	<div class="form-row">
		<div class="form-group col-lg-8">
			<label for="">Nombres</label>
			<input type="text" class="form-control" disabled="" value="{{ $user->nombres }}">
		</div>
		<div class="form-group col-lg-4">
			<label for="">Cedula</label>
			<input type="text" class="form-control" disabled="" value="{{ $user->cedula }}">
		</div>
		<div class="form-group col-lg-6">
			<label for="">Telefono</label>
			<input type="number" class="form-control" wire:model.defer="telefono" >
		</div>
		<div class="form-group col-lg-6">
			<label for="">Celular</label>
			<input type="text" class="form-control" wire:model.defer="celular" >
		</div>
		<div class="form-group col-lg-12">
			<label for="">Dirección</label>
			<textarea name=" " id="" cols="30" rows="10" class="form-control" wire:model.defer="domicilio"></textarea>
		</div>
	</div>
	<div class="row justify-content-lg-center p-1">
		<a href="" class="btn btn-danger" wire:click.prevent="updateDate">ACTUALIZAR DATOS</a>
	</div>
</div><div>
    {{-- Success is as dangerous as failure. --}}
</div>
