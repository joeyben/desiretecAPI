@extends('layouts.default')
@section('title')
    Whitelabel Management
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">Whitelabel Management</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">Whitelabel Management</span>
    </div>
@stop
@section('vue-js')
    <script src="{{ asset('js/modules/admin/whitelabels/whitelabels.js') }}"></script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="whitelabelsProviderComponent">
        <router-view></router-view>
    </div>
@stop
