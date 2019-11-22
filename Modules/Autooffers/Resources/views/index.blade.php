@extends('layouts.default')
@section('title')
    Offer Management
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">Offer Management</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">Offer Management</span>
    </div>
@stop
@section('vue-js')
    <script src="{{ asset('js/modules/admin/autooffers/autooffers.js') }}"></script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="autooffersComponent">
        <router-view></router-view>
    </div>
@stop

