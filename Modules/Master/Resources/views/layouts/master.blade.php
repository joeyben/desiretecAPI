@extends('frontend.layouts.app')

@section('title')
    {!! $display_name !!}
@endsection

@section('after-styles')
    <link rel="stylesheet" href="{{ mix('whitelabel/master/css/master.css') }}">
@endsection

@section('logo')
    <a href="{{ route('frontend.index') }}" class="logo">
        <img class="navbar-brand" src="{{ getWhiteLabelLogoUrl(getCurrentWhiteLabelId()) }}">
    </a>
@endsection

@section('before-scripts')
    <script src="{{ mix('whitelabel/master/js/master.js') }}"></script>
@endsection

@section('after-scripts')

    <script type="application/javascript">
        window.dt = {
            config: { baseUrl: ''  }
        };

        var kwz = document.createElement('script');
        kwz.type = 'text/javascript'; kwz.async = true;
        kwz.src = '/whitelabel/master/js/layer/layer-locale.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(kwz, s);

        function isMobile(){
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                return true;
            }
            return false;
        }

        function showLayer(){
            dt.PopupManager.show();
            if(isMobile()){
                $("body").addClass('mobile-layer');
            }
        }
    </script>
@endsection
