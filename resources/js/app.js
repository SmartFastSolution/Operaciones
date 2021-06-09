require('./bootstrap');

window.Vue = require('vue');

import * as VueGoogleMaps from 'vue2-google-maps';
 
Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyAjTI2PvulL273cY6kgGjLZK-W1s3KekCU', //API MIA
    // key: 'AIzaSyCSVcwB2sijhfbQlrGX14SxUU9BoyZVPJo', //INGENIERO
    libraries: 'places', // This is required if you use the Autocomplete plugin
    // OR: libraries: 'places,drawing'
    // OR: libraries: 'places,drawing,visualization'
    // (as you require)
 
    //// If you want to set the version, you can do so:
    // v: '3.26',
  },
  installComponents: true
});
const VueUploadComponent = require('vue-upload-component')
Vue.component('file-upload', VueUploadComponent);

import 'vue-search-select/dist/VueSearchSelect.css';
import { ModelListSelect  } from 'vue-search-select';
Vue.component('ModelListSelect', ModelListSelect );

import VueCkeditor from 'vue-ckeditor2';
Vue.component('vue-ckeditor', VueCkeditor );

import VueGallerySlideshow from 'vue-gallery-slideshow';
Vue.component('vue-gallery-slideshow', VueGallerySlideshow );

// import FullCalendar from '@fullcalendar/vue'
// import dayGridPlugin from '@fullcalendar/daygrid'
// import interactionPlugin from '@fullcalendar/interaction'

// // require('@fullcalendar/core/main.min.css')
// require('@fullcalendar/daygrid/main.min.css')
// // require('@fullcalendar/timegrid/main.min.css')

// Vue.component('FullCalendar', FullCalendar );

// Vue.use(dayGridPlugin);

Vue.component('calendar-component', require('./components/CalendarComponent.vue').default);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('modal-informacion', require('./components/ModalInformacion.vue').default);


// const app = new Vue({
//     el: '#app',
// });
