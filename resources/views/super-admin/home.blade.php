@extends('../layouts.super-admin')

@section('content')
@include('../super-admin.includes.menu-left')
@include('../super-admin.includes.bar')
<v-main class="pb-0" style="background: #FFFEFC;">

<v-fade-transition fluid fill-height mode="out-in">
    <router-view></router-view>
</v-fade-transition>
</v-main>
@endsection
