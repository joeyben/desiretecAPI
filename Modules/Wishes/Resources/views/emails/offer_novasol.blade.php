<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $wish->whitelabel->display_name }}</title>
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
                    <td colspan="2" align="right">
                        <img src="{{ getWhiteLabelLogoUrl() }}" width="50" />
                    </td>
                </tr>
                <tr>
                    <td  style="padding:0 0 0 0">
                        <table width="600" class="">
                            <tbody>
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
                                                                         float:none"
                                                                  src="{{ '/whitelabel/novasol/images/wish/email_cover.jpg' }}" />
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
                    <td colspan="2" align="left" style="color: #888888; width:20px; font-size: 16px; line-height: 24px;">
                        <!-- section text ======-->

                        <p style="line-height: 24px; margin-bottom:15px;">
                            {{ trans('email.offer.novasol_created_user.header') }}<br>
                        </p>

                        <p style="line-height: 24px; margin-bottom:20px;">
                            {{ trans('email.offer.novasol_created_user.body') }}<br>
                            {!! trans('email.offer.novasol_created_user.link', ['link' => url('/novasoloffer/create/'.$wish->id)]) !!}<br>
                        </p>
                            {{ trans('email.offer.novasol_created_user.footer') }}<br>
                        <p>
                        </p>
                    </td>
                </tr>
                            <tr>
                                <td colspan="2" height="10">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" height="10">
                                    &nbsp;
                                </td>
                            </tr>
                            <tr><td colspan="2"><hr style="background: #e7e7e7;border: none;height: 1px;width: 100%;margin-top: 30px;"></td></tr>

                            <tr>
                                <td colspan="2">
                                    <table  style="width:100%;">
                                        <tbody>
                                        <tr>
                                            @lang('email.footer_novasol.line1'),<br>
                                            @lang('email.footer_novasol.line2')<br><br>
                                            @lang('email.footer_novasol.line3')<br>
                                            @lang('email.footer_novasol.line4')<br>
                                            @lang('email.footer_novasol.line5')<br>
                                            @lang('email.footer_novasol.line6')<br>
                                            @lang('email.footer_novasol.line7')<br>
                                        </tr>
                                        </tbody>
                                    </table>
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
