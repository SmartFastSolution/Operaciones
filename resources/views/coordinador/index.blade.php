@extends('layouts.nav')
@section('content')
    <div class="row ">
        <div class="col-xl-6 col-lg-6">
            <div class="card l-bg-green">
                <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-store"></i></div>
                    <div class="card-content">
                        <h4 class="card-title">Requerimientos Atendidos</h4>
                        <span class="font-weight-bold text-center" style="font-size: 40px">{{ $atendidos }}</span>
                        @if ($atendidos > 0)
                            <div class="progress mt-1 mb-1" data-height="8">
                                <div class="progress-bar l-bg-purple" role="progressbar"
                                    data-width="{{ ($atendidos * 100) / $total }}%"
                                    aria-valuenow="{{ ($atendidos * 100) / $total }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0 text-sm">
                                @if ($calculo1 = ($atendidos * 100) / $total > 0)
                                    <span class="text-nowrap">Tienes el {{ ($atendidos * 100) / $total }}% de
                                        requerimientos atendidos</span>
                                @else
                                    <span class="text-nowrap">Todos los requerimientos han sido atendidos </span>
                                @endif

                            </p>

                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card l-bg-orange">
                <div class="card-statistic-3">
                    <div class="card-icon card-icon-large"><i class="fa fa-store"></i></div>
                    <div class="card-content">
                        <h4 class="card-title">Requerimientos Pendientes</h4>
                        <span class="font-weight-bold text-center" style="font-size: 40px">{{ $pendiente }}</span>
                        @if ($pendiente > 0)
                            <div class="progress mt-1 mb-1" data-height="8">
                                <div class="progress-bar l-bg-purple" role="progressbar"
                                    data-width="{{ ($pendiente * 100) / $total }}%"
                                    aria-valuenow="{{ ($pendiente * 100) / $total }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0 text-sm">
                                {{-- <span class="mr-2"><i class="fa fa-arrow-up"></i> 10%</span> --}}
                                @if ($calculo = ($pendiente * 100) / $total > 0)
                                    <span class="text-nowrap">Tienes el
                                        {{ number_format(($pendiente * 100) / $total, 2) }}%
                                        de
                                        requerimientos pendientes</span>
                                @else
                                    <span class="text-nowrap">No tienes requerimientos pendientes </span>
                                @endif

                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="p-2">
                    <h3 class="text-center font-weight-bold text-danger">Ultimos 5 Requerimientos</h3>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="">
                                <tr class="">
                                    <th class="px-4 py-2 ">Requerimiento</th>
                                    <th class="px-4 py-2 text-center">Codigo</th>
                                    <th class="px-4 py-2 text-center">Nombres</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($requerimientos as $requerimiento)
                                    <tr>
                                        {{-- <td class="text-left">{{ $requerimiento->codigo }}</td> --}}
                                        <td class="text-left"> <a
                                                href="{{ route('coordinador.requerimiento.show', $requerimiento->id) }}">Requerimiento
                                                {{ $requerimiento->id }}</a></td>
                                        <td class="text-center">{{ $requerimiento->codigo }}</td>
                                        <td class="text-left">{{ $requerimiento->nombres }}</td>
                                    </tr>
                                @endforeach


                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
