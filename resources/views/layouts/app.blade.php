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
        .login-input .v-input__append-inner{
            margin-top: auto !important;
            margin-bottom: auto !important;
        }
        .login-input fieldset {
            border: 2px solid !important;
            color: #494949 !important;
}

        @font-face{
  font-family: text-security-disc;
  src: url("/fonts/text-security-disc.woff");
}

.login-input.password input{
  font-family: text-security-disc;
  -webkit-text-security: disc;
}

.login-btn{
    background: linear-gradient(99.98deg, #f8f8f8 56.1%, #eaeaea 113.23%);
}

    </style>

    <!-- Scripts -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <v-app id="inspire">
            @yield('content')
        </v-app>
      </div>


    <script src="{{ asset('js/login.js') }}"></script>    

</body>
</html>
