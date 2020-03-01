@php
    if (env('APP_USE_API') === "true") {
        $url = 'https://'.strtolower($wish->whitelabel->name).'.wish-service.com/wish';
        $urlList = 'https://'.strtolower($wish->whitelabel->name).'.wish-service.com/wishlist';
    }else {
        $url = url('/wish');
        $urlList = url('/wishlist');
    }
@endphp
@extends('emails.layouts.app')

@section('content')
    <div class="content">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                        <!-- section text ======-->

                        <p style="line-height: 24px; margin-bottom:15px;">
                            {!! trans('email.wish.created.seller.header') !!}
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">
                            {!! trans('email.wish.created.seller.body_1') !!}

                            {!! trans('email.wish.created.seller.url', ['id' => $wish->id, 'token' => $token, 'url' => $url]) !!}

                            {!! trans('email.wish.created.seller.body_2') !!}

                            {!! trans('email.wish.created.seller.urllist', [ 'url' => $urlList, 'token' => $token]) !!}

                            {!! trans('email.wish.created.seller.body_3') !!}

                        </p>

                        @include('emails.layouts.footer')
                        {{-- @include(getWhitelabelFooterUrl()) --}}
</td>
</tr>
</table>
</div>
@endsection
