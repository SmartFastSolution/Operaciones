@extends('layouts.nav')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('coordinador.requerimiento.index') }}"><i
                class="fas fa-clipboard-list"></i> Requerimientos</a></li>
    <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-store"></i> Nuevo Requerimiento</li>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
@endsection
@section('requerimiento', 'active')
@section('productos', 'active')
@section('content')
@section('titulo', '| Requerimientos')

<h1 class="text-danger text-center">Crear Requerimiento</h1>
<div id="requerimiento">
<div class="card" id="requerimiento">
<div class="card-body">

    <div class="form-row">
        <div class="form-group col-sm-12 col-md-2">
            <label for="inputAddress">Codigo</label>
            <input type="text" v-model="codigo_requerimiento" class="form-control "
                placeholder="Codigo Requerimiento">
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('codigo_requerimiento')">
                @{{ errors . get('codigo_requerimiento') }}</p>

        </div>
        <div class="form-group col-sm-12 col-md-2">
            <label for="inputAddress">Cuenta</label>
            <input type="text" v-model="cuenta_requerimiento" class="form-control" placeholder="Cuenta">
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('cuenta_requerimiento')">
                @{{ errors . get('cuenta_requerimiento') }}</p>

        </div>
        <div class="form-group col-sm-12 col-md-5">
            <label for="inputAddress">Nombre</label>
            <input type="text" v-model="nombre_requerimiento" class="form-control"
                placeholder="Nombres del contacto">
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('nombre_requerimiento')">
                @{{ errors . get('nombre_requerimiento') }}</p>

        </div>
        <div class="form-group col-sm-12 col-md-3">
            <label for="inputAddress">Cedula</label>
            <input type="text" v-model="cedula_requerimiento" class="form-control"
                placeholder="Cedula del contacto">
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('cedula_requerimiento')">
                @{{ errors . get('cedula_requerimiento') }}</p>

        </div>
        <div class="form-group col-sm-12 col-md-6">
            <label for="inputAddress">Telefonos</label>
            <input type="text" v-model="telefonos_requerimiento" class="form-control "
                placeholder="Telefonos del contacto">
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('telefonos_requerimiento')">
                @{{ errors . get('telefonos_requerimiento') }}</p>

        </div>
        <div class="form-group col-sm-12 col-md-6">
            <label for="inputAddress">Correos</label>
            <input type="text" v-model="correos_requerimiento" class="form-control "
                placeholder="Correos del Contacto">

            <p class="error-message text-danger font-weight-bold" v-if="errors.has('correos_requerimiento')">
                @{{ errors . get('correos_requerimiento') }}</p>
        </div>

        <div class="form-group col-sm-12 col-md-8">
            <label for="inputAddress">Dirección</label>
            <input type="text" v-model="direccion_requerimiento" class="form-control" placeholder="Direccion">
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('direccion_requerimiento')">
                @{{ errors . get('direccion_requerimiento') }}</p>

        </div>
        <div class="form-group col-sm-12 col-md-4">
            <label for="inputAddress">Fecha Maxima</label>
            <input type="date" v-model="fecha_requerimiento" class="form-control"
                placeholder="Correos del Contacto">
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('fecha_requerimiento')">
                @{{ errors . get('fecha_requerimiento') }}</p>

        </div>
        <div class="form-group col-sm-12 col-md-12">
            <label for="inputEmail4">Detalle</label>
            <textarea name="" id="" cols="30" rows="10" v-model="detalle_requerimiento"
                placeholder="Agregar detalle del requerimiento" class="form-control"></textarea>
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('detalle_requerimiento')">
                @{{ errors . get('detalle_requerimiento') }}</p>

        </div>
        <div class="form-group col-sm-12 col-md-4">
            <label for="inputAddress">Codigo Catastral</label>
            <input type="text" v-model="codigo_catastral" class="form-control" placeholder="Codigo Catastral">
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('codigo_catastral')">
                @{{ errors . get('codigo_catastral') }}</p>

        </div>
        <div class="form-group col-sm-12 col-md-4">
            <label>Requerimiento</label>
            <model-list-select :list="tipos" v-model="requerimiento" class="form-control" option-value="id"
                option-text="nombre" placeholder="Elije Un Requerimiento">
            </model-list-select>
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('tipo_requerimiento_id')">
                @{{ errors . get('tipo_requerimiento_id') }}</p>

        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label>SECTOR</label>
            <model-list-select :list="sectores" v-model="sector" class="form-control" option-value="id"
                option-text="nombre" placeholder="Elije Un Sector">
            </model-list-select>
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('sector_id')">
                @{{ errors . get('sector_id') }}</p>

        </div>

        {{-- <div class="form-group col-sm-12 col-lg-6">
                <label for="recipient-name" class="col-form-label">Selecciona los Archivos:</label>
                <div class="custom-file">
                    <input type="file" wire:model="archivos" class="custom-file-input" id="customArchivos"
                        multiple>
                    <label class="custom-file-label" for="customArchivos">
                    </label>
                </div>


            </div> --}}

    </div>
    <div class="form-row">
        <div class="form-group col-sm-12 col-md-12">
            <label for="inputAddress">Observación</label>
            <p class="error-message text-danger font-weight-bold"
                v-if="errors.has('observacion_requerimiento')">
                @{{ errors . get('observacion_requerimiento') }}</p>
            <vue-ckeditor v-model="observacion_requerimiento" :config="config" />
        </div>
        <div class="form-group col-sm-12 col-md-12">
            <label>Ubicacion Georeferenciada</label>
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('latitud')">
                @{{ errors . get('latitud') }}</p>
            <p class="error-message text-danger font-weight-bold" v-if="errors.has('longitud')">
                @{{ errors . get('longitud') }}</p>
            <gmap-map :center="center" :zoom="12" style="width:100%;  height: 350px;" @click="clicked">
                <gmap-marker v-if="puntuacion.lat !== ''" :position="puntuacion"
                    icon="https://maps.google.com/mapfiles/kml/paddle/grn-circle.png">
                </gmap-marker>
            </gmap-map>
        </div>
    </div>

</div>
</div>
<div class="col">
<div class="card">
    <div class="p-2">
        <div class="card-head">
            <h2 class="text-center text-danger font-weight-bold">CARGA DE ARCHIVOS</h2>
        </div>
        <div v-if="errors.anyfiles('archivos')">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Tienes Los Siguientes Errores!</h4>
                <div v-for="(archivo, key) in errors.archivos('archivos')" :key="key">
                    <div v-for="(mensaje, k) in archivo">
                        <p>@{{ mensaje }}</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-body">
            <div class="multiple-uploader">
                <div v-show="$refs.uploader && $refs.uploader.dropActive" class="drop-active">
                    <h3>Deja caer aquí los archivos</h3>
                </div>
                <table class="table table-condensed" v-if="archivos.length">
                    <tr>
                        <th>Nombre</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                    <tr v-for="file in archivos" :key="file.id">
                        <td>@{{ file . name }}</td>
                        <td class="text-right">
                            <button class="btn btn-danger btn-sm" @click.exact="$refs.uploader.remove(file)">
                                <i class="fas fa-trash"></i> Eliminar</button>
                        </td>
                    </tr>
                </table>
                <div class="alert alert-info text-center" v-else>
                    Todavía no has subido ningún archivo
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="text-center justify-content-center align-content-center card-title">
                            <div class="col-12 p-4">
                                <button type="button" class="btn brand-color btn-lg">
                                    <label class="btn" for="uploader"
                                        style="background: #2ab27b; color: white !important; cursor: pointer;">
                                        <i class="fas fa-upload"></i> Seleccionar documentos
                                    </label>
                                </button>
                            </div>
                        </div>
                        <hr />
                        {{-- <button @click="upload" class="btn btn-success">Subir archivos</button> --}}
                    </div>
                </div>
                <div class="upload">
                    <div class="btn-group">
                        <file-upload class="btn btn-primary dropdown-toggle" style="display: none"
                            input-id="uploader" :extensions="extensions" :accept="mime_types"
                            :multiple="multiple" :directory="directory" {{-- :drop="true" --}}
                            :drop-directory="dropDirectory" v-model="archivos" {{-- @input-filter="inputFilter" --}}
                            ref="uploader" :size="1024">
                        </file-upload>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row justify-content-center">
<button type="button" :disabled="buttonDisable" class="btn btn-primary"
    @click.prevent="submitRequerimiento">Crear
    Requerimiento</button>
</div>
</div>

@endsection

@section('js')

<script src="https://cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script>
<script type="text/javascript">
    class Errors {
        constructor() {
            this.errors = {}
        }
        has(field) {
            return this.errors.hasOwnProperty(field);
        }
        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0]
            }
        }
        record(errors) {
            this.errors = errors;
        }
        any() {
            return Object.keys(this.errors).length > 0;
        }
        anyfiles(query) {
            const asArray = Object.entries(this.errors);
            //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
            const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                1);
            const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);

            return Object.keys(atLeast9WinsObject).length > 0;
        }
        archivos(query) {
            const asArray = Object.entries(this.errors);
            //const atLeast9Wins = asArray.filter(([key, value]) => key !== 'fecha_atencion' && key !== 'responsable_id' && key !== 'detalle_atencion' && key !== 'observacion' );
            const atLeast9Wins = asArray.filter(([key, value]) => key.toLowerCase().indexOf(query.toLowerCase()) > -
                1);
            const atLeast9WinsObject = Object.fromEntries(atLeast9Wins);
            return atLeast9WinsObject;
        }

    }
    let sectores = @json($sectores);
    let tipos = @json($tipos);
    const requerimiento = new Vue({
        el: "#requerimiento",
        name: "Requerimiento",
        data: {
            observacion_requerimiento: '',
            cuenta_requerimiento: '',
            nombre_requerimiento: '',
            cedula_requerimiento: '',
            codigo_requerimiento: '',
            telefonos_requerimiento: '',
            correos_requerimiento: '',
            direccion_requerimiento: '',
            fecha_requerimiento: '',
            detalle_requerimiento: '',
            codigo_catastral: '',
            center: {
                lat: -2.219662,
                lng: -79.929179
            },
            puntuacion: {
                lat: '',
                lng: ''
            },
            archivos: [],
            errors: new Errors,
            multiple: true,
            directory: false,
            drop: true,
            dropDirectory: true,
            buttonDisable: false,

            name: "file",
            mime_types: "application/vnd.ms-excel,application/msword,application/pdf,image/png,image/gif,image/jpeg,image/webp",
            extensions: "xls,doc,docx,pdf,jpg,jpeg,png",


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
            onFiles(e) {
                // let archivos = [];
                let set = this;

                for (var i = 0; i < e.target.files.length; i++) {
                    set.archivos[i] = e.target.files[i];

                }
                // console.log(archivos);

                // archiv
                // archivos.forEach(function(index){
                //  });
            },
            inputFilter(newFile, oldFile, prevent) {
                if (newFile && !oldFile) {
                    if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
                        return prevent();
                    }
                    if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
                        return prevent();
                    }
                    if (/\.(gif|jpg|jpeg|tiff|png)$/i.test(newFile.name)) {
                        return prevent();
                    }
                }
                if (newFile && (!oldFile || newFile.file !== oldFile.file)) {
                    newFile.blob = "";
                    let URL = window.URL || window.webkitURL;
                    if (URL && URL.createObjectURL) {
                        newFile.blob = URL.createObjectURL(newFile.file);
                    }
                }
            },
            submitRequerimiento() {
                this.buttonDisable = true;
                let set = this;
                const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                }
                // let url = if (true) {}
                let data = new FormData();
                data.append('numero', this.archivos.length);
                data.append('codigo_requerimiento', set.codigo_requerimiento);
                data.append('cuenta_requerimiento', set.cuenta_requerimiento);
                data.append('nombre_requerimiento', set.nombre_requerimiento);
                data.append('cedula_requerimiento', set.cedula_requerimiento);
                data.append('telefonos_requerimiento', set.telefonos_requerimiento);
                data.append('correos_requerimiento', set.correos_requerimiento);
                data.append('direccion_requerimiento', set.direccion_requerimiento);
                data.append('fecha_requerimiento', set.fecha_requerimiento);
                data.append('detalle_requerimiento', set.detalle_requerimiento);
                data.append('codigo_catastral', set.codigo_catastral);
                data.append('tipo_requerimiento_id', set.requerimiento);
                data.append('sector_id', set.sector);
                data.append('observacion_requerimiento', set.observacion_requerimiento);
                data.append('latitud', set.puntuacion.lat);
                data.append('longitud', set.puntuacion.lng);
                for (var i = 0; i < this.archivos.length; i++) {
                    data.append('archivos[]', this.archivos[i].file);
                }
                axios.post('/coordinador/requerimiento/store', data, config)
                    .then(function(res) {
                        // console.log(res.data)
                        this.buttonDisable = true;
                        let link = res.data.link;
                        window.location = link;
                    })
                    .catch(function(error) {
                        if (error.response.status == 422) {
                            set.errors.record(error.response.data.errors);
                        }
                        set.buttonDisable = false;
                    });
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
                this.observacion_requerimiento = '';
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
                this.observacion_requerimiento = datos.observacion_requerimiento;
                this.sector = datos.sector;
            }
        }

    });
</script>
@endsection
