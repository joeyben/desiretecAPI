@extends('frontend.layouts.app')

@section('title')
    {!! $display_name !!}
@endsection

@section('after-styles')
    <link rel="stylesheet" href="{{ mix('whitelabel/tui/css/tui.css') }}">
@endsection

@section('logo')
    <a href="{{ route('frontend.index') }}" class="logo">
        <img class="navbar-brand" src="/img/logo_tui.png">
    </a>
@endsection

@section('after-scripts')

    <script src="{{ mix('whitelabel/tui/js/tui.js') }}"></script>
    <script type="application/javascript">
        window.kwizzme = {
            config: { baseUrl: ''  }
        };

        var kwz = document.createElement('script');
        kwz.type = 'text/javascript'; kwz.async = true;
        kwz.src = '/whitelabel/tui/js/layer/layer.js';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(kwz, s);

        function isMobile(){
            if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
                return true;
            }
            return false;
        }

        function showLayer(){
            kwizzme.PopupManager.show();
            if(isMobile()){
                $("body").addClass('mobile-layer');
            }
        }
    </script>
@endsection
