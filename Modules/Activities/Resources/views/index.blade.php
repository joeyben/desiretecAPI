@extends('layouts.default')
@section('title')
    List of activities
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">List of activities</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ route('home') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">List of activities</span>
    </div>
@stop
@section('vue-js')
    <script src="{{ asset('js/modules/admin/activities/activities.js') }}"></script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="activitiesComponent">
        <router-view></router-view>
    </div>
@stop
