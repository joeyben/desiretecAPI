@extends('frontend.layouts.app')

@section('title')
    {!! $display_name !!}
@endsection

@section('before-styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,700,700italic,900" media="all">
@endsection

@section('after-styles')
    <link rel="stylesheet" href="{{ asset('whitelabel/novasol/css/novasol.css') }}">
@endsection

@section('logo')
    <a href="{{ route('frontend.index') }}" class="logo">
        <img class="navbar-brand" src="{{ $logo }}">
    </a>
@endsection

@section('before-scripts')
    <script src="{{ mix('whitelabel/test/js/layer/layer.js') }}"></script>
@endsection

@section('after-scripts')

    <script type="application/javascript">
        window.dt = {
            config: { baseUrl: ''  }
        };

        var kwz = document.createElement('script');
        kwz.type = 'text/javascript'; kwz.async = true;
        kwz.src = '/whitelabel/test/js/layer/layer.js';
        //kwz.src = '/whitelabel/novasol/js/layer/layer.js';
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
