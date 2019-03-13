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
                            Sie haben Ihren Reisewunsch {{ $wish->title}} erfolgreich erstellt. Einer unserer Spezialisten für das Reiseziel {{ $wish->title}} wird sich in Kürze bei Ihnen melden.<br><br>

                            Sie haben jederzeit die Möglichkeit Ihren Reisewunsch zu verändern.<br><br>

                            <a href="{{ url('/wish') }}/{{ $wish->id}}/{{ $token }}"> {{ url('/wish') }}/{{ $wish->id}}/{{ $token }}</a>
                        </p>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
        </td>
    </div>
@endsection
