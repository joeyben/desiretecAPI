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
                            Ihnen wurde ein neuer desiretec Reisewunsch zur Bearbeitung zugewiesen:<br><br>

                            <a href="{{ url('/wish') }}/{{ $wish->id}}"> {{ url('/wish') }}/{{ $wish->id}}</a><br><br>

                            Im desiretec System finden Sie alle Reisewünsche und können passende Angebote erstellen:<br><br>

                            <a href="{{ url('/wishlist') }}"> {{ url('/wishlist') }}</a><br><br>


                            Bitte beachten Sie, dass bis zur Kontaktaufnahme mit dem Kunden nicht mehr als 24h, maximal aber 48h vergehen sollten.
                        </p>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
    </div>
@endsection
