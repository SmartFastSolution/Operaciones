<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="cargarArchivo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="cargarArchivoLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content bg-info">
      <div class="modal-header">
        <h5 class="modal-title text-light" id="exampleModalCenterTitle">Cargar Archivos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="text-center">ARCHIVOS</h3>
        <div class="form-row">
          <div class="form-group col-12">
            <label for="recipient-name"  class="col-form-label">Selecciona los Archivos:</label>
            <div class="custom-file">
              <input type="file" wire:model="photos" class="custom-file-input" id="customArchivos" multiple>
              <label class="custom-file-label" for="customArchivos">@if(count($photos) > 0) Archivos cargados @endif</label>
            </div>
            @error('photos.*')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div class="modal-footer br">
          <button type="button" class="btn btn-primary" wire:click="guardarDocumentos">Guardar Archivos</button>
        </div>
      </div>
    </div>
  </div>
</div>