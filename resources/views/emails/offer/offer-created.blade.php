@extends('emails.layouts.app')

@section('content')
<div class="content">
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
            <tr>
                <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                    <!-- section text ======-->

                    <p style="line-height: 24px; margin-bottom:15px;">
                        Hallo {{ $offer->owner->first_name }}!
                    </p>
                    
                    <p style="line-height: 24px; margin-bottom:20px;">
                        Ihr Angebot <a href="{{ $confirmation_url }}">{{ $offer->title }}</a> wurde erfolgreich erstellt. Der Kunde wurde darüber informiert und wird Sie kontaktieren, wenn ihm das Angebot zusagt.<br>
                        Sie haben jederzeit die Möglichkeit Ihr Angebot zu ändern.
                    </p>

                    @include('emails.layouts.footer')
                </td>
            </tr>
        </table>
</div>
@endsection
                        