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
                        Lieber Anbieter, Ihr Kunde bittet Sie um einen Rückruf.<br>
                        Am besten passt es ihm, wenn Sie ihn <strong>{{ $contact->period }}</strong> anrufen.<br><br>

                        Hier finden sie seine Kontaktdaten:<br>

                        <strong>Vorname:</strong> {{ $contact->first_name }}<br>
                        <strong>Nachname:</strong> {{ $contact->last_name }}<br>
                        <strong>Tel.:</strong> {{ $contact->telephone }}<br>
                    </p>
                    <br><br>
                    @php
                        if (env('APP_USE_API')) {
                            $url = 'https://'.strtolower($wish->whitelabel->name).'.wish-service.com/wishes';
                        }else {
                            $url = url('/wish');
                        }
                    @endphp

                    {!! trans('email.contact.seller.wish_url', ['id' => $wish_id,'token' => $token, 'url' => $url]) !!}

                    @include('emails.layouts.footer')
                </td>
            </tr>
        </table>
</div>
@endsection
                        