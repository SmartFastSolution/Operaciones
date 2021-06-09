<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="atenderRequerimiento" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="atenderRequerimientoLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content bg-secondary">
      <div class="modal-header">
        @if ($editMode)
        <h5 class="modal-title" id="exampleModalCenterTitle">Actualización de Requerimiento</h5>
        @else
        <h5 class="modal-title" id="exampleModalCenterTitle">Atención De Requerimiento</h5>
        @endif
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @if($errors->has('latitud') or $errors->has('operador_id'))
        <div class="alert alert-danger alert-has-icon">
          <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
          <div class="alert-body">
            <div class="alert-title">Tienes estos errores</div>
            <span>{{ $errors->first('latitud') }}</span><br>
            <span>{{ $errors->first('operador_id') }}</span>
            <span>{{ $errors->first('archivos.*') }}</span>
          </div>
        </div>
        @endif
        <h3 class="text-center">DATOS DE LA ATENCIÓN</h3>
        <div class="form-row">
          
          <div class="form-group col-sm-12 col-md-12">
            <label for="inputEmail4">Detalle</label>
            <textarea  cols="30" rows="10" wire:model.defer="detalle_atencion" placeholder="Agregar detalle del requerimiento" class="form-control @error('detalle_atencion') is-invalid @enderror"></textarea>
            @error('detalle_atencion')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-sm-12 col-lg-5">
            <label for="inputAddress">Fecha de Atención</label>
            <input type="date" wire:model.defer="fecha_atencion" class="form-control @error('fecha_atencion') is-invalid @enderror"  placeholder="">
            @error('fecha_atencion')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-sm-12 col-lg-7">
            <label for="recipient-name"  class="col-form-label">Selecciona los Archivos:</label>
            <div class="custom-file">
              <input type="file" wire:model="archivos" class="custom-file-input" id="customArchivos" multiple>
              <label class="custom-file-label" for="customArchivos">@if(count($archivos) > 0) Archivos cargados @endif</label>
            </div>
            @error('archivos.*')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
        </div>
        <div wire:ignore id="requerimiento"  class="form-row">
          <div class="form-group col-sm-12 col-lg-12" v-if="estado == 'pendiente'" >
            <label for="inputAddress">Operador</label>
             <model-list-select :list="operadores"
            v-model="operador_id"
            class="form-control"
            option-value="id"
            option-text="nombres"
            placeholder="Elije Un Requerimiento"
            @input="operadorEmit"
            >
            @error('operador_id')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="form-group col-sm-12 col-md-12">
            <label for="inputAddress">Observación</label>
            <vue-ckeditor v-model="detalle_actividad" :config="config"/>
            @error('observacion_requerimiento')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
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
                icon="http://maps.google.com/mapfiles/kml/paddle/grn-circle.png"
              ></gmap-marker>
            </gmap-map>
            @error('latitud')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div>
        </div>
      </div>
      <div class="modal-footer br">
        @if ($editMode)
        <button type="button" class="btn btn-warning" @if ($createDisabled) disabled="" @endif wire:click="$emit('actualizarObservacion')">Actualizar Atención</button>
        @else
        <button type="button" class="btn btn-primary" @if ($createDisabled) disabled="" @endif  wire:click="$emit('guardarObservacion')">Crear Atención</button>
        @endif
      </div>
    </div>
  </div>
</div>