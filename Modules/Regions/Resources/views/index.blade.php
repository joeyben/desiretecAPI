@extends('layouts.default')
@section('title')
    List of regions
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">List of regions</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">List of regions</span>
    </div>
@stop
@section('vue-js')
    <script src="{{ asset('js/modules/admin/regions/regions.js') }}"></script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="regionsComponent">
        <router-view></router-view>
    </div>
@stop

