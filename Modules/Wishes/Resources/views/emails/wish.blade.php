@php
    if (env('APP_USE_API')) {
        $url = $wish->whitelabel->domain . '/wish';
    }else {
        $url = url('/wish');
    }
@endphp

@extends('emails.layouts.app', ['whitelabel' => $wish->whitelabel])

@section('content')
    <div class="content">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">

                        <p style="line-height: 24px; margin-bottom:15px;">
                            {{ trans('email.wish.created.user.header') }}
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">
                            {!! trans('email.wish.created.user.body', ['title' => $wish->destination]) !!}

                            @if (!$wish->is_autooffer)
                                {!! trans('email.wish.created.user.url', ['id' => $wish->id,'token' => $token, 'url' => $url]) !!}
                            @endif
                        </p>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
    </div>
@endsection
