@extends('layouts.default')
@section('title')
    Dashboard
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">Dashboard</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="javascript:;" class="breadcrumb-item active"><i class="icon-home2 mr-2"></i> Dashboard</a>
    </div>
@stop
@section('vue-js')
    <script src="{{ asset('js/modules/provider/dashboard/dashboard.js') }}"></script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="dashboardComponent">
        @if(auth()->guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
            <div class="card border-top-2 border-top-slate border-bottom-2 border-bottom-slate rounded-0" style="display: none;">
                <div class="card-body">
                    {!! history()->render() !!}
                </div>
            </div>
        @endif
        <!-- Simple statistics -->
        <router-view></router-view>
    </div>
@stop
