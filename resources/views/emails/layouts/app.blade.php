<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns:v="urn:schemas-microsoft-com:vml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
    <meta name="viewport" content="width=600,initial-scale = 2.3,user-scalable=no">
    <!--<![if !mso]-->
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans|Fira+Sans+Condensed|Raleway" rel="stylesheet">
    <!--<![endif]-->

    <title>@yield('title', app_name())</title>

    <style type="text/css">
        body {
            width: 100%;
            margin: 0;
            padding: 0;
            mso-margin-top-alt: 0px;
            mso-margin-bottom-alt: 0px;
            mso-padding-alt: 0px 0px 0px 0px;
            -webkit-font-smoothing: antialiased;
            background-color: #eeeeee;
            font-family: 'Fira Sans',Raleway, sans-serif;
        }

        p,
        h1,
        h2,
        h3,
        h4 {
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 0;
            font-family: 'Fira Sans',Raleway, sans-serif;
        }

        span.preheader {
            display: none;
            font-size: 1px;
        }

        html {
            width: 100%;
        }

        table {
            font-size: 14px;
            border: 0;
            padding:10px;
            width: 100%;
        }

        .lap{
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
        }

        .container{
            margin-top: 25px;
            margin-left: 25px;
            margin-right: 25px;
        }

        .main-header {
            color: #343434; 
            font-size: 24px; 
            font-weight:300; 
            line-height: 35px;
        }

        .main-header .brand {
            letter-spacing: 5px;
            font-size: 28px;
        }

        .main-header .tagline {
            font-size: 16px;
        }

        .small {
            font-size: 10px;
        }

        .center {
            text-align: center;
        }

        /* ----------- responsivity ----------- */

        @media only screen and (max-width: 640px) {
            /*------ top header ------ */
            .main-header {
                font-size: 20px !important;
            }
            .main-section-header {
                font-size: 28px !important;
            }
            .show {
                display: block !important;
            }
            .hide {
                display: none !important;
            }
            .align-center {
                text-align: center !important;
            }
            .no-bg {
                background: none !important;
            }
                 
            /* ====== divider ====== */
            .divider img {
                width: 440px !important;
            }
            /*-------- container --------*/
            .container590 {
                width: 440px !important;
            }
            .container580 {
                width: 400px !important;
            }
            .main-button {
                width: 220px !important;
            }
            
        }

        @media only screen and (max-width: 479px) {
            /*------ top header ------ */
            .main-header {
                font-size: 18px !important;

            }
            .main-section-header {
                font-size: 26px !important;
            }
            
            /*-------- container --------*/
            .container590 {
                width: 210px !important;
            }
            .container590 {
                width: 210px !important;
            }
            .container580 {
                width: 260px !important;
            }
        }
    </style>
</head>
<body class="respond" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

    <div class="container">
        <table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="ffffff" style="width:60%; margin: 0 auto;" class="bg_color">
            <tr>
                <td align="center">
                    <table border="0" align="center" width="590" cellpadding="0" cellspacing="0" class="container590">
                        <tr>
                            <td align="center">
                                <table border="0" width="40" align="center" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <td align="center" style=""
                                            class="main-header">
                                            <!-- section text ======-->    

                                            <div class="tagline">
                                                    <a href="{{ route('frontend.index') }}" class="logo">
                                                        @if(isWhiteLabel())
                                                            <img width="120" class="navbar-brand" src="{{ getWhiteLabelLogoUrl() }}">
                                                        @else
                                                            <img width="120" class="navbar-brand" src="{{route('frontend.index')}}/img/logo_big.png">
                                                        @endif
                                                    </a>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td height="20" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                        </tr>

                        <tr>
                            @yield('content')
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td height="40" style="font-size: 40px; line-height: 40px;">&nbsp;</td>
            </tr>
        </table>
    </div>
    <!-- end section -->
</body>
</html>