@extends('frontend.layouts.app')

@section('title')
    {!! $display_name !!}
@endsection

@section('after-styles')
    <link rel="stylesheet" href="{{ asset('whitelabel/reiseexperten/css/reiseexperten.css') }}">
@endsection

@section('logo')
    <a href="{{ route('frontend.index') }}" class="logo">
        <img class="navbar-brand" src="{{ $logo }}">
    </a>
@endsection

@section('before-scripts')
    <script src="{{ mix('whitelabel/reiseexperten/js/reiseexperten.js') }}"></script>

    <script type="application/javascript">
        var brandColor = {!! json_encode($color) !!};
        var cssPrimaryBtn = '.primary-btn, .btn-primary { background: ' + brandColor + ' !important; border: 1px solid ' + brandColor + ' !important; } ';
        $('head').append('<style>' + cssPrimaryBtn + '</style>');
    </script>
@endsection

@section('after-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script type="application/javascript">
        window.dt = {
            config: { baseUrl: ''  }
        };

        var kwz = document.createElement('script');
        kwz.type = 'text/javascript'; kwz.async = true;
        kwz.src = '/whitelabel/reiseexperten/js/layer/layer.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(kwz, s);

        function isMobile(){
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                return true;
            }
            return false;
        }

        function showLayer(){

             if($(".dt-modal").hasClass("teaser-on")){
                        return false;
             }
             dt.PopupManager.show();

             if(isMobile()){
                 $("body").addClass('mobile-layer');
                 $(".dt-modal").addClass('m-open');

                 dt.PopupManager.isMobile = true;
                 dt.PopupManager.layerShown = true;
             }
        }
    </script>
@endsection
