@extends('emails.layouts.app')

@section('content')
    <div class="content">
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
            <tr>
                <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                    <!-- section text ======-->

                    <p style="line-height: 24px; margin-bottom:15px;">
                        @lang('email.account.hello', ['username' => '']),
                    </p>

                    <p style="line-height: 24px; margin-bottom:20px;">
                        @lang('email.token', ['token' => $link, 'whitelabel' => $whitelabel])
                    </p>

                    @include('emails.layouts.footer')
                </td>
            </tr>
        </table>
    </div>
@endsection
