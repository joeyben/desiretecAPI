<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ __('New User') }}</title>
    <style type="text/css">
        tr{
            border-spacing: 0px;
            border-collapse: initial;
        }
        td{
            font-size: 12px;
        }
        body{
            font-family: ‘Noto Sans’, sans-serif;
        }

        @media only screen and (max-width: 480px) {

        }
    </style>
</head>
<body>
<table style="background:#fff;border:1px solid #f1f1f1;padding: 10px;margin:auto;" width="600" cellpadding="0" cellspacing="0" border="0">
    <tbody>
    <tr><td>
            <table style="background: none repeat scroll 0 0 #FFFFFF;margin: 0 auto;width:600px;" width="600" cellpadding="0" cellspacing="0" border="0">
                <tbody>
                <tr>
                    <td  style="padding:0 0 0 0">
                        <table width="600" class="">
                            <tbody>
                            <tr>
                                <td colspan="2">
                                    <table class="wish-list" cellpadding="0" align="center" width="600" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td align="left" colspan="4">
                                                <table cellpadding="0" cellspacing="0" border="0" width="600" style="border: 1px solid #eee;padding-top:10px;padding-bottom:10px;border-top: 0;padding-left:0;padding-right:0;">
                                                    <tbody>
                                                    <tr>
                                                        <td >
                                                            <table width="600" cellpadding="0" cellspacing="0">
                                                                <tbody>
                                                                <tr>
                                                                    <td width="140" align="left" style="padding-left:10px;">
                                                                        @lang('labels.whitelabel')
                                                                    </td>
                                                                    <td width="140" align="left" style="padding-left:10px;">
                                                                        @lang('labels.name')
                                                                    </td>
                                                                    <td width="140" align="left" style="padding-left:10px;">
                                                                        @lang('labels.email')
                                                                    </td>
                                                                    <td width="140" align="left" style="padding-left:10px;">
                                                                        @lang('labels.password')
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table width="600" cellpadding="0" cellspacing="0">
                                                                <tbody>
                                                                <tr>
                                                                    <td style="font-size:10px;padding-left:10px;" width="140" align="left">
                                                                        {{ $whitelabel->display_name }}
                                                                    </td>
                                                                    <td style="font-size:10px;padding-left:10px;" width="140" align="left">
                                                                        {{ $user->first_name . ' ' . $user->last_name }}
                                                                    </td>
                                                                    <td style="font-size:10px;padding-left:10px;" width="140" align="left">
                                                                        {{ $user->email }}
                                                                    </td>
                                                                    <td style="font-size:10px;padding-left:10px;" width="140" align="left">
                                                                        {{ $password }}
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
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
                                <td colspan="2">
                                    <br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    @lang('email.account.hello', ['username' => $user->first_name . ' ' . $user->last_name])!<br><br>

                                    @lang('email.account.activated', ['account' => 'Anbieter', 'whitelabel' => $whitelabel->name])<br><br>

                                    @lang('email.account.link')<br><br>

                                    @lang('labels.email'): {{ $user->email }}<br><br>

                                    @lang('labels.password'): {{ $password }} </td></tr>
                            <tr>
                                <td colspan="2" height="10">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a target="_blank" href="{{ $whitelabel->domain }}/login" class="button button-primary" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px #f96500; color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #f96500; border-top: 10px solid #f96500; border-right: 18px solid #f96500; border-bottom: 10px solid #f96500; border-left: 18px solid #f96500;">
                                        {{ __('Login') }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" height="10">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">

                                </td>
                            </tr>
                            <tr><td colspan="2"><hr style="background: #e7e7e7;border: none;height: 1px;width: 100%;margin-top: 30px;"></td></tr>

                            <tr>
                                <td colspan="2">
                                    @include('emails.layouts.footer')
                                </td>
                            </tr>

                            <tr><td colspan="2"><hr style="background: #e7e7e7;border: none;height: 1px;width: 100%;margin-top: 30px;"></td></tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td></tr>
    </tbody>
</table>
</body>
</html>
