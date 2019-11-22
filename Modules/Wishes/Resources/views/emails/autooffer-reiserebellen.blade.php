@extends('emails.layouts.app')

@section('content')
    <div class="content">
        <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0" class="container590">
            <tr>
                <td colspan="2">
                    <table class="wish-list" cellpadding="0" align="center" width="600" cellspacing="0">
                        <tbody>
                        <tr>
                            <td colspan="4">
                                <table cellpadding="0" cellspacing="0" border="0" align="left" width="600" style="border: 1px solid #eee;border-bottom:none;">
                                    <tbody>
                                    <tr>
                                        <td align="left" style="word-break:normal;border-collapse:collapse!important;vertical-align:top;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;text-align:left;font-size:14px;line-height:19px;padding-top:0px;padding-bottom:0;padding-right:0px;padding-left:0px;width:100%">
                                            <img  style="height:auto;
                                                                         outline-style:none;
                                                                         text-decoration:none;
                                                                         display:block;
                                                                         margin-top:0;
                                                                         margin-bottom:0;
                                                                         margin-right:auto;
                                                                         margin-left:auto;
                                                                         width: 600px;
                                                                         float:none"
                                                  src="{{ getWhiteLabelLogoUrl('background') }}" />
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td height="20px">
                                &nbsp;
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" style="color: #888888; width:100%; font-size: 16px; line-height: 24px;">

                    <p style="line-height: 24px; margin-bottom:15px;">
                        Hallo {{ $logged_in_user->name }}
                    </p>

                    <p style="line-height: 24px; margin-bottom:20px;">
                        Herzlichen Glückwunsch! Wir haben passende Angebote für deinen Reisewunsch gefunden.<br>
                        Sie können diese unter dem folgenden Link direkt aufrufen: <a href="{{ $url }}">Zu den Angebote</a><br>
                        Unsere Experten-Beratung ist absolut unverbindlich und kostenfrei für dich. Unser Vorteil ist, dass du einen persönlichen Ansprechpartner hast <b>-> vor, während und nach deiner Reise.</b> Daher würden wir uns freuen, wenn du am Ende auch bei uns deine Reise buchst.<br>
                    </p>

                    @include('emails.layouts.footer')
                </td>
            </tr>
        </table>
    </div>
@endsection
