@extends('layouts.default')
@section('title')
    Layer Content
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">Layer Content</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">Layer Content</span>
    </div>
@stop
@section('vue-js')
    <?php $config = Config::get('whitelabels.layers'); ?>
    <script>
      var layers = <?php echo json_encode($config); ?>;
    </script>
    <script src="{{ asset('js/modules/admin/whitelabels/whitelabels.js') }}"></script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="contentComponent">
        <div class="row">
            <div class="alert alert-info border-0 alert-dismissible col-md-12 offset-md-12">
                Bitte nutzen Sie den Button “Live-Preview”, um den Cache zu leeren und den Content zu aktualisieren.
            </div>
        </div>
        <router-view></router-view>
    </div>
@stop

