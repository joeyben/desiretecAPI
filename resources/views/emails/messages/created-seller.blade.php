@extends('emails.layouts.app')

@section('content')
    <div class="content">
            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
                <tr>
                    <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                        <!-- section text ======-->

                        <p style="line-height: 24px; margin-bottom:15px;">
                            Hallo@if($messageModel->wish->owner->first_name != "Muster"){{ " ".$messageModel->wish->owner->first_name }}@endif!
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">
                            {!! trans('email.message.seller.body', ['confirmation_url' => $confirmation_url]) !!}
                        </p>

                        @include('emails.layouts.footer')
                    </td>
                </tr>
            </table>
    </div>
@endsection
