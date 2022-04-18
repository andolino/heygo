@extends('layouts.app-admin')

@section('content')
<main>
    @switch($link)
        @case('admins')
            {{-- <dashboard-panel></dashboard-panel> --}}
            @break
        {{-- @case('settings-panel')
            <settings-panel></settings-panel>
            @break --}}
        @default
            @break
    @endswitch
    <router-view></router-view>
    {{-- <dashboard-panel></dashboard-panel> --}}
</main>
@endsection
