@extends('master::layouts.master')

@section('content')
    <div class="slider" style="background-image: url({{ Storage::disk('s3')->url($bg_image) }})">
        <div class="welcome">
            Welcome to
            <strong>{!! config('master.name') !!} WISHPORTAL</strong>
        </div>

        <div class="layer-action">
            <a href="javascript:showLayer();" class="btn btn-primary btn-md">{{ trans('navs.frontend.create_wish') }}</a>
        </div>
    </div>
@endsection