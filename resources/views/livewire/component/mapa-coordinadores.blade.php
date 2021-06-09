<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 bg-light">
            <div class="form-row">
                <div class="form-group col-lg-4">
                    <label for="">Encuentre un Coordinador</label>
                    <input type="text" class="form-control" wire:model="search" placeholder="Buscar Coordinador">
                </div>
                <div class="form-group col-lg-4">
                    <label for="">Buscar Un Sector</label>
                    <input type="text" class="form-control" wire:model="sectorSearch" placeholder="Buscar Sector">
                </div>
                <div class="form-group col-lg-4">
                    <label for="formControlRange">Selecciona un rango de Coordinadores</label>
                    <input type="range" wire:model="rango" min="100" max="10000" step="100" class="form-control-range" id="formControlRange">
                   <small class="text-danger">{{ $rango }}</small> 
                </div>
            </div>
        </div>
        {{--       <div class="col-lg-4 mt-2">
            <div class="bg-warning p-1">
                <h6 class="text-center text-light">Requerimientos ({{ $conteo }})</h6>
            </div>
            <div>
                
            </div>
        </div> --}}
        <div class="col-lg-12 mt-2" id="mapa" wire:ignore>
            @include('component.modales.modalcoordinador')
            <gmap-map
                
                {{-- map-type-id="terrain" --}}
                :center="center"
                :zoom="13"
                style="width:100%;  height: 650px;"
                
                >
                
                {{--    <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
                </gmap-info-window> --}}
                <gmap-marker
                    :key="index"
                    v-for="(m, index) in markers"
                    :position="m.position"
                    {{-- @click="center=m.position" --}}
                    :icon="m.img"
                    :clickable="true"
                    @click="cargarRequerimiento(m.requerimiento_id,index)"
                ></gmap-marker>
            </gmap-map>
        </div>
    </div>
</div>