@extends('frontend.layouts.app')

@section('title')
    {!! $display_name !!}
@endsection

@section('after-styles')
    <link rel="stylesheet" href="{{ asset('whitelabel/fn/css/fn.css') }}">
@endsection

@section('logo')
    <a href="{{ route('frontend.index') }}" class="logo">
        <img class="navbar-brand" src="{{ $logo }}">
    </a>
@endsection

@section('before-scripts')
    <script src="{{ mix('whitelabel/fn/js/fn.js') }}"></script>
@endsection

@section('after-scripts')

    <script type="application/javascript">
        window.dt = {
            config: { baseUrl: ''  }
        };

        var kwz = document.createElement('script');
        kwz.type = 'text/javascript'; kwz.async = true;
        kwz.src = '/whitelabel/fn/js/layer/layer.js';
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
