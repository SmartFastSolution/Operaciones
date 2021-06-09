<template>
    <!-- <div class="container"> -->
        <div class="row justify-content-center">
            <div class="col-md-10">
                <FullCalendar ref="fullCalendar" :options="calendarOptions" />
            </div>
        </div>
    <!-- </div> -->
</template>

<script>
    import FullCalendar from '@fullcalendar/vue'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import interactionPlugin from '@fullcalendar/interaction';
    import listPlugin from '@fullcalendar/list';
   

    export default {
  components: {
    FullCalendar // make the <FullCalendar> tag available
  },
  props:['requerimientos'],
  data() {
    return {
      calendarOptions: {
        plugins: [ dayGridPlugin, interactionPlugin, listPlugin ],
        initialView: 'dayGridMonth',
        locale:'ES',
         headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,listWeek'
      },
      dateClick: this.handleDateClick,
      buttonText:{
                  today: 'HOY',
                  month: 'MESES',
                  week: 'SEMANAS',
                  day: 'DIAS',
                  list: 'LISTA'
              },
            eventClick:function(args){
              let id = args.event._def.publicId;
              // console.log(args.event._def.publicId)
            window.location = "/calendario/redirigir/"+id;
      
    },
        events:[],
        dayMaxEventRows: true, // for all non-TimeGrid views
  views: {
    timeGrid: {
      dayMaxEventRows: 6 // adjust to 6 only for timeGridWeek/timeGridDay
    }
  },
    weekends:true,
    // selectable:false,
            // editable:true,
       

      },
     
    }
  },
  mounted(){
     // horas.forEach(function(hora){           
     //    total += Number(hora.dia) * horaTrabajo * 1.50;  
     //  });
     let set = this;

    set.requerimientos.forEach(function (requerimiento, index) {

      if (requerimiento.estado === 'asignado') {
       set.requerimientos[index].backgroundColor = "#FE9701";

      } else if(requerimiento.estado === 'pendiente'){
      set.requerimientos[index].backgroundColor = "#EE1116";

      } else{
      set.requerimientos[index].backgroundColor = "#0D9310";

      }
    })
    this.calendarOptions.events = this.requerimientos;
  },
  methods:{
    redirigir(){
      console.log('hola')
    },
     handleDateClick: function(arg) {
       let calendarApi = this.$refs.fullCalendar.getApi();
     var date = calendarApi.getDate();
  alert("The current date of the calendar is " + date.toISOString());
    }
  }
}
</script>

<style lang="css">
@import "~@fullcalendar/daygrid/main.css";

.fc-event-title-container:hover, .fc-list-event:hover{
cursor: pointer;


}
.fc-event > td{
  color: #000;
}

</style>