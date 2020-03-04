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
    <script>
      function myFunction() {
        var copyText = document.getElementById("myInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        alert("Copied the text: " + copyText.value);
      }
    </script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="whitelabelsProviderComponent">
        <div class="row">
            <div class="alert alert-info border-0 alert-dismissible col-md-12 offset-md-12">
                Kopieren Sie dieses Snippet und fügen Sie es auf Ihrer Website ein:
            </div>
        </div>

        <pre class="language-less mb-1 flex-column"><code>
            <div class="form-group">
                <div class="input-group wmin-md-200">
                    <input type="text" value='&lt;script  type="text/javascript" src="{{ $whitelabel->domain }}/js/layer.js"&gt;&lt;/script&gt;' id="myInput" readonly class="form-control">
                    <span class="input-group-append">
                    <span class="btn btn-outline bg-grey-400 text-grey-400 border-grey-400 input-group-text" onclick="myFunction()"><i class="icon-clippy"></i></span>
                </span>
                </div>
            </div></code>
        </pre>
    </div>
@stop

