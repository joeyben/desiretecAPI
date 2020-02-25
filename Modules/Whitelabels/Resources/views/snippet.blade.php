@extends('layouts.default')
@section('title')
    Snippet Management
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">Snippet Management</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">Snippet Management</span>
    </div>
@stop
@section('vue-js')
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="whitelabelsProviderComponent">
        <div class="row">
            <div class="alert alert-info border-0 alert-dismissible col-md-12 offset-md-12">
                Kopieren Sie dieses Snippet und fügen Sie es auf Ihrer Website ein
            </div>
        </div>

        <pre class="language-less mb-1"><code>
            <span class="hljs-tag">&lt;<span class="hljs-name">script</span>  type="text/javascript" <span class="hljs-attr">src</span>=<span class="hljs-string">"{{ $whitelabel->domain }}/js/layer.js"</span>&gt;</span><span class="undefined"></span><span class="hljs-tag">&lt;/<span class="hljs-name">script</span>&gt;</span></code>
        </pre>
    </div>
@stop

