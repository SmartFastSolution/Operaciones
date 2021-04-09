<div wire:ignore.self class="modal fade" id="crearProducto" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="crearProductoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h5 class="modal-title text-light" id="exampleModalCenterTitle">Crear Producto</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if ($editMode)
        <h3 class="text-center">ACTUALIZAR PRODUCTO</h3>
        @else
        <h3 class="text-center">CREAR NUEVO PRODUCTO</h3>
          
        @endif

        @isset($foto)
        <div class="row justify-content-center">
          <figure class="avatar mr-2 avatar-xl">
            <img src="{{ $foto->temporaryUrl() }}" >
          </figure><br>
          {{-- <small id="passwordHelpBlock" class="form-text text-danger">{{ $foto->getClientOriginalName() }} </small> --}}
        </div>
        @endisset
        <div class="form-row justify-content-center">
          <div class="form-group col-6">
            <label for="recipient-name"  class="col-form-label">IMAGEN:</label>
            <div class="custom-file">
              <input type="file" wire:model="foto" accept="image/x-png,image/gif,image/jpeg"  class="custom-file-input" id="customFile">
              <label class="custom-file-label" for="customFile">@isset($foto) {{ $foto->getClientOriginalName() }} @endisset</label>
            </div>
            @error('foto') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Nombre</label>
            <input type="text" class="form-control" wire:model.defer="nombre_producto">
            @error('nombre_producto') <span class="error text-danger">{{ $message }}</span> @enderror

          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Presentacion</label>
            <input type="text" class="form-control" wire:model.defer="presentacion_producto">
            @error('presentacion_producto') <span class="error text-danger">{{ $message }}</span> @enderror

          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Unidad de medida</label>
            <select name="" id="" class="custom-select" wire:model.defer="medida_id">
              <option value="" selected="" disabled="">Unidad de medida</option>
              @foreach ($medidas as $medida)
              <option value="{{ $medida->id }}">{{ $medida->unidad }}</option>
              @endforeach
            </select>
            @error('medida_id') <span class="error text-danger">{{ $message }}</span> @enderror

          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Precio Compra</label>
            <input type="number" class="form-control text-right" wire:model.defer="compra_producto">
            @error('compra_producto') <span class="error text-danger">{{ $message }}</span> @enderror

          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Precio Venta</label>
            <input type="number" class="form-control text-right" wire:model.defer="venta_producto">
            @error('venta_producto') <span class="error text-danger">{{ $message }}</span> @enderror

          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Cuenta Contable</label>
            <input type="text" class="form-control" wire:model.defer="cuenta_producto">
            @error('cuenta_producto') <span class="error text-danger">{{ $message }}</span> @enderror

          </div>
          
        </div>
        <div class="form-inline">
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Estado</label>
            <div class="pretty p-switch p-fill">
              <input type="checkbox" wire:model="status">
              <div class="state p-success">
                <label class="text-danger font-weight-bold">@if ($status)
                  On @else Off
                @endif</label>
              </div>
            </div>
          </div>
          <div class="form-group col-lg-4 col-sm-12">
            <label for="">Porcentual</label>
            <div class="pretty p-switch p-fill">
              <input type="checkbox" wire:model="porcentual">
              <div class="state p-success">
                <label></label>
              </div>
            </div>
          </div>
          @if ($porcentual)
          <div class="form-group col-lg-4 col-sm-12">
            <label for="" class="mr-1">IVA</label>
            <input type="number" wire:model.defer="iva_producto" class="form-control text-right">
            @error('iva_producto') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>
          @endif
        </div>
        
      </div>
      <div class="modal-footer br">
          @if ($editMode)
        <button type="button" class="btn btn-warning" wire:click="updateProducto">Actualizar Producto</button>
        @else
        <button type="button" class="btn btn-primary" wire:click="crearProducto">Crear Producto</button>
        @endif
      </div>
    </div>
  </div>
</div>