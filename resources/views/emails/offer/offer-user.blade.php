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

                        Einer unserer Spezialisten für das Reiseziel {{ $offer->wish->title }} hat ein Angebot für Ihren desiretec Reisewunsch erstellt! Sie können es unter dem folgenden Link direkt<br><br>

                        {{ $confirmation_url }}<br><br>

                        Wir hoffen, Ihnen sagt das Angebot zu.
                    </p>

                    @include('emails.layouts.footer')
                </td>
            </tr>
        </table>
    </td>
</div>
@endsection
                        