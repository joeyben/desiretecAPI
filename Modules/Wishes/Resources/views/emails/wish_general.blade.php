<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $wish->whitelabel->display_name }}</title>
    <link media="all" type="text/css" rel="stylesheet" href="https://mvp.desiretec.com/fontawsome/css/all.css">

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

        #background-area{
            word-break:normal;
            border-collapse:collapse!important;
            vertical-align:top;
            margin-top:0;
            margin-bottom:0;
            margin-right:0;
            margin-left:0;
            text-align:left;
            font-size:14px;
            line-height:19px;
            padding-top:0px;
            padding-bottom:0;
            padding-right:0px;
            padding-left:0px;
            width:100%
        }
        #background-img{
            height:auto;
            outline-style:none;
            text-decoration:none;
            display:block;
            margin-top:0;
            margin-bottom:0;
            margin-right:auto;
            margin-left:auto;
            float:none;
            width: 600px;
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
                                                            {{-- <img  style="height:auto;
                                                                         outline-style:none;
                                                                         text-decoration:none;
                                                                         display:block;
                                                                         margin-top:0;
                                                                         margin-bottom:0;
                                                                         margin-right:auto;
                                                                         margin-left:auto;
                                                                         width: 600px;
                                                                         float:none" src="https://desiretec.s3.eu-central-1.amazonaws.com/novasol/a2524136-601e-43f1-8ff6-280fe62e9771.jpg" />
                                                            --}}

                                                            <img  style="height:auto;
                                                                         outline-style:none;
                                                                         text-decoration:none;
                                                                         display:block;
                                                                         margin-top:0;
                                                                         margin-bottom:0;
                                                                         margin-right:auto;
                                                                         margin-left:auto;
                                                                         width: 600px;
                                                                         float:none" src="{{getWhiteLabelLogoUrl('background')}}" />

                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="left" colspan="4">
                                                <table cellpadding="0" cellspacing="0" border="0" width="600" style="border: 1px solid #eee;padding-top:10px;padding-bottom:10px;border-top: 0;padding-left:0;padding-right:0;">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <table width="600" cellpadding="0" cellspacing="0">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="left" width="140" colspan="1" align="left" style="padding-left:10px;">
                                                                        <img width="15"
                                                                             style="margin:0;padding:0; display: none;"
                                                                             src="https://ci3.googleusercontent.com/proxy/YxhiOL4JOm10gJ2csqBzTYilyDASZIU_8wmAW7dkkVsvc4kxwSczk0RwSuBaEtIPMP3W0qmSwoBe_AibKPVMDF8ZlJSz-osWVnTAvo_3QUjJsED0QFKul9rUhuhVVlb13MDvug=s0-d-e1-ft#https://tui-reisewunsch.com/bundles/cskwizzme/kwizzme/images/icons/plane-down.png" />
                                                                        {{-- <i class="fas fa-home"></i> --}}
                                                                        <span style="height: 25px;">
                                                                            Reiseziel
                                                                        </span>
                                                                    </td>
                                                                    <td align="left" width="140" colspan="1" align="left" style="padding-left:10px;">
                                                                        <img width="15" style="margin:0;padding:0;display: none;"  src="https://ci3.googleusercontent.com/proxy/NN0EXnO96ZSYaYlvNQhXFMwLONfOWzSv_aVCgMdfMJRfl7VbFoh2X9hUmLUOlID7Ceou2EPynIX_qkMBtUhRJn4ArlJUBBidfpvwiqvRMXX331-0lV0UnVqrpGpUhsjy8wE=s0-d-e1-ft#https://tui-reisewunsch.com/bundles/cskwizzme/kwizzme/images/icons/calendar.png" />
                                                                        {{-- <i class="fas fa-calendar-alt"></i> --}}
                                                                        <span style="height: 25px;">
                                                                            Reisezeitraum
                                                                        </span>
                                                                    </td>
                                                                    <td align="left" width="140" colspan="1" align="left" style="padding-left:10px;">
                                                                        <img width="15" style="margin:0;padding:0;display: none;"  src="https://ci5.googleusercontent.com/proxy/0nKmd4P9ZsdZCEA6PGW3rDP4TY9wrchs9S6kI-aLH3wTt4LmUY-sOj_7fMG6XcFpCUfZAGRMXNTDr3egSVtcY7bpGUYbhdHMZg-tfPmom1EwlbAdK3z7cDCEYsyrrZXi=s0-d-e1-ft#https://tui-reisewunsch.com/bundles/cskwizzme/kwizzme/images/icons/people.png" />
                                                                        {{-- <i class="fas fa-users"></i> --}}
                                                                        <span style="height: 25px;">
                                                                            Reisende
                                                                        </span>
                                                                    </td>
                                                                    <td width="140" align="left" style="padding-left:10px;">
                                                                        <img width="15" style="display: none;" src="https://ci6.googleusercontent.com/proxy/ToInio0qfJTQbdrrIVoN87ngpdbJ3wm4Vv9wjtwbpT-N28UXTjrjVKO0e8Xnlx8vAoQqrCpMAc5cMDezCJYKA737BxMmErfq44eRC27ZMHTU6iTx3-mAKvmGaUt0DUfD=s0-d-e1-ft#https://tui-reisewunsch.com/bundles/cskwizzme/kwizzme/images/icons/budget.png" />
                                                                        {{-- <i class="fas fa-euro-sign"></i> --}}
                                                                        <span style="height: 25px;">
                                                                            Budget
                                                                        </span>
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
                                                                    <td style="font-size:10px;padding-left:10px;padding-bottom:5px;" width="140" colspan="1" align="left">
                                                                        {{ $wish->destination }}
                                                                    </td>
                                                                    <td style="font-size:10px;padding-left:10px;padding-bottom:5px;" width="140" colspan="1" align="left">
                                                                        {{ \Illuminate\Support\Carbon::parse($wish->earliest_start)->format('d.m.Y') }} - {{ \Illuminate\Support\Carbon::parse($wish->latest_return)->format('d.m.Y') }}
                                                                    </td>
                                                                    <td style="font-size:10px;padding-left:10px;padding-bottom:5px;" width="140" colspan="1" align="left">
                                                                        {{ $wish->adults }} Erw.
                                                                        @if($wish->kids > 0)
                                                                             {{ $wish->kids }} Kinder
                                                                        @endif
                                                                        @if($wish->category == 61)
                                                                            {{ $wish->kids }} Haustiere
                                                                        @endif
                                                                    </td>
                                                                    <td style="font-size:10px;padding-left:10px;padding-bottom:5px;" width="140" colspan="1" align="left">
                                                                        {{ $wish->budget }}
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
                                <td colspan="2" style="display: none;">
                                    Hallo Lieber Kunde,<br><br>
                                    Herzlich willkommen bei Ihrem NOVASOL Reisewunschportal.<br>
                                    Sie haben sich soeben registriert und Ihr Reisewunsch {{ $wish->destination}} wurde erfolgreich an uns übermittelt.<br>
                                    Wir suchen gerade nach passenden Angeboten für Ihren persönlichen Reisewunsch und informieren Sie in wenigen Minuten per E-Mail darüber.<br>
                                    Anschließend können Sie sich Ihre persönlichen Angebote im NOVASOL Reisewunschportal anschauen.
                                    </td>
                                <td colspan="2">
                                    <p>
                                        {{ trans('email.offer.header', ['whitelabel' => ucfirst($wish->whitelabel->display_name)]) }}
                                    </p>

                                    <p>
                                        {{ trans('email.offer.body', ['whitelabel' => ucfirst($wish->whitelabel->display_name)]) }}
                                    </p>

                                    <p>
                                        Sie können diese unter dem folgenden Link direkt aufrufen:
                                            <a href="{{ $wish->whitelabel->domain.'/wish/'.$wish->id }}">
                                                {{ $wish->whitelabel->domain.'/wish/'.$wish->id }}
                                            </a>
                                        {{-- trans('email.offer.link', ['link' => $wish->whitelabel->domain.'/wish/'.$wish->id]) --}}
                                    </p>

                                    {{ trans('email.offer.footer') }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr style="background: #e7e7e7;border: none;height: 1px;width: 100%;margin-top: 30px;">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table  style="width:100%;">
                                        <tbody>
                                        <tr>
                                            @include(getWhitelabelFooterUrl())
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr><td colspan="2"></td></tr>

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
