@extends('layouts.default')
@section('title')
    List of wishes
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">List of wishes</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">List of wishes</span>
    </div>
@stop
@section('vue-js')
    <script src="{{ asset('js/modules/admin/wishes/wishes.js') }}"></script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="wishesComponent">
        <router-view></router-view>
    </div>
@stop

