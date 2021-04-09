@extends('layouts.app')
@section('content')
<!-- Vertically Center -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    
                    <div id="mapa">
                        <div class="modal fade" id="createmateria" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="createcursoLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg " role="document">
                                <div class="modal-content bg-info">
                                    <div class="modal-header">
                                        <h2 class="modal-title text-light" id="exampleModalCenterTitle">Crear Curso</h2>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <modal-informacion></modal-informacion>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div>
                            <h2>Search and add a pin</h2>
                            <label>
                                <gmap-autocomplete
                                    @place_changed="setPlace">
                                </gmap-autocomplete>
                                <button @click="addMarker">Add</button>
                            </label>
                            <br/>
                        </div>
                        <gmap-map
                            :center="center"
                            :zoom="12"
                            style="width:100%;  height: 400px;"
                            @click="clicked"
                            >
                            <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
                            </gmap-info-window>
                            <gmap-marker
                                :position="position"
                                :clickable="true"
                                :draggable="true"
                                icon="http://maps.google.com/mapfiles/kml/paddle/grn-circle.png"
                                @click="toggleInfoWindow"
                            ></gmap-marker>
                        </gmap-map>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
const mapa = new Vue({
el: "#mapa",
data:{
center: { lat: -2.219662, lng: -79.929179 },
markers: [],
places: [],
currentPlace: null,
position: null,
infoWindowPos: null,
infoWinOpen: false,
currentMidx: null,
infoOptions: {
content: '',
//optional: offset infowindow so it visually sits nicely on top of our marker
pixelOffset: {
width: 0,
height: -35
}
},
},
mounted() {
this.geolocate();
},
methods: {
// receives a place object via the autocomplete component
setPlace(place) {
this.currentPlace = place;
},
clicked(e){
this.center = {
lat: e.latLng.lat(),
lng: e.latLng.lng()
};
this.position =  this.center;
console.log(e.latLng.lat())
},
toggleInfoWindow: function() {
this.infoWindowPos = this.position;
this.infoOptions.content = '<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createmateria" ><i class="fa fa-user-plus"></i> Crear Materia </button>';
//check if its the same marker that was selected if yes toggle

this.infoWinOpen = true;
this.currentMidx = idx;

},
addMarker() {
if (this.currentPlace) {
const marker = {
lat: this.currentPlace.geometry.location.lat(),
lng: this.currentPlace.geometry.location.lng()
};
this.markers.push({ position: marker });
this.places.push(this.currentPlace);
this.center = marker;
this.currentPlace = null;
}
},
geolocate: function() {
navigator.geolocation.getCurrentPosition(position => {
this.center = {
lat: position.coords.latitude,
lng: position.coords.longitude
};
this.markers.push({ position: this.center });
});
}
}
})
</script>
@endsection