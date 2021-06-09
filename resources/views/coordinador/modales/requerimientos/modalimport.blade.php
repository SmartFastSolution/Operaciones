<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="importarRequerimiento" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="importarRequerimientoLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h3 class="text-center font-weight-bold text-dark">Importar Requerimientos</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if (count($errores) > 0)
        <div class="alert alert-danger">
          @foreach ($errores as $error)
          <li>{{ $error }}</li>
          
          @endforeach
        </div>
        @endif
        <div class="form-row">
          <div class="form-group col-12">
            <label for="">Archivo Excel</label>
            <input type="file" wire:model="excel" class="form-control @error('excel') is-invalid @enderror">
            <small>Nota: Solo puedes agregar archivos con extensión .xlsx</small>
            @error('excel')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
      <div class="modal-footer br">
        
        <button wire:loading.remove.delay class="btn btn-success" wire:click.prevent="importExcel">Importar</button>
        <div wire:loading.delay wire:target="importExcel">
          <button class="btn btn-success" type="button" disabled>
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          Importando...
          </button>
        </div>
      </div>
    </div>
  </div>
</div>