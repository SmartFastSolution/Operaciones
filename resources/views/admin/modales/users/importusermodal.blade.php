<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="importUser" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="importUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-md " role="document">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h5 class="modal-title text-light" id="exampleModalCenterTitle">Importar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          @if ($errors->any())
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif
        <form wire:submit.prevent="save">
          <div class="form-group ">
            <label for="inputAddress">Importar</label>
            <input type="file" wire:model="file" class="form-control">
            @error('file') <span class="error text-danger">{{ $message }}</span> @enderror
          </div>
          
          <button type="submit" class="btn btn-danger">Importar</button>
        </form>
      </div>
      <div class="modal-footer br">
        <button type="button" class="btn btn-primary" wire:click="crearUsuario">Crear Usuario</button>
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
      </div>
    </div>
  </div>
</div>