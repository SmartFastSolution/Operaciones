@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-calendar"></i> Calendario de Requerimientos</li>
@endsection
@section('content')
@section('titulo', '| Calendario')
@section('calendario', 'active')
<h2 class="text-center font-weight-bold text-danger">CALENDARIO DE REQUERIMIENTOS</h2>

<div id="calendario">
  <calendar-component :requerimientos="{{ $requerimientos }}"></calendar-component>
</div>
@endsection
@section('js')
<script type="text/javascript">
    "use strict";

 var toggle_sidebar_mini = function(mini) {
    let body = $("body");
      body.addClass("sidebar-mini");
      body.removeClass("sidebar-show");
      // sidebar_nicescroll.remove();
      // sidebar_nicescroll = null;
      $(".main-sidebar .sidebar-menu > li").each(function() {
        let me = $(this);

        if (me.find("> .dropdown-menu").length) {
          me.find("> .dropdown-menu").hide();
          me.find("> .dropdown-menu").prepend(
            '<li class="dropdown-title pt-3">' + me.find("> a").text() + "</li>"
          );
        } else {
          me.find("> a").attr("data-toggle", "tooltip");
          me.find("> a").attr("data-original-title", me.find("> a").text());
          $("[data-toggle='tooltip']").tooltip({
            placement: "right"
          });
        }
      });
    
  };
 toggle_sidebar_mini(true);

 const calendario = new Vue({
   el: "#calendario",
   data:{
  
   }
 
 })
</script>
@endsection