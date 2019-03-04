@extends('emails.layouts.app')

@section('content')
<div class="content">
    <td align="left">
        <table border="0" width="80%" align="center" cellpadding="0" cellspacing="0" class="container590">
            <tr>
                <td align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                    <!-- section text ======-->

                    <p style="line-height: 24px; margin-bottom:15px;">
                        Hello!
                    </p>
                    
                    <p style="line-height: 24px; margin-bottom:20px;">
                        Click here to confirm your account:
                    </p>
                    <p>{{ $contact->message }}</p>

                    <p style="line-height: 24px; margin-bottom:20px;">
                        Thank you for using our application!
                    </p>

                    <p style="line-height: 24px">
                        Regards,</br>
                        @yield('title', app_name())
                    </p>

                    <br/>

                    <p class="small" style="line-height: 24px; margin-bottom:20px;">
                            If you’re having trouble clicking the "Confirm Account" button, copy and paste the URL below into your web browser: 
                    </p>

                    <p class="small" style="line-height: 24px; margin-bottom:20px;">
                        <a href="{{ $confirmation_url }}" target="_blank" class="lap">
                            {{ $confirmation_url}}
                        </a>
                    </p>

                    @include('emails.layouts.footer')
                </td>
            </tr>
        </table>
    </td>
</div>
@endsection
                        