@extends('novasol::layouts.master')

@section('content')
    <style type="text/css">
        @media only screen and (min-width: 1400px) {
            .slider{
                height: 1110px;
            }
            .slider .layer-action{
                top: 300px;
            }
        }
    </style>


    <div class="slider" style="background-image: url({{ $bg_image }})">
        <div class="welcome">
            {{ trans('whitelabel.frontend.welcome') }}
            <strong>{!! $display_name !!} {{ trans('whitelabel.frontend.portal') }}</strong>
        </div>

        <div class="layer-action">
            <a href="javascript:showLayer();" class="btn btn-primary btn-md">
                {{ trans('whitelabel.frontend.create_wish') }}
            </a>
        </div>
    </div>
@endsection

@section('footer')
    @include('novasol::layouts.footer')
@endsection
