{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Confirm Password') }}</div>

                <div class="card-body">
                    {{ __('Please confirm your password before continuing.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Confirm Password') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Inicio de Sesion</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">
 
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel='shortcut icon' type='image/x-icon' href='img/favicon.ico'>
  </head>
  <body>
    <div class="loader"></div>
    <div id="app">
      <section class="section">
        <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
          <div class="card card0 border-0">
            <div class="row d-flex">
              <div class="col-lg-6">
                <div class="card1 pb-5">
                  <div class="row"> <img src="https://i.imgur.com/CXQmsmF.png" class="logo"> 
                  </div>
                  <div class="row px-3 justify-content-center mt-4 mb-5 border-line"> <img src="https://i.imgur.com/uNGdWHi.png" class="image"> 
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card2 card border-0 px-4 py-5">
                  <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <h5 class="font-weight-boldtext-center mt-5 text-danger">CAMBIAR CONTRASEÑA</h5>
                    <div class="row px-3"> 
                      <label class="mb-1">
                      <h6 class="mb-0 text-sm">Correo</h6>
                    </label> 
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                <div class="row px-3 mb-4">
                @if (Route::has('password.request'))
                <a href="{{ route('login') }}" class="ml-auto mb-0 text-sm">Inicia Sesion</a>
                @endif
              </div>
              <div class="row mb-3 px-3">
                <button type="submit" class="btn btn-blue text-center">ACTUALIZAR CONTRASEÑA</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="bg-blue py-4">
        <div class="row px-3"> <small class="ml-4 ml-sm-5 mb-2">Copyright &copy; 2021. Todos los derechos reservados.</small>
          <div class="social-contact ml-4 ml-sm-auto"> <span class="fa fa-facebook mr-4 text-sm"></span> <span class="fa fa-google-plus mr-4 text-sm"></span> <span class="fa fa-linkedin mr-4 text-sm"></span> <span class="fa fa-twitter mr-4 mr-sm-5 text-sm"></span> </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<!-- General JS Scripts -->
<script src="{{ asset('js/app.min.js') }}"></script>

</body>
</html>