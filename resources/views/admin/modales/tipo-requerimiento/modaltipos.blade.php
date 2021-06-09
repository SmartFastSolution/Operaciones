<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="createTipos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="createTiposLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        @if ($editMode)
        <h5 class="modal-title" id="exampleModalCenterTitle">Actualización de Requerimiento</h5>
        @else
        <h5 class="modal-title" id="exampleModalCenterTitle">Crear Tipo de Requerimiento</h5>
        @endif
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{-- <h3 class="text-center">DATOS GENERALES</h3> --}}
        <div class="form-row">
          <div class="form-group col-md-12">
            <label for="inputAddress">Nombre</label>
            <input type="text" wire:model.defer="nombre_requerimiento" class="form-control @error('nombre_requerimiento') is-invalid @enderror"  placeholder="Nombre">
            @error('nombre_requerimiento')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-12">
            <label for="inputAddress">Parametrización</label>
            <input type="text" wire:model.defer="parametrizacion_requerimiento" class="form-control @error('parametrizacion_requerimiento') is-invalid @enderror"  placeholder="Parametrizacion">
            @error('parametrizacion_requerimiento')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-12">
            <label for="inputEmail4">Descripción</label>
            <textarea name="" id="" cols="30" rows="10" wire:model.defer="descripcion_requerimiento" class="form-control @error('descripcion_requerimiento') is-invalid @enderror"></textarea>
            @error('descripcion_requerimiento')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="selectgroup selectgroup-pills">
          Estado:
          <label class="selectgroup-item">
            <input type="radio" wire:model="estado" name="estado" value="on" class="selectgroup-input">
            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-toggle-on"></i></span>
          </label>
          <label class="selectgroup-item">
            <input type="radio" wire:model="estado" name="estado" value="off" class="selectgroup-input">
            <span class="selectgroup-button selectgroup-button-icon"><i class="fas fa-toggle-off"></i></span>
          </label>
          <span class="badge @if ($estado == 'on')
            badge-success @else badge-danger
          @endif">{{ $estado }}</span>
        </div>
      </div>
      <div class="modal-footer br">
        @if ($editMode)
        <button type="button" class="btn btn-warning" wire:click="updateTipo">Actualizar Tipo</button>
        @else
        <button type="button" class="btn btn-primary" wire:click="crearTipos">Crear Tipo</button>
        @endif
      </div>
    </div>
  </div>
</div>