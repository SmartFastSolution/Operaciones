<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="createUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl " role="document">
    <div class="modal-content bg-secondary">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Crear Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{--
        --}}
        <h3 class="text-center text-dark">DATOS GENERALES</h3>
        <div class="form-row">
          <div class="form-group col-md-8">
            <label for="inputAddress">Nombres</label>
            <input type="text" wire:model.defer="reNombres" class="form-control @error('reNombres') is-invalid @enderror"  placeholder="Nombres y Apellidos">
            @error('reNombres')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-4">
            <label for="inputEmail4">Usuario</label>
            <input type="text" wire:model.defer="reUsuario" class="form-control @error('reUsuario') is-invalid @enderror" placeholder="Usuario">
            @error('reUsuario')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-6">
            <label for="inputEmail4">Cedula</label>
            <input type="number" wire:model.defer="reCedula" class="form-control @error('reCedula') is-invalid @enderror" placeholder="Cedula o DNI">
            @error('reCedula')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-md-6">
            <label for="inputPassword4">Correo</label>
            <input type="email" wire:model.defer="reEmail" class="form-control @error('reEmail') is-invalid @enderror" placeholder="Correo Electronico">
            @error('reEmail')
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
        <div class="form-group row">
          <label for="inputEmail3" class="col-sm-2 col-form-label">Selecciona un Rol</label>
          <div class="col-sm-10">
            <select wire:model="rol" class="custom-select @error('rol') is-invalid @enderror" >
              <option value="" selected disabled="">Elige un Rol</option>
              <option value="admin">Administrador</option>
              <option value="coordinador">Coordinador</option>
              <option value="operador">Operador</option>
            </select>
            @error('rol')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
      <div class="modal-footer br">
        @if ($editMode)
        <button type="button" class="btn btn-warning" wire:click="updateUser">Actualizar Usuario</button>
        @else
        <button type="button" class="btn btn-primary" wire:click="crearUsuario">Crear Usuario</button>
        @endif
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
      </div>
    </div>
  </div>
</div>