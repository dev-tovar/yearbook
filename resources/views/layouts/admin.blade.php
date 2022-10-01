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
  width: 8px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #c7c7c7; 
  /* border-bottom-right-radius: 10px; */
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #000; 
  border-radius: 0px;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #000; 
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

.admin-menu .v-list-item--active::after {
    content: "";
    height: 100%;
    position: absolute;
    width: 3px;
    background: #000;
    right: 0;
}

.hidde-scroll-bar .v-navigation-drawer__content::-webkit-scrollbar {
  display: none;
}

/* Hide scrollbar for IE, Edge and Firefox */
.hidde-scroll-bar .v-navigation-drawer__content {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
@font-face{
  font-family: text-security-disc;
  src: url("/fonts/text-security-disc.woff");
}

.login-input.password input{
  font-family: text-security-disc;
  -webkit-text-security: disc;
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
