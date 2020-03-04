@extends('novasol::layouts.master')

@section('content')
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
