<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Operaciones @yield('titulo')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ asset('landing/mg/favicon.png') }}" rel="icon">
  <link href="{{ asset('landing/mg/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Poppins:300,400,500,700" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="{{ asset('landing/css/landing.css') }}">
  {{-- <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> --}}
  <link href="{{ asset('landing/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/owl.carousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/venobox/venobox.css') }}" rel="stylesheet">
  <link href="{{ asset('landing/vendor/aos/aos.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('landing/css/style.css') }}" rel="stylesheet">
    @livewireStyles
    @yield('css')


  <!-- =======================================================
  * Template Name: Regna - v2.2.1
  * Template URL: https://bootstrapmade.com/regna-bootstrap-onepage-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

 

    @yield('content')


    <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="footer-top">
      <div class="container">

      </div>
    </div>

    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong>Operaciones</strong>. Todos los derechos reservado
      </div>
      <div class="credits">
        <!--
        All the links in the footer should remain intact.
        You can delete the links only if you purchased the pro version.
        Licensing information: https://bootstrapmade.com/license/
        Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=Regna
      -->
        Diseñado por<a href="https://bootstrapmade.com/">SmartFatsSolution</a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

  <!-- Vendor JS Files -->
  <script type="text/javascript" src="{{ asset('landing/js/landing.js') }}"></script>
  {{-- <script src="assets/vendor/jquery/jquery.min.js"></script> --}}
  {{-- <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
  <script src="{{ asset('landing/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{ asset('landing/vendor/counterup/counterup.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/superfish/superfish.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/hoverIntent/hoverIntent.js')}}"></script>
  <script src="{{ asset('landing/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/venobox/venobox.min.js')}}"></script>
  <script src="{{ asset('landing/vendor/aos/aos.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('landing/js/main.js') }}"></script>
  <script src="{{ asset('js/app.js') }}"></script>
      @livewireScripts
  
@yield('js')
</body>

</html>