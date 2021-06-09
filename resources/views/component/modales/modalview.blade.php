<!-- Vertically Center -->
<div class="modal fade" id="modaldetalles" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaldetallesLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h2 class="text-dark text-center font-weight-bold" v-if="datosget">Requerimiento #@{{ requerimiento.id }} </h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="resetInput()">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <template v-if="datosget">
        <div>
          <ul class="nav nav-pills" id="myTab3" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="requerimiento-tab3" data-toggle="tab" href="#requerimiento3" role="tab" aria-controls="requerimiento" aria-selected="true">Requerimiento</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="atencion-tab3" v-if="requerimiento.atencion !== null" data-toggle="tab" href="#atencion3" role="tab" aria-controls="atencion" aria-selected="false">Atención</a>
            </li>
            {{--    <li class="nav-item">
              <a class="nav-link" id="contact-tab3" data-toggle="tab" href="#contact3" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
            </li> --}}
          </ul>
          <div class="tab-content" id="myTabContent2">
            <div class="tab-pane fade show active" id="requerimiento3" role="tabpanel" aria-labelledby="requerimiento-tab3">
              <h2 class="text-danger text-center font-weight-bold">INFORMACIÓN DEL REQUERIMIENTO</h2>
              <div class="card" >
                <div class="padding-20">
                  <ul  class="nav nav-tabs" id="myTab4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="datos-tab2" data-toggle="tab" href="#datos" role="tab" aria-selected="true">Datos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="observacion-tab2" data-toggle="tab" href="#observacion" role="tab" aria-selected="true">Observación</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="archivos-tab2" data-toggle="tab" href="#archivos" role="tab" aria-selected="false"> Archivos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="imagenes-tab2" data-toggle="tab" href="#imagenes" role="tab" aria-selected="false"> Imagenes</a>
                    </li>
                  </ul>
                  <div class="tab-content tab-bordered" id="myTab3Content">
                    <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab2">
                      <h3 class="text-center font-weight-bold text-danger">Datos</h3>
                      <div class="form-row">
                        <div class="form-group col-lg-4 col-sm-12">
                          <label for="">Codigo</label>
                          <input type="text" class="form-control" disabled :value="requerimiento.codigo">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12">
                          <label for="">Cuenta</label>
                          <input type="text" class="form-control" disabled :value="requerimiento.cuenta">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12">
                          <label for="">Codigo Catastral</label>
                          <input type="text" class="form-control" disabled :value="requerimiento.codigo_catastral">
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                          <label for="">Nombres</label>
                          <input type="text" class="form-control" disabled :value="requerimiento.nombres">
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                          <label for="">Cedula</label>
                          <input type="number" class="form-control" disabled :value="requerimiento.cedula">
                        </div>
                        <div class="form-group col-lg-12 col-sm-12">
                          <label for="">Correos</label>
                          <input type="text" class="form-control" disabled :value="requerimiento.correos">
                        </div>
                        <div class="form-group col-lg-12 col-sm-12">
                          <label for="">Telefonos</label>
                          <input type="text" class="form-control" disabled :value="requerimiento.telefonos">
                        </div>
                        <div class="form-group col-lg-12 col-sm-12" v-if="requerimiento.coordinador !== null">
                          <label for="">Coordinador</label>
                          <input type="text" class="form-control" disabled :value="requerimiento.coordinador.nombres">
                        </div>
                        <div class="form-group col-lg-12 col-sm-12">
                          <label for="">Dirección</label>
                          <input type="text" class="form-control" disabled :value="requerimiento.direccion">
                        </div>
                        <div class="form-group col-lg-12 col-sm-12">
                          <label for="">Detalles</label>
                          <textarea name="" class="form-control" id="" cols="30" rows="10" disabled="">@{{ requerimiento.detalle }}</textarea>
                          {{-- <input type="text" class="form-control" disabled :value="requerimiento.direccion"> --}}
                        </div>
                        <div class="form-group col-lg-4 col-sm-12" v-if="requerimiento.sector !== null" >
                          <label for="">Sector</label>
                          <input type="text" class="form-control" disabled :value="requerimiento.sector.nombre">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12" v-if="requerimiento.tipo !== null">
                          <label for="">Tipo de Requerimiento</label>
                          <input type="text" class="form-control" disabled   :value="requerimiento.tipo.nombre">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12">
                          <label for="">Estado</label>
                          <input type="text" class="form-control text-capitalize" disabled :value="requerimiento.estado">
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade " id="observacion" role="tabpanel" aria-labelledby="observacion-tab2">
                      <h3 class="text-center font-weight-bold text-danger">Observaciones</h3>
                      <div v-html="requerimiento.observacion"></div>
                      {{-- {!! $requerimiento->observacion !!} --}}
                    </div>
                    <div class="tab-pane fade" id="archivos" role="tabpanel" aria-labelledby="archivos-tab2">
                      <h3 class="text-center font-weight-bold text-danger">Archivos</h3>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Extensión</th>
                            <th >Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          {{-- @foreach ($requerimiento->documentos as $documento) --}}
                          <tr v-for="(d,i) in requerimiento.documentos">
                            <td>@{{ d.nombre }}</td>
                            <td>@{{ d.extension }}</td>
                            <td width="25"><a target="_blank" :href="d.archivo" class="btn btn-primary"><i class="fa fa-download"></i></a></td>
                            
                          </tr>
                          {{-- @endforeach --}}
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="imagenes" role="tabpanel" aria-labelledby="imagenes-tab2" >
                      <div class="row justify-content-center" v-if="img_requerimient.length > 0">
                        <img class="image" v-for="(image, i) in img_requerimient" :src="image" @click="onClick(i)">
                        <vue-gallery-slideshow :images="img_requerimient" :index="index" @close="index = null"></vue-gallery-slideshow>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane fade" id="atencion3" role="tabpanel" aria-labelledby="atencion-tab3" v-if="requerimiento.atencion !== null" >
              <div class="card">
                <div class="padding-20">
                  <h2 class="text-danger text-center font-weight-bold">ATENCIÓN DE REQUERIMIENTO</h2>
                  <ul  class="nav nav-tabs" id="myTab4" role="tablist">
                    <li class="nav-item">
                      <a wire:ignore class="nav-link active" id="atencion-datos-tab2" data-toggle="tab" href="#atencion-datos" role="tab" aria-selected="true">Datos</a>
                    </li>
                    {{--  <li class="nav-item">
                      <a wire:ignore class="nav-link" id="atencion-observacion-tab2" data-toggle="tab" href="#atencion-observacion" role="tab" aria-selected="true">Observacion</a>
                    </li> --}}
                    <li class="nav-item">
                      <a wire:ignore class="nav-link" id="atencion-geolocalizacion-tab2" data-toggle="tab" href="#atencion-geolocalizacion" role="tab" aria-selected="true">Geolocalización</a>
                    </li>
                    <li class="nav-item">
                      <a wire:ignore class="nav-link" id="atencion-archivos-tab2" data-toggle="tab" href="#atencion-archivos" role="tab" aria-selected="false"> Archivos</a>
                    </li>
                    <li class="nav-item">
                      <a wire:ignore class="nav-link" id="atencion-imagenes-tab2" data-toggle="tab" href="#atencion-imagenes" role="tab" aria-selected="false"> Imagenes</a>
                    </li>
                  </ul>
                  <div class="tab-content tab-bordered" id="myTab3Content">
                    <div class="tab-pane fade show active" id="atencion-datos" role="tabpanel" aria-labelledby="atencion-datos-tab2" wire:ignore.self>
                      <h3 class="text-center font-weight-bold text-danger">Datos</h3>
                      <div class="form-row">
                        <div class="form-group col-lg-12 col-sm-12">
                          <label for="">Detalles de atención</label>
                          <textarea class="form-control" disabled="">@{{ requerimiento.atencion.detalle }}
                          </textarea>
                        </div>
                        <div class="form-group col-lg-12 col-sm-12">
                          <label for="">Observación de Atencion</label>
                          <div v-html="requerimiento.atencion.observacion">
                          </div>
                        </div>
                        <div class="form-group col-lg-6 col-sm-12">
                          <label for="">Fecha de Atención</label>
                          <input type="date" class="form-control" disabled :value="requerimiento.atencion.fecha_atencion ">
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade " id="atencion-observacion" role="tabpanel" aria-labelledby="atencion-observacion-tab2" wire:ignore.self>
                      <h3 class="text-center font-weight-bold text-danger">Observaciones</h3>
                      {{-- {!! $requerimiento->observacion !!} --}}
                    </div>
                    <div class="tab-pane fade " id="atencion-geolocalizacion" role="tabpanel" aria-labelledby="atencion-geolocalizacion-tab2" wire:ignore.self>
                      <h3 class="text-center font-weight-bold text-danger">Distancia: <strong>@{{formatdistancia(requerimiento.atencion.distancia)  }} </strong>
                      {{--    {{ number_format($distancia * 1000, 2)  }} Mts
                      @else {{ number_format($distancia, 2)  }} KM
                      @endif</strong></h3> --}}
                      {{-- <div id="atencion"> --}}
                        <gmap-map
                          :center="{ lat: requerimiento.atencion.latitud, lng: requerimiento.atencion.longitud }"
                          :zoom="12"
                          style="width:100%;  height: 350px;"
                          >
                          <gmap-marker
                            :position="{ lat: requerimiento.atencion.latitud, lng: requerimiento.atencion.longitud }"
                            icon="http://maps.google.com/mapfiles/kml/paddle/grn-circle.png"
                          ></gmap-marker>
                          <gmap-marker
                            :position="{ lat: requerimiento.latitud, lng: requerimiento.longitud }"
                            icon="http://maps.google.com/mapfiles/kml/paddle/red-circle.png"
                          ></gmap-marker>
                        </gmap-map>
                      {{-- </div> --}}
                    </div>
                    <div class="tab-pane fade" id="atencion-archivos" role="tabpanel" aria-labelledby="atencion-archivos-tab2" wire:ignore.self>
                      <h3 class="text-center font-weight-bold text-danger">Archivos</h3>
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Extensión</th>
                            <th colspan="2">Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(a, ind) in requerimiento.atencion.documentos">
                            <td>@{{ a.nombre }}</td>
                            <td>@{{ a.extension }}</td>
                            <td width="25"><a target="_blank" :href="a.archivo" class="btn btn-primary"><i class="fa fa-download"></i></a></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <div class="tab-pane fade" id="atencion-imagenes" role="tabpanel" aria-labelledby="atencion-imagenes-tab2" >
                      <div class="row justify-content-center" v-if="img_atencion.length > 0">
                        <img class="image" v-for="(image, i) in img_atencion" :src="image" @click="onClick2(i)">
                        <vue-gallery-slideshow :images="img_atencion" :index="index2" @close="index2 = null"></vue-gallery-slideshow>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </template>
      </div>
      <div class="modal-footer br">
      </div>
    </div>
  </div>
</div>