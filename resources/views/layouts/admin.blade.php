<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->

    <style>


@import url('https://fonts.googleapis.com/css2?family=Public+Sans:wght@300&display=swap');
        *{
            font-family: 'Public Sans', sans-serif;
        }
        ::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #490102cf; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #490102; 
}


.admin-input .v-input__append-inner{
            margin-top: auto !important;
            margin-bottom: auto !important;
        }
        .admin-input fieldset {
            border: 2px solid !important;
            color: #494949 !important;
}

.admin-btn-new-feed{
    position: absolute !important;
    top: 14px;
    right: 14px !important;
}
.admin-btn-close-dialog{
    position: absolute !important;
    top: 9px;
    right: 9px !important;
}
.admin-btn-bg{
        background: linear-gradient(99.98deg, #f8f8f8 56.1%, #eaeaea 113.23%);

}
    </style>

    <!-- Scripts -->
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <v-app id="inspire">
            @yield('content')
        </v-app>
      </div>


    <script src="{{ asset('js/admin.js') }}"></script>    

</body>
</html>
