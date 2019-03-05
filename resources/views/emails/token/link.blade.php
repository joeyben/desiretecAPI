@extends('emails.layouts.app')

@section('content')
    <div class="content">
        <td align="left">
            <table border="0" width="80%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                        <!-- section text ======-->

                        <p style="line-height: 24px; margin-bottom:15px;">
                            @lang('email.account.hello', ['username' => '']),
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">
                            @lang('email.token', ['token' => $link])
                        </p>

                        <br/>

                        @lang('email.footer.line1'),<br>
                        @lang('email.footer.line2')<br><br>
                        @lang('email.footer.line3')<br>
                        @lang('email.footer.line4')<br>
                    </td>
                </tr>
            </table>
        </td>
    </div>
@endsection
