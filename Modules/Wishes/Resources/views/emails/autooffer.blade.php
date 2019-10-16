@extends('emails.layouts.app')

@section('content')
    <div class="content">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">

                        <p style="line-height: 24px; margin-bottom:15px;">
                            Hallo lieber Lastminute Kunde!
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">
                            Herzlichen Glückwunsch! Wir haben neue passende xy Angebote für Ihren Reisewunsch gefunden.<br>
                            Sie können diese unter dem folgenden Link direkt aufrufen: <a href="{{ $url }}">Zu den Angebote</a><br>
                            Wir hoffen, dass Ihnen die Angebote zusagen. Bei Fragen stehen Ihnen unsere Reiseberater jederzeit zur Verfügung.<br>

                        </p>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
    </div>
@endsection
