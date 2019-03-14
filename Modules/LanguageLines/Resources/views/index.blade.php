@extends('layouts.default')
@section('title')
    Language Lines
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">Language Lines</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">Language Lines</span>
    </div>
@stop
@section('vue-js')
    <script src="{{ asset('js/modules/admin/languagelines/languagelines.js') }}"></script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="languageLinesComponent">
        <router-view></router-view>
    </div>
@stop

