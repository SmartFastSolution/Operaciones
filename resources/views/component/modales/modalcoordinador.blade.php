<!-- Vertically Center -->
<div class="modal fade" id="modaldetalles" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modaldetallesLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content ">
      <div class="modal-header">
        <h2 class="text-dark text-center font-weight-bold" v-if="datosget">Datos del Coordinador</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="resetInput()">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <template v-if="datosget">
        <div>
          
          <h2 class="text-danger text-center font-weight-bold">INFORMACIÓN DEL COORDINADOR</h2>
          <div class="card" >
            <div class="padding-20">
              <ul  class="nav nav-tabs" id="myTab4" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="datos-tab2" data-toggle="tab" href="#datos" role="tab" aria-selected="true">Datos Personales</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="detalle-tab2" data-toggle="tab" href="#detalle" role="tab" aria-selected="true">Detalle Actividad</a>
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
                  <h3 class="text-center font-weight-bold text-danger">Datos Personales</h3>
                  <div class="form-row p-2">
                    <div class="form-group col-lg-6 col-sm-12">
                      <label for="">Nombres</label>
                      <input type="text" class="form-control" disabled :value="coordinador.nombres">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                      <label for="">Cedula</label>
                      <input type="number" class="form-control" disabled :value="coordinador.cedula">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                      <label for="">Correo</label>
                      <input type="text" class="form-control" disabled :value="coordinador.email">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                      <label for="">Telefono</label>
                      <input type="text" class="form-control" disabled :value="coordinador.telefono">
                    </div>
                      <div class="form-group col-lg-6 col-sm-12">
                      <label for="">Horario de Atención</label>
                      <input type="text" class="form-control" disabled :value="coordinador.horario_atencion">
                    </div>
                    <div class="form-group col-lg-6 col-sm-12">
                      <label for="">Dirección</label>
                      <input type="text" class="form-control" disabled :value="coordinador.domicilio">
                    </div>
                      <div class="form-group col-lg-12 col-sm-12">
                      <label for="">Actividad Personal</label>
                      <textarea name="" class="form-control" disabled="" id="" cols="5" rows="5">@{{ coordinador.actividad_personal }}</textarea>
                      {{-- <input type="text" class="form-control" disabled :value="coordinador.domicilio"> --}}
                    </div>
                    <div class="form-group col-lg-4 col-sm-12" v-if="coordinador.sector !== null">
                      <label for="">Sector</label>
                      <input type="text" class="form-control" disabled :value="coordinador.sector.nombre">
                    </div>
                    
                  </div>
                </div>
                <div class="tab-pane fade" id="detalle" role="tabpanel" aria-labelledby="detalle-tab2">
             <div class="p-2" v-html="coordinador.detalle_actividad"></div>
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
                      <tr v-for="(d,i) in coordinador.documentos">
                        <td>@{{ d.nombre }}</td>
                        <td>@{{ d.extension }}</td>
                        <td width="25"><a target="_blank" :href="d.archivo" class="btn btn-primary"><i class="fa fa-download"></i></a></td>
                        
                      </tr>
                      {{-- @endforeach --}}
                    </tbody>
                  </table>
                </div>
                <div class="tab-pane fade" id="imagenes" role="tabpanel" aria-labelledby="imagenes-tab2" style="height: 250px">
                  <h3 class="text-center font-weight-bold text-danger">Imagenes</h3>

                  <div class="row justify-content-center p-2" v-if="img.length > 0">
                    <img class="image" v-for="(image, i) in img" :src="image" @click="onClick(i)">
                    <vue-gallery-slideshow :images="img" :index="index" @close="index = null"></vue-gallery-slideshow>
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