@extends('trendtours::layouts.master')

@section('content')
    <div class="slider" style="background-image: url({{ $bg_image }})">
        <div class="welcome">
            {{ trans('whitelabel.frontend.welcome') }}
            <strong>{!! config('trendtours.name') !!} {{ trans('whitelabel.frontend.portal') }}</strong>
        </div>

        <div class="layer-action">
            <a href="javascript:showLayer();" class="btn btn-primary btn-md">{{ trans('whitelabel.frontend.create_wish') }}</a>
        </div>
    </div>
@endsection

@section('footer')
    <div class="footer">
        <ul>
            <li>
                <a href="https://www.trendtours.de/trendtours/wir-ueber-uns">Wir über uns</a>
            </li>
            <li>
                <a href="https://www.trendtours.de/trendtours/karriere">Karriere</a>
            </li>
            <li>
                <a href="https://www.trendtours.de/trendtours/arb">ARB</a>
            </li>
            <li>
                <a href="https://www.trendtours.de/trendtours/datenschutz">Datenschutz</a>
            </li>
            <li>
                <a href="https://www.trendtours.de/trendtours/impressum">Impressum</a>
            </li>
        </ul>
    </div>
@endsection
