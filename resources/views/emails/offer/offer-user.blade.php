@extends('emails.layouts.app')

@section('content')
<div class="content">
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
            <tr>
                <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                    <!-- section text ======-->

                    <p style="line-height: 24px; margin-bottom:15px;">
                        Liebe Kundin, lieber Kunde!
                    </p>
                    
                    <p style="line-height: 24px; margin-bottom:20px;">
                        {!! nl2br(trans('email.offer.created.user.body', ['confirmation_url' => $confirmation_url, 'title' => $offer->wish->title])) !!}
                    </p>

                    @include('emails.layouts.footer')
                </td>
            </tr>
        </table>
    <div style="display: none">manual,{{ getCurrentWhiteLabelId() }}</div>
</div>
@endsection
                        