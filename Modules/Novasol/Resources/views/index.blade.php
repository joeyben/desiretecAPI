@extends('novasol::layouts.master')

@section('content')
    <div class="slider" style="background-image: url({{ $bg_image }})">
        <div class="welcome">
            {{ trans('whitelabel.frontend.welcome') }}
            <strong>{!! config('novasol.name') !!} {{ trans('whitelabel.frontend.portal') }}</strong>
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
                <a href="https://www.novasol.de/novasol/wir-ueber-uns">Wir über uns</a>
            </li>
            <li>
                <a href="https://www.novasol.de/novasol/karriere">Karriere</a>
            </li>
            <li>
                <a href="https://www.novasol.de/novasol/arb">ARB</a>
            </li>
            <li>
                <a href="https://www.novasol.de/novasol/datenschutz">Datenschutz</a>
            </li>
            <li>
                <a href="https://www.novasol.de/novasol/impressum">Impressum</a>
            </li>
        </ul>
    </div>
@endsection
