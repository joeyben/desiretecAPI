@extends('emails.layouts.app')

@section('content')
    <div class="content">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                        <!-- section text ======-->

                        <p style="line-height: 24px; margin-bottom:15px;">
                            {!! trans('email.message.user.header') !!}
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">
                            {!! trans('email.message.user.body_1') !!}
                            {!! trans('email.message.user.body_2', ['confirmation_url' => $confirmation_url]) !!}
                        </p>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
    </div>
@endsection
