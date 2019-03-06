@extends('emails.layouts.app')

@section('content')
    <div class="content">
        <td align="left">
            <table border="0" width="80%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                        <!-- section text ======-->

                        <p style="line-height: 24px; margin-bottom:15px;">
                            Hallo {{ $messageModel->wish->owner->first_name }}!
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">

                            Sie haben eine neue Nachricht von Ihrem Kunden erhalten.<br><br>

                            <a href="{{ $confirmation_url }}">Hier</a> können Sie sich einloggen und Ihrem Kunden antworten.

                        </p>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
        </td>
    </div>
@endsection
