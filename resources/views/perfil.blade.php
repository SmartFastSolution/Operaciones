@extends('layouts.nav')
@section('css')
<style type="text/css">
	.image {
  width: 100px;
  height: 100px;
  background-size: contain;
  cursor: pointer;
  margin: 10px;
  border-radius: 3px;
}
</style>
@endsection
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user"></i> {{ $user->nombres }}</li>
@endsection
@section('content')
@section('user', 'active')
@section('titulo', '| '.$user->nombres)
@livewire('coordinador.perfil.perfil-detalles')
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script>
<script type="text/javascript">
	let user = @json(Auth::user());
	let sectores = @json($sectores);
</script>
<script type="text/javascript" src="{{ asset('js/perfil.js') }}"></script>
@endsection