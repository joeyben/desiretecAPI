@extends ('frontend.layouts.app')

@section ('title', trans('labels.backend.wishes.management') . ' | ' . trans('labels.backend.wishes.create'))

@section("after-styles")
    <link rel="stylesheet" href="{{ asset('modules/css/offers.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/css/ol.css" type="text/css">
    <style>
      .map {
        height: 400px;
        width: 100%;
      }
    </style>
    <script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.wishes.management') }}
        <small>{{ trans('labels.backend.wishes.create') }}</small>
    </h1>
@endsection

@section('content')
<!-- CONTENT -->
<div class="top-container">
    <div class="wish">

        <div class="wishlabel">
                <span class="text">
                    Dein Reisewunsch

                </span>
            <i class="toggle-wish">
                <i class="fa fa-plus" aria-hidden="true"></i>
                <i class="fa fa-minus" aria-hidden="true"></i>
            </i>
        </div>
        <ul class="wish-list">
            <li>
                <span class="top"><i class="fa fa-plane" aria-hidden="true"></i></span>
                <span class="bottom" data-toggle="tooltip" data-html="true" data-placement="bottom" data-title="{{ $wish->airport }}">{{ $wish->airport }}</span>
            </li>

            <li>
                <span class="top"><i class="fa fa-plane" aria-hidden="true"></i></span>
                <span class="bottom">{{ $wish->destination }}</span>
            </li>

            <li>
                <span class="top"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                <span class="bottom">{{  \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.Y') }} - {{  \Carbon\Carbon::parse($wish->latest_return)->format('d.m.Y') }}</span>
            </li>


            <li class="no-border">
                <span class="top"><i class="fa fa-users" aria-hidden="true"></i></span>
                <span class="bottom" data-toggle="tooltip" data-html="true" data-placement="bottom" data-title="{{ $wish->adults }}">{{ $wish->adults }} Erw.
                            </span>
            </li>

            <li>
                <span class="top"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                <span class="bottom">{{ $wish->budget }}€</span>
            </li>

            <li>
                <span class="top"><i class="fa fa-clock-o" aria-hidden="true"></i></span>

                <span class="bottom">{{ $wish->duration }} Tage
                             </span>
            </li>

            <li>
                <span class="top"><i class="fa fa-bed" aria-hidden="true"></i></span>
                <span class="bottom">
                        Hotel: {{ $wish->category }}
                            </span>
            </li>

            <li>
                <span class="top"><i class="fa fa-h-square" aria-hidden="true"></i></span>
                <span class="bottom">{{ $wish->catering }}</span>
            </li>

        </ul>
    </div>

    <div class="top-panels">
        <div class="seller">
            <div class="seller-image">
                <span class="img" style="background-image: url({{ asset('bundles/cssonnenklar/sonnenklar/images/logo.svg') }});"></span>
            </div>
            <div class="seller-name">
            </div>
            <div class="seller-message">
                @if (count($prices) === 0)
                "Leider haben wir noch keine Angebote für Deinen Reisewunsch "{{ $wish->destination }}" für dich finden können. Wir erfüllen Dir jedoch gerne unter folgender Nummer Deine Wünsche <br><a href="tel:089710459535">089-710459535</a>."
                @else
                <h1>Herzlich Wilkommen</h1>"Hallo, wir haben wunderbare Angebote zu deinem Reisewunsch "{{ $wish->destination }}" für dich gefunden. Bei Rückfragen stehen wir gerne auch unter folgender Nummer zur Verfügung: <br><a href="tel:089710459535">089-710459535</a>."
                @endif
            </div>
        </div>
        @if (count($prices) > 0)<div id="map" class="map"></div>@endif

    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <h1 class="offer-header-text">Meine Angebote</h1>
    </div>
</div>

<div class="pagecontainer">
    <div class="row">

        <div class="col-md-12 details-slider">
            <span class="wid">#52280-1</span>
            <div class="c-card c-card-1">
                <div class="card" id="hotel-0">
                    <div class="offer-content">
                        <div class="offer-block offer-block--first">
                            <img src="{{ str_replace('/100/','/600/',$thumbnails[0]) }}" style="width: 100%">
                        </div>
                        <div class="offer-block no-border">


                            <div class="stars hide-mobile">
                                <h3 class="hide-mobile"></h3>

                                @for ($i = 1; $i <= intval($qualities[0]); $i++)
                                    <i class="fa fa-heart"></i>
                                @endfor
                            </div>



                            <span class="location launch-map hide-mobile" data-address=",  Avsallar, TR" lat="36.60976" lng="31.77992">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span>{{ $locations[0] }}</span>
                                            </span>
                            <div class="offer-touroperator hide-mobile">
                                <div class="c-hotel-rating__recommendation" data-key="0" data-toggle="tooltip" data-html="true" data-placement="bottom" data-title="
                                    <div class=&quot;ttp-ctn&quot;>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Allgemein</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;88&quot; style=&quot;width: 88%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.8</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Hotel</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;88&quot; style=&quot;width: 88%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.8</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Zimmer</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;88&quot; style=&quot;width: 88%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.8</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Lage</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;90&quot; style=&quot;width: 90%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>9</p>
                                        </div>
                                    </div>
                                    <div class=&quot;ttp-ctn&quot;>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Sport &amp; Unterhaltung</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;87&quot; style=&quot;width: 87%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.7</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Service</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;89&quot; style=&quot;width: 89%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.9</p>
                                        </div>

                                        <div>
                                            <p class=&quot;review_score_name&quot;>Gastronomie</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;89&quot; style=&quot;width: 89%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.9</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Weiterempfehlung</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;90&quot; style=&quot;width: 90%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>9</p>
                                        </div>
                                    </div><div class=&quot;clearfix&quot;></div>" data-original-title="" title="">
                                    8.8
                                </div>
                                <div class="rating-info">

                                    <span class="text">sehr gut</span>
                                    <span>4899 Bewertungen</span>
                                </div>
                                <!-- <img width="70" src="https://media.traffics-switch.de/vadata/logo/gif/h50/xpur.gif" alt="XPUR" title="XPUR Reisen" class="offer-tourop-logo"> -->
                            </div>

                            <div class="clearfix"></div>

                            <div class="facts-summary">
                                <h5>Highlight der Unterkunft:</h5>
                                        <div class="summary-icon">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <span class="text"></span>
                                        </div>
                                    <div class="summary-icon">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span class="text">Direkt am Strand</span>
                                    </div>
                                    <div class="summary-icon">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span class="text">Strandnah</span>
                                    </div>
                                    <div class="summary-icon">
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <span class="text">Kinderfreundlich</span>
                                    </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="offer-facilities">
                                <div></div>
                            </div>

                        </div>
                                                <div class="price">
                            <div class="offer-action">

                                <div class="left">


                                                                                                                                                                                                    <span class="remaining">
                                                                                                                                                    </span>
                                </div>
                                <div class="right">
                                    <a href="/adetails/offer/5c5d4e7ce4b067a302abeefc/0/" class="price-click-area">

                                        <div class="offer-price">
                                            <div class="price-all">
                                                <div class="js-price-person">
                                                    <span>{{  number_format($prices[0], 0, ',', '.') }}€</span>
                                                    <span class="type">p.P.</span>
                                                </div>
                                                <!--<div class="js-price-total">
                                                    <span>51.564€</span>
                                                    <span class="type">&nbsp;</span>
                                                </div>-->
                                            </div>
                                        </div>
                                        <span class="js-ba-btn btn action-offer">
                                                                    <span class="js-ba-btn-text check-offer offer-action">
                                                                        <i aria-hidden="true" class="fa fa-chevron-right"></i>
                                                                    </span>
                                                                </span>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<div class="pagecontainer">
    <div class="row">

        <div class="col-md-12 details-slider">
            <span class="wid">#52280-1</span>
            <div class="c-card c-card-1">
                <div class="card" id="hotel-0">
                    <div class="offer-content">
                        <div class="offer-block no-border">


                            <div class="stars hide-mobile">
                                <h3 class="hide-mobile"></h3>

                                @for ($i = 1; $i <= intval($qualities[1]); $i++)
                                    <i class="fa fa-heart"></i>
                                @endfor
                            </div>



                            <span class="location launch-map hide-mobile" data-address=",  Avsallar, TR" lat="36.60976" lng="31.77992">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span>{{ $locations[1] }}</span>
                                            </span>
                            <div class="offer-touroperator hide-mobile">
                                <div class="c-hotel-rating__recommendation" data-key="0" data-toggle="tooltip" data-html="true" data-placement="bottom" data-title="
                                    <div class=&quot;ttp-ctn&quot;>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Allgemein</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;88&quot; style=&quot;width: 88%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.8</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Hotel</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;88&quot; style=&quot;width: 88%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.8</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Zimmer</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;88&quot; style=&quot;width: 88%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.8</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Lage</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;90&quot; style=&quot;width: 90%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>9</p>
                                        </div>
                                    </div>
                                    <div class=&quot;ttp-ctn&quot;>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Sport &amp; Unterhaltung</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;87&quot; style=&quot;width: 87%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.7</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Service</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;89&quot; style=&quot;width: 89%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.9</p>
                                        </div>

                                        <div>
                                            <p class=&quot;review_score_name&quot;>Gastronomie</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;89&quot; style=&quot;width: 89%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.9</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Weiterempfehlung</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;90&quot; style=&quot;width: 90%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>9</p>
                                        </div>
                                    </div><div class=&quot;clearfix&quot;></div>" data-original-title="" title="">
                                    8.8
                                </div>
                                <div class="rating-info">

                                    <span class="text">sehr gut</span>
                                    <span>4899 Bewertungen</span>
                                </div>
                                <!-- <img width="70" src="https://media.traffics-switch.de/vadata/logo/gif/h50/xpur.gif" alt="XPUR" title="XPUR Reisen" class="offer-tourop-logo"> -->
                            </div>

                            <div class="clearfix"></div>

                            <div class="facts-summary">
                                <h5>Highlight der Unterkunft:</h5>
                                <div class="summary-icon">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span class="text"></span>
                                </div>
                                <div class="summary-icon">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span class="text">Direkt am Strand</span>
                                </div>
                                <div class="summary-icon">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span class="text">Strandnah</span>
                                </div>
                                <div class="summary-icon">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span class="text">Kinderfreundlich</span>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="offer-facilities">
                                <div></div>
                            </div>

                        </div>
                        <div class="offer-block offer-block--first">
                            <img src="{{ str_replace('/100/','/600/',$thumbnails[1]) }}" style="width: 100%">
                        </div>
                        <div class="price">
                            <div class="offer-action">

                                <div class="left">


                                                                                                                                                                                                    <span class="remaining">
                                                                                                                                                    </span>
                                </div>
                                <div class="right">
                                    <a href="/adetails/offer/5c5d4e7ce4b067a302abeefc/0/" class="price-click-area">

                                        <div class="offer-price">
                                            <div class="price-all">
                                                <div class="js-price-person">
                                                    <span>{{  number_format($prices[1], 0, ',', '.') }}€</span>
                                                    <span class="type">p.P.</span>
                                                </div>
                                                <!--<div class="js-price-total">
                                                    <span>51.564€</span>
                                                    <span class="type">&nbsp;</span>
                                                </div>-->
                                            </div>
                                        </div>
                                        <span class="js-ba-btn btn action-offer">
                                                                    <span class="js-ba-btn-text check-offer offer-action">
                                                                        <i aria-hidden="true" class="fa fa-chevron-right"></i>
                                                                    </span>
                                                                </span>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<div class="pagecontainer">
    <div class="row">

        <div class="col-md-12 details-slider">
            <span class="wid">#52280-1</span>
            <div class="c-card c-card-1">
                <div class="card" id="hotel-0">
                    <div class="offer-content">
                        <div class="offer-block offer-block--first">
                            <img src="{{ str_replace('/100/','/600/',$thumbnails[2]) }}" style="width: 100%">
                        </div>
                        <div class="offer-block no-border">


                            <div class="stars hide-mobile">
                                <h3 class="hide-mobile"></h3>

                                @for ($i = 1; $i <= intval($qualities[2]); $i++)
                                    <i class="fa fa-heart"></i>
                                @endfor
                            </div>



                            <span class="location launch-map hide-mobile" data-address=",  Avsallar, TR" lat="36.60976" lng="31.77992">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span>{{ $locations[2] }}</span>
                                            </span>
                            <div class="offer-touroperator hide-mobile">
                                <div class="c-hotel-rating__recommendation" data-key="0" data-toggle="tooltip" data-html="true" data-placement="bottom" data-title="
                                    <div class=&quot;ttp-ctn&quot;>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Allgemein</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;88&quot; style=&quot;width: 88%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.8</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Hotel</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;88&quot; style=&quot;width: 88%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.8</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Zimmer</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;88&quot; style=&quot;width: 88%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.8</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Lage</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;90&quot; style=&quot;width: 90%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>9</p>
                                        </div>
                                    </div>
                                    <div class=&quot;ttp-ctn&quot;>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Sport &amp; Unterhaltung</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;87&quot; style=&quot;width: 87%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.7</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Service</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;89&quot; style=&quot;width: 89%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.9</p>
                                        </div>

                                        <div>
                                            <p class=&quot;review_score_name&quot;>Gastronomie</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;89&quot; style=&quot;width: 89%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>8.9</p>
                                        </div>
                                        <div>
                                            <p class=&quot;review_score_name&quot;>Weiterempfehlung</p>
                                            <div class=&quot;score_bar&quot;>
                                                <div class=&quot;score_bar_value&quot; data-score=&quot;90&quot; style=&quot;width: 90%;&quot;></div>
                                            </div>

                                            <p class=&quot;review_score_value&quot;>9</p>
                                        </div>
                                    </div><div class=&quot;clearfix&quot;></div>" data-original-title="" title="">
                                    8.8
                                </div>
                                <div class="rating-info">

                                    <span class="text">sehr gut</span>
                                    <span>4899 Bewertungen</span>
                                </div>
                                <!-- <img width="70" src="https://media.traffics-switch.de/vadata/logo/gif/h50/xpur.gif" alt="XPUR" title="XPUR Reisen" class="offer-tourop-logo"> -->
                            </div>

                            <div class="clearfix"></div>

                            <div class="facts-summary">
                                <h5>Highlight der Unterkunft:</h5>
                                <div class="summary-icon">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span class="text"></span>
                                </div>
                                <div class="summary-icon">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span class="text">Direkt am Strand</span>
                                </div>
                                <div class="summary-icon">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span class="text">Strandnah</span>
                                </div>
                                <div class="summary-icon">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                    <span class="text">Kinderfreundlich</span>
                                </div>
                            </div>

                            <div class="clearfix"></div>

                            <div class="offer-facilities">
                                <div></div>
                            </div>

                        </div>
                        <div class="price">
                            <div class="offer-action">

                                <div class="left">


                                                                                                                                                                                                    <span class="remaining">
                                                                                                                                                    </span>
                                </div>
                                <div class="right">
                                    <a href="/adetails/offer/5c5d4e7ce4b067a302abeefc/0/" class="price-click-area">

                                        <div class="offer-price">
                                            <div class="price-all">
                                                <div class="js-price-person">
                                                    <span>{{  number_format($prices[2], 0, ',', '.') }}€</span>
                                                    <span class="type">p.P.</span>
                                                </div>
                                                <!--<div class="js-price-total">
                                                    <span>51.564€</span>
                                                    <span class="type">&nbsp;</span>
                                                </div>-->
                                            </div>
                                        </div>
                                        <span class="js-ba-btn btn action-offer">
                                                                    <span class="js-ba-btn-text check-offer offer-action">
                                                                        <i aria-hidden="true" class="fa fa-chevron-right"></i>
                                                                    </span>
                                                                </span>
                                    </a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
<!-- END OF CONTENT -->
@endsection

@section("after-scripts")
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@endsection