@extends('layouts.nav')

@section('css')
  <style type="text/css">
    
  </style>
@endsection
@section('content')
<div class="row ">
  <div class="col-xl-4 col-lg-6">
    <div class="card l-bg-red">
      <div class="card-statistic-3">
        <div class="card-icon card-icon-large"><i class="fa fa-users"></i></div>
        <div class="card-content">
          <h4 class="card-title">Usuarios Registrados</h4>
          <span class="font-weight-bold text-center" style="font-size: 40px">{{ $usuarios }}</span>
          <div class="progress mt-1 mb-1" data-height="10">
            <div class="progress-bar l-bg-purple" role="progressbar"  data-width="{{ ($activos * 100) / $usuarios }}%" aria-valuenow="{{ ($activos * 100) / $usuarios }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <p class="mb-0 text-sm">
            @if ($calculo2 = ($activos * 100) / $usuarios > 0)
            <span class="text-nowrap">Tienes el {{ number_format(($activos * 100) / $usuarios, 2) }}% de usuarios activos</span>
            @else
            <span class="text-nowrap">Todos los usuarios estan activos </span>
            @endif
            
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6">
    <div class="card l-bg-yellow">
      <div class="card-statistic-3">
        <div class="card-icon card-icon-large"><i class="fa fa-users"></i></div>
        <div class="card-content">
          <h4 class="card-title">Coordiandores</h4>
          <span class="font-weight-bold text-center" style="font-size: 40px">{{ $coordinadores }}</span>
          <div class="progress mt-1 mb-1" data-height="10">
            <div class="progress-bar l-bg-purple" role="progressbar"  data-width="{{ ($coordinadores * 100) / $usuarios }}%" aria-valuenow="{{ ($coordinadores * 100) / $usuarios }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <p class="mb-0 text-sm">
            @if ($calculo2 = ($coordinadores * 100) / $usuarios > 0)
            <span class="text-nowrap">Tienes el {{ number_format(($coordinadores * 100) / $usuarios, 2) }}% de usuarios coordinador</span>
            @else
            <span class="text-nowrap">Todos los usuarios son coordinadores </span>
            @endif
            
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6">
    <div class="card l-bg-cyan">
      <div class="card-statistic-3">
        <div class="card-icon card-icon-large"><i class="fa fa-users"></i></div>
        <div class="card-content">
          <h4 class="card-title">Operadores</h4>
          <span class="font-weight-bold text-center" style="font-size: 40px">{{ $operadores }}</span>
          <div class="progress mt-1 mb-1" data-height="10">
            <div class="progress-bar l-bg-purple" role="progressbar"  data-width="{{ ($operadores * 100) / $usuarios }}%" aria-valuenow="{{ ($operadores * 100) / $usuarios }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <p class="mb-0 text-sm">
            @if ($calculo2 = ($operadores * 100) / $usuarios > 0)
            <span class="text-nowrap">Tienes el {{ number_format(($operadores * 100) / $usuarios, 2) }}% de usuarios operadores</span>
            @else
            <span class="text-nowrap">Todos los usuarios son operadores </span>
            @endif
            
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6">
    <div class="card l-bg-green">
      <div class="card-statistic-3">
        <div class="card-icon card-icon-large"><i class="fa fa-store"></i></div>
        <div class="card-content">
          <h4 class="card-title">Requerimientos Atendidos</h4>
          <span class="font-weight-bold text-center" style="font-size: 40px">{{ $atendidos }}</span>
          <div class="progress mt-1 mb-1" data-height="8">
            <div class="progress-bar l-bg-purple" role="progressbar" data-width="{{ ($atendidos * 100) / $total }}%" aria-valuenow="{{ ($atendidos * 100) / $total }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <p class="mb-0 text-sm">
            @if ($calculo1 = ($atendidos * 100) / $total > 0)
            <span class="text-nowrap">Tienes el {{ number_format(($atendidos * 100) / $total, 2) }}% de requerimientos atendidos</span>
            @else
            <span class="text-nowrap">Todos los requerimientos han sido atendidos </span>
            @endif
            
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-6">
    <div class="card l-bg-orange">
      <div class="card-statistic-3">
        <div class="card-icon card-icon-large"><i class="fa fa-store"></i></div>
        <div class="card-content">
          <h4 class="card-title">Requerimientos Pendientes</h4>
          <span class="font-weight-bold text-center" style="font-size: 40px">{{ $pendiente }}</span>
          <div class="progress mt-1 mb-1" data-height="8">
            <div class="progress-bar l-bg-purple" role="progressbar" data-width="{{ ($pendiente * 100) / $total }}%" aria-valuenow="{{ ($pendiente * 100) / $total }}" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <p class="mb-0 text-sm">
            {{-- <span class="mr-2"><i class="fa fa-arrow-up"></i> 10%</span> --}}
            @if ($calculo = ($pendiente * 100) / $total > 0)
            <span class="text-nowrap">Tienes el {{ number_format(($pendiente * 100) / $total, 2) }}% de requerimientos pendientes</span>
            @else
            <span class="text-nowrap">No tienes requerimientos pendientes </span>
            @endif
            
          </p>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-12 col-12 col-sm-12" >
    <div class="card mt-sm-5 mt-md-0">
      <div class="card-header ">
        <h4 class="text-danger text-center font-weight-bold">Operadores con mas Requerientos atendidos</h4>
      </div>
      <div class="card-body">
      <ul class="list-group">
        @foreach ($operadoresmas as $o)
           <li class="list-group-item d-flex justify-content-between align-items-center">
    {{ $o->nombres }}
    <span class="badge badge-warning badge-pill">{{ $o->requerimientos_count }}</span>
  </li>
        @endforeach
      </ul>
      </div>
    </div>
  </div>
  <div class="col-lg-6 col-md-12 col-12 col-sm-12" id="graficos">
    <div class="card mt-sm-5 mt-md-0">
      <div class="card-header">
        <h4>Tipos de Requerimientos mas usados</h4>
      </div>
      <div class="card-body">
        <canvas id="donutChart"></canvas>
        <ul class="p-t-30 list-unstyled">
          <li v-for="(l,i) in label" class="padding-5">
            <span><i :class="backgroundColor[i]"></i></span>@{{ l }}<span class="float-right">@{{ datos[i] }}%</span>
          </li>
          {{--   <li class="padding-5"><span><i class="fa fa-circle m-r-5 col-black"></i></span>Search Engines<span class="float-right">30%</span></li>
          <li class="padding-5"><span><i class="fa fa-circle m-r-5 col-green"></i></span>Direct Click<span class="float-right">50%</span></li>
          <li class="padding-5"><span><i class="fa fa-circle m-r-5 col-orange"></i></span>Video Click<span class="float-right">20%</span></li> --}}
        </ul>
      </div>
    </div>
  </div>
</div>

@endsection

@section('js')
  <script src="{{ asset('bundles/chartjs/chart.min.js') }}"></script>

    <script type="text/javascript">
let tipos = @json($tipos);
let data = [];
let label = [];
let total = 0
tipos.forEach(function(tipo) {
    label.push(tipo.nombre);
    total += tipo.requerimientos_count;
});

tipos.forEach(function(tipo) {
    let calculo = (tipo.requerimientos_count * 100) /total;
    data.push(Number(calculo.toFixed(2)));
 });

console.log(tipos)
console.log(data)
console.log(label)
console.log(total)


const graficos = new Vue({
  el: "#graficos",
  data:{
    label:label,
    datos:data,
      backgroundColor: [
        'fa fa-circle m-r-5 col-black',
        'fa fa-circle m-r-5 col-green',
        'fa fa-circle m-r-5 col-orange',
        'fa fa-circle m-r-5 col-teal',
        'fa fa-circle m-r-5 col-cyan',
      ],
  },
  mounted(){
    this.cargarGraficos();
  },
  methods:{
    cargarGraficos(){
        var ctx = document.getElementById("donutChart").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    datasets: [{
      data: data,
      backgroundColor: [
        '#191d21',
        '#63ed7a',
        '#ffa426',
        '#EA1B42',
        '#0811C1',
      ],
      label: 'LISTA DE REQUERIMIENTOS'
    }],
    labels: label,
  },
  options: {
    responsive: true,
    legend: {
      position: 'bottom',
      display: false
    },
  }
});
    }
  }

})
    </script>
@endsection