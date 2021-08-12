<div>
    {{-- <h3 class="text-center">DATOS GENERALES</h3> --}}
    <div class="card">
        <div class="card-body">

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
                        class="form-control @error('cuenta_requerimiento') is-invalid @enderror" placeholder="Cuenta">
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

                <div class="form-group col-sm-12 col-lg-6">
                    <label for="recipient-name" class="col-form-label">Selecciona los Archivos:</label>
                    <div class="custom-file">
                        <input type="file" wire:model="archivos" class="custom-file-input" id="customArchivos" multiple>
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
                            icon="https://maps.google.com/mapfiles/kml/paddle/grn-circle.png" {{-- @click="toggleInfoWindow" --}}>
                        </gmap-marker>
                    </gmap-map>
                    @error('latitud')
                        <p class="error-message text-danger font-weight-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="row justify-content-center">
                <button type="button" wire:loading.attr="disabled"
                    wire:target="editRequerimiento, updateRequerimiento, creaRequerimiento, updateRequerimiento"
                    class="btn btn-primary" wire:click="$emit('guardarObservacion')">Crear Requerimiento</button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script src="https://cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script>
    <script type="text/javascript">
        let sectores = @json($sectores);
        let tipos = @json($tipos);
        const requerimiento = new Vue({
            el: "#requerimiento",

            data: {
                detalle_actividad: '',
                center: {
                    lat: -2.219662,
                    lng: -79.929179
                },
                puntuacion: {
                    lat: '',
                    lng: ''
                },

                tipos: tipos,
                requerimiento: '',
                sectores: sectores,
                config: {
                    toolbar: [
                        ['Bold', 'Italic', 'Underline', 'Strike', 'Styles', 'TextColor', 'BGColor', 'UIColor',
                            'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'BidiLtr',
                            'BidiRtl', 'NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote',
                            'CreateDiv', 'Format', 'Font', 'FontSize'
                        ]
                    ],
                },
                sector: '',

            },
            methods: {
                sectorEmit() {
                    @this.set('sector_id', this.sector);

                    // Livewire.emit('cargarSector', this.sector);
                },
                requerimientoEmit() {
                    @this.set('tipo_id', this.requerimiento);

                    // Livewire.emit('cargarRequerimiento', this.requerimiento);
                },
                clicked(e) {
                    this.center = {
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng()
                    };
                    this.puntuacion = {
                        lat: e.latLng.lat(),
                        lng: e.latLng.lng()
                    };
                    @this.set('latitud', e.latLng.lat());
                    @this.set('longitud', e.latLng.lng());

                    // Livewire.emit('cargarUbicacion', this.puntuacion);

                },
                limpiarCampos() {
                    this.center = {
                        lat: -2.219662,
                        lng: -79.929179
                    };
                    this.puntuacion = {
                        lat: '',
                        lng: ''
                    };
                    this.requerimiento = '';
                    this.detalle_actividad = '';
                    this.sector = '';
                },
                cargarDatos(datos) {
                    this.center = {
                        lat: datos.latitud,
                        lng: datos.longitud
                    };
                    this.puntuacion = {
                        lat: datos.latitud,
                        lng: datos.longitud
                    };
                    this.requerimiento = datos.tipo;
                    this.detalle_actividad = datos.observacion_requerimiento;
                    this.sector = datos.sector;
                }
            }

        });

        Livewire.on('guardarObservacion', function() {
            Livewire.emit('createRequerimiento', requerimiento.detalle_actividad);

        });

        Livewire.on('limpiarCampo', function() {
            requerimiento.limpiarCampos();
        });

        Livewire.on('editarRequerimiento', function(datos) {
            // console.log(datos.latitud)
            requerimiento.cargarDatos(datos);
        });

        Livewire.on('actualizarObservacion', function() {
            Livewire.emit('updaRequerimiento', requerimiento.detalle_actividad);

        });
    </script>
@endpush
