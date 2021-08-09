<!-- Vertically Center -->
<div wire:ignore.self class="modal fade" id="createRequerimiento" data-backdrop="static" data-keyboard="false"
    tabindex="-1" aria-labelledby="createRequerimientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content bg-secondary">
            <div class="modal-header">
                @if ($editMode)
                    <h5 class="modal-title" id="exampleModalCenterTitle">Actualización de Requerimiento</h5>
                @else
                    <h5 class="modal-title" id="exampleModalCenterTitle">Crear Requerimiento</h5>
                @endif
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->all())
                    <div class="alert alert-danger alert-has-icon">
                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                        <div class="alert-body">
                            <div class="alert-title">Tienes estos errores</div>
                            @error('latitud')
                                <p class="error-message  font-weight-bold">{{ $message }}</p>
                            @enderror
                            @error('observacion_requerimiento')
                                <p class="error-message  font-weight-bold">{{ $message }}</p>
                            @enderror
                            @error('archivos.*')
                                <p class="error-message  font-weight-bold">{{ $message }}</p>
                            @enderror
                            @error('tipo_id')
                                <p class="error-message  font-weight-bold">{{ $message }}</p>
                            @enderror
                            @error('sector_id')
                                <p class="error-message  font-weight-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                @endif
                <h3 class="text-center">DATOS GENERALES</h3>
                <div class="form-row">
                    <div class="form-group col-sm-12 col-md-2">
                        <label for="inputAddress">Codigo</label>
                        <input type="text" wire:model.defer="codigo_requerimiento"
                            class="form-control @error('codigo_requerimiento') is-invalid @enderror"
                            placeholder="Codigo Requerimiento">
                        @error('codigo_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-2">
                        <label for="inputAddress">Cuenta</label>
                        <input type="text" wire:model.defer="cuenta_requerimiento"
                            class="form-control @error('cuenta_requerimiento') is-invalid @enderror"
                            placeholder="Cuenta">
                        @error('cuenta_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-5">
                        <label for="inputAddress">Nombre</label>
                        <input type="text" wire:model.defer="nombre_requerimiento"
                            class="form-control @error('nombre_requerimiento') is-invalid @enderror"
                            placeholder="Nombres del contacto">
                        @error('nombre_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-3">
                        <label for="inputAddress">Cedula</label>
                        <input type="text" wire:model.defer="cedula_requerimiento"
                            class="form-control @error('cedula_requerimiento') is-invalid @enderror"
                            placeholder="Cedula del contacto">
                        @error('cedula_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="inputAddress">Telefonos</label>
                        <input type="text" wire:model.defer="telefonos_requerimiento"
                            class="form-control @error('telefonos_requerimiento') is-invalid @enderror"
                            placeholder="Telefonos del contacto">
                        @error('telefonos_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="inputAddress">Correos</label>
                        <input type="text" wire:model.defer="correos_requerimiento"
                            class="form-control @error('correos_requerimiento') is-invalid @enderror"
                            placeholder="Correos del Contacto">
                        @error('correos_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-8">
                        <label for="inputAddress">Dirección</label>
                        <input type="text" wire:model.defer="direccion_requerimiento"
                            class="form-control @error('direccion_requerimiento') is-invalid @enderror"
                            placeholder="Direccion">
                        @error('direccion_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label for="inputAddress">Fecha Maxima</label>
                        <input type="date" wire:model.defer="fecha_requerimiento"
                            class="form-control @error('fecha_requerimiento') is-invalid @enderror"
                            placeholder="Correos del Contacto">
                        @error('fecha_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <label for="inputEmail4">Detalle</label>
                        <textarea name="" id="" cols="30" rows="10" wire:model.defer="detalle_requerimiento"
                            placeholder="Agregar detalle del requerimiento"
                            class="form-control @error('detalle_requerimiento') is-invalid @enderror"></textarea>
                        @error('detalle_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- <div class="form-group col-sm-12 col-md-4">
            <label for="inputAddress">Estado</label>
            <select name="" class="custom-select" id="" wire:model.defer="estado">
              <option value="" selected="" disabled="">Selecciona un estado</option>
              <option value="ejecutado">Ejecutado</option>
              <option value="pendiente">Pendiente</option>
              <option value="asignado">Asignado</option>
            </select>
            @error('estado')
            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
            @enderror
          </div> --}}
                    <div class="form-group col-sm-12 col-lg-6">
                        <label for="recipient-name" class="col-form-label">Selecciona los Archivos:</label>
                        <div class="custom-file">
                            <input type="file" wire:model="archivos" class="custom-file-input" id="customArchivos"
                                multiple>
                            <label class="custom-file-label" for="customArchivos">
                                @if (count($archivos) > 0) Archivos cargados
                                @endif
                            </label>
                        </div>
                        @error('archivos.*')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-6">
                        <label for="inputAddress">Codigo Catastral</label>
                        <input type="text" wire:model.defer="codigo_catastral"
                            class="form-control @error('codigo_catastral') is-invalid @enderror"
                            placeholder="Codigo Catastral">
                        @error('codigo_catastral')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div wire:ignore id="requerimiento" class="form-row">
                    <div class="form-group col-sm-12 col-md-12">
                        <label for="inputAddress">Observación</label>
                        <vue-ckeditor v-model="detalle_actividad" :config="config" />

                        @error('observacion_requerimiento')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-8">
                        <label>Requerimiento</label>
                        <model-list-select :list="tipos" v-model="requerimiento" class="form-control" option-value="id"
                            option-text="nombre" placeholder="Elije Un Requerimiento" @input="requerimientoEmit">
                        </model-list-select>
                        @error('requerimiento_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group col-sm-12 col-md-4">
                        <label>SECTOR</label>
                        <model-list-select :list="sectores" v-model="sector" class="form-control" option-value="id"
                            option-text="nombre" placeholder="Elije Un Sector" @input="sectorEmit">
                        </model-list-select>
                        @error('sector_id')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12 col-md-12">
                        <label>Ubicacion Georeferenciada</label>
                        <gmap-map :center="center" :zoom="12" style="width:100%;  height: 350px;" @click="clicked">
                            {{-- <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
              </gmap-info-window> --}}
                            <gmap-marker v-if="puntuacion.lat !== ''" :position="puntuacion" {{-- :clickable="true" --}}
                                icon="http://maps.google.com/mapfiles/kml/paddle/grn-circle.png" {{-- @click="toggleInfoWindow" --}}>
                            </gmap-marker>
                        </gmap-map>
                        @error('latitud')
                            <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" wire:loading.attr="disabled"
                        wire:target="updateRequerimiento,editRequerimiento, creaRequerimiento, updateRequerimiento"
                        class="btn btn-warning" wire:click="$emit('actualizarObservacion')">Actualizar
                        Requerimiento</button>
                @else
                    <button type="button" wire:loading.attr="disabled"
                        wire:target="editRequerimiento, updateRequerimiento, creaRequerimiento, updateRequerimiento"
                        class="btn btn-primary" wire:click="$emit('guardarObservacion')">Crear Requerimiento</button>
                @endif
            </div>
        </div>
    </div>
</div>
