<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'RMS') }}</title>
        <!-- Favicon -->
        <link href="{{ asset('argon') }}/img/brand/favicon.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('argon') }}/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="{{ asset('argon') }}/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
        <!-- Argon CSS -->
        <link type="text/css" href="{{ asset('argon') }}/css/argon.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/dataTables.bootstrap4.min.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/buttons.bootstrap4.min.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/select.bootstrap4.min.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/toastr.min.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/dropify.css?v=1.0.0" rel="stylesheet">
        <link type="text/css" href="{{ asset('argon') }}/css/select2.min.css?v=1.0.0" rel="stylesheet">
        <script src="{{ asset('argon') }}/vendor/jquery/dist/jquery.min.js"></script>
        <script src="{{ asset('argon') }}/js/dropify.js"></script>

        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>

       


        <style>
          .required-icon
          {
            color: red !important;
          }
          .action-btn{
            margin-left: 5px;
          }
          input.error {
          border: 1px solid red;
          font-weight: 300;
          color: red;
          }
          #toast-container > div {
            opacity: 3;
          }

          .select2-container--default.select2-container--focus .select2-selection--multiple {
              border: 0 !important;
              outline: 0;
          }

          .select2-container--default .select2-selection--multiple {
    background-color: white;
    border: 0;
    border-radius: 4px;
    cursor: text;
    transition: box-shadow .15s ease;
    border: 0;
    box-shadow: 0 1px 3px rgba(50, 50, 93, .15), 0 1px 0 rgba(0, 0, 0, .02);
    height: calc(2.75rem + 2px);
    padding: 8px .75rem;
    color: #8898aa;
    font-size: .875rem;
}

        </style>
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @if(auth()->user()->role_id == 1)
              @include('layouts.navbars.sidebar')
            @else
              @include('layouts.navbars.sidebaruser')
            @endif
        @endauth
        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest



        
        
        <script src="{{ asset('argon') }}/js/jquery.validate.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables JS -->
        <script src="{{ asset('argon') }}/vendor/dataTables/jquery.dataTables.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/dataTables/dataTables.bootstrap4.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/dataTables/dataTables.buttons.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/dataTables/buttons.bootstrap4.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/dataTables/buttons.html5.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/dataTables/buttons.flash.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/dataTables/buttons.print.min.js"></script>
        <script src="{{ asset('argon') }}/vendor/dataTables/dataTables.select.min.js"></script>
        <script src="{{ asset('argon') }}/js/select2.min.js"></script>
        <script src="{{ asset('argon') }}/js/toastr.min.js"></script>
        @stack('js')
    </body>
</html>
@if($message = Session::get('success'))
              <script>
              toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": false,
              "positionClass": "toast-top-right",
              "preventDuplicates": true,
              "onclick": null,
              "opacity": 5,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
              };  
              var message = "{{$message}}";
              toastr.success(message);
              </script>
        @endif
<script type="text/javascript">
$(document).ready(function() {
  $('#datatable-buttons').DataTable();
});

$('#datatable-buttons').dataTable( {
  "language": {
    "paginate": {
      "previous": "<",
      "next": ">"
    }
  }
});
</script>
<script>
    $('.dropify').dropify();
</script>
