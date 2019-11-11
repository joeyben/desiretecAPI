@extends('layouts.default')
@section('title')
    Language Lines
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">{{ __('menus.email_signature') }}</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">{{ __('menus.email_signature') }}</span>
    </div>
@stop

@section('content')   
    <!-- Language Filter -->
    <div class="content" id="emailSignatureComponent">
        @include('includes.alert')
        {{ Form::open(['route' => 'provider.email.signature.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'emailSignatureForm']) }}
            <div class="card">
                <div class="card-header">
                    <a href="#" class="dropdown-toggle language_select_label" data-toggle="dropdown">{{$result['data']['language']}}</a>
                    <div class="dropdown-menu">
                        @foreach(array_keys(config()->get('locale')['languages']) as $lang)
                        <a href="{{ route('provider.email.signature', $lang) }}" value="{{ $lang }}" class="dropdown-item">{{ $lang }}</a>
                        @endforeach
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group row"> 
                        {{ Form::textarea('email_signature_editor', $result['data']['text'], ['id' => 'emailSignatureEditor', 'name' => 'email_signature_editor', 'class' => 'form-control']) }}
                    </div>                
                </div>
                <div class="card-footer text-right">
                    {{ Form::submit(trans('button.save'), ['class' => 'btn', 'style' => 'background-color: rgb(19, 206, 102); border-color: rgb(19, 206, 102); color: white;']) }}
                </div>
            </div>
        {{ Form::close() }}
    </div>
    <!-- /Language Filter-->
@stop

@section('after-scripts')
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/15.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
        .create( document.querySelector( '#emailSignatureEditor' ) )
        .then( editor => {
            
        })
        .catch( error => {
            console.error( error );
        });
    </script> -->
    <script src="https://cdn.ckeditor.com/4.13.0/full-all/ckeditor.js"></script>
    <script>
        CKEDITOR.plugins.addExternal( 'lineheight', "{!! asset('js/lineheight/plugin.js') !!}" );
        CKEDITOR.replace('emailSignatureEditor', {
            height: 400,
            baseFloatZIndex: 10005,
            width: '100%',
            height: '15em',
            removeButtons: 'Anchor,ShowBlocks,CreateDiv,Flash,PageBreak,Iframe',
            removePlugins: 'elementspath',
            extraPlugins: 'lineheight',
            toolbarGroups: [
                { name: 'styles' },
                { name: 'editing', groups: ['lineheight'] },
                { name: 'insert', groups: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar'] },
                '/',
                { name: 'colors' },
                { name: 'clipboard' },
                { name: 'links' },
                { name: 'basicstyles' },
                { name: 'tools' },
                { name: 'paragraph', groups: ['list','blocks'] },
            ]
        });
        $("#emailSignatureForm").submit( function(eventObj) {
            $("<input />").attr("type", "hidden")
            .attr("name", "language")
            .attr("value", "{!! $result['data']['language'] !!}")
            .appendTo("#emailSignatureForm");
            return true;
        });
  </script>
@stop