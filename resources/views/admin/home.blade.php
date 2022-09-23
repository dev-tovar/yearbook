@extends('../layouts.admin')

@section('content')
@include('../admin.includes.menu-left')
@include('../admin.includes.bar')
<v-main class="pb-0" style="background: #FFFEFC;">

<v-fade-transition fluid fill-height mode="out-in">
    <router-view></router-view>
</v-fade-transition>
</v-main>
@endsection
