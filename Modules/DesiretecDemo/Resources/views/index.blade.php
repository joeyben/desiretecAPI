@extends('desiretecdemo::layouts.master')

@section('content')
    <div class="slider" style="background-image: url({{ $bg_image }})">
        <!--div class="welcome">
        {{ trans('whitelabel.frontend.welcome') }}
        <strong>{{ trans('whitelabel.frontend.name', ['whitelabel' => $display_name]) }} {{ trans('whitelabel.frontend.wish_portal') }}</strong>
        </div-->

        <!--div class="layer-action">
            <a href="javascript:showLayer();" class="btn btn-primary btn-md">persönliche Beratung</a>
        </div-->
    </div>
@endsection

@section('footer')
    @include('desiretecdemo::layouts.footer')
@endsection
