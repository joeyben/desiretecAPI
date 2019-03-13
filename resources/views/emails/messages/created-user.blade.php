@extends('emails.layouts.app')

@section('content')
    <div class="content">
        <td align="left">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                        <!-- section text ======-->

                        <p style="line-height: 24px; margin-bottom:15px;">
                            Liebe Kundin, lieber Kunde!
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">

                            Ihr persönlicher desiretec Reiseberater hat Ihnen eine Nachricht geschrieben, um Ihren Traumurlaub zu finden.<br><br>

                            Am besten beantworten Sie die Nachricht noch heute. Über den folgenden Link können Sie die Nachricht lesen und beantworten: {{ $confirmation_url }} gelangen Sie zur Nachricht und können Ihrem Berater darauf antworten!<br><br>

                            Alternative können Sie die Antworten Funktion Ihres Browsers benutzen.

                        </p>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
        </td>
    </div>
@endsection
