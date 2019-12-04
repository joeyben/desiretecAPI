<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="UTF-8">

    @if(isWhiteLabel())
        <link rel="icon" type="image/png" href="{{ getWhiteLabelLogoUrl('favicon') }}">
        <title>@yield('title', getCurrentWhiteLabelName())</title>
    @else
        <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}">
        <title>@yield('title', app_name())</title>
    @endif


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link media="all" type="text/css" rel="stylesheet" href="https://mvp.desiretec.com/fontawsome/css/all.css">
    <link rel="stylesheet" href="/whitelabel/tui/css/layer/whitelabel.css">
    <link rel="stylesheet" href="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
    <link media="all" type="text/css" rel="stylesheet" href="https://mvp.desiretec.com/fontawsome/css/all.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript" src="https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <style type="text/css">
        #desiretecLayer{
            width: 650px;
            margin:50px auto;
            border: 1px solid #ddd;
            z-index: 9;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            -webkit-box-shadow: 0 0 4px 0 rgba(0,0,0,.25);
        }
        body{
            font-size: 14px;
        }

    </style>


    <script type="application/javascript">
        var brandColor = {!! json_encode($color) !!};
    </script>
</head>

<body>

    <div id="desiretecLayer">
        @if(count($layers) > 1)
            <div class="header float-left w-100" style="border-bottom: 1px solid #dedede">
            <!-- Nav tabs -->
                <ul class="nav nav-tabs float-left"  role="tablist" style="border-bottom: none">
                    @foreach($layers as $layer)
                        <li class="nav-item">
                            <a class="nav-link @if($layer['active']) active @endif"
                               id="{{ $layer['name'] }}-tab"
                               data-toggle="tab"
                               href="#{{ $layer['name'] }}"
                               role="tab"
                               aria-controls="{{ $layer['name'] }}"
                               aria-selected="true">
                                {{ ucfirst($layer['name']) }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="float-right" style="margin-top: 7px; margin-right: 8px">
                    <div class="kwp-close" style="cursor: pointer"></div>
                </div>
            </div>
        @else
            <div class="float-right" style="margin-top: 24px; margin-right: 8px">
                <div class="kwp-close" style="cursor: pointer"></div>
            </div>
        @endif



    <!-- Tab panes -->
        <div class="tab-content" style="margin-top: 38px">
            @foreach($layers as $layer)
                @include('frontend.layers._parts.'.$layer['name'],
                    [
                        'active'  => $layer['active'],
                        'request' => $layer['request'],
                        'title'   => $layer['title'],
                        'text'    => $layer['text'],
                        'bgImage' => $layer['bgImage'],
                        'color'   => $color,
                    ]
                )
            @endforeach
        </div>
    </div>

</body>




</html>
