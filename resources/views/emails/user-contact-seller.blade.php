@extends('emails.layouts.app')

@section('content')
<div class="content">
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
            <tr>
                <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                    <!-- section text ======-->

                    <p style="line-height: 24px; margin-bottom:15px;">
                        Hallo!
                    </p>
                    
                    <p style="line-height: 24px; margin-bottom:20px;">
                        Herzlichen Glückwunsch, Ihr Kontaktangebot wurde angenommen.<br>
                        Die Kontaktdaten des Kunden finden Sie jetzt <a href="{{ $confirmation_url }}">in Ihren Kontakten</a> auf desiretec.<br><br>

                        Wir wünschen Ihnen einen erfolgreichen Kontakt zum Kunden und freuen uns über Ihre weiteren Angebote.
                    </p>

                    @include('emails.layouts.footer')
                </td>
            </tr>
        </table>
</div>
@endsection
                        