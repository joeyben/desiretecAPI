@extends ('frontend.layouts.app')

@section ('title', trans('labels.backend.wishes.management') . ' | ' . trans('labels.backend.wishes.create'))

@section("after-styles")
    <link rel="stylesheet" href="{{ mix('modules/css/offers.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/css/ol.css" type="text/css">
    <link rel="stylesheet" href="https://www.novasol.de/sites/default/files/css/css_RdqOJMi-95FkFFYtCUoiTVu4aRX71KCrO5kv8_IA5Vw.css?pvlm34" type="text/css">
    <style>
      .map {
        height: 400px;
        width: 100%;
      }
      .c-hotel-rating__recommendation{
          border: 3px solid #f96500 !important;
      }
      .action-offer i{
          background: #61BA01 !important;
      }
      .facts-summary .summary-icon i{
          color: #ed1c23 !important;
      }
      .offer-block .stars i{
          color: #ffdd00 !important;
      }
      .price{
          background: initial !important;
      }
        .seller-image .img{
            border-radius: 0 !important;
        }
        footer{
            background: initial !important;
        }
      .footer ul li a {
          color: #FFF !important;
      }
        @media (max-width: 1280px) {
            .top-container .top-panels {
                height: 330px !important;
            }
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
                <i class="fa fa-plus" aria-hidden="true" onclick="open_wish()"></i>
                <i class="fa fa-minus" aria-hidden="true" onclick="close_wish()"></i>
            </i>
        </div>
        <ul class="wish-list">
            <li style="display: none">
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
                <span class="bottom"
                      data-toggle="tooltip"
                      data-html="true"
                      data-placement="bottom"
                      data-title="{{ $wish->adults }}">
                    {{ $wish->adults }}
                </span>
            </li>

            <li>
                <span class="top"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                <span class="bottom">{{ $wish->budget }}€</span>
            </li>

            <li style="display: none;">
                <span class="top">
                    <i class="fa fa-clock-o" aria-hidden="true"></i></span>
                <span class="bottom">
                    {{ $wish->duration }}/Tage
                </span>
            </li>

            <li style="display: none">
                <span class="top"><i class="fa fa-bed" aria-hidden="true"></i></span>
                <span class="bottom">
                        Hotel: {{ $wish->category }}
                            </span>
            </li>

            <li style="display: none;">
                <span class="top"><i class="fa fa-h-square" aria-hidden="true"></i></span>
                <span class="bottom">{{ $wish->catering }}</span>
            </li>

        </ul>
    </div>

    <div class="top-panels">
        <div class="seller">
            <div class="seller-image">
                @if(isset($logo) and !is_null($logo))
                    <span class="img"
                          style="background-image: url({{ $logo }});">
                    </span>
                @else
                    <span class="img"
                          style="background-image: url('https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/logo/1565014951novasol.png');">
                    </span>
                @endif
            </div>
            <div class="seller-name">
                <img class="img" src="/whitelabel/novasol/images/layer/Sabine_Buchungsservice.jpg" style="width: 113px;border-radius: 27px">
            </div>
            <div class="seller-message">
                @if (count($autooffers) === 0)
                    "Leider haben wir noch keine Angebote für Deinen Reisewunsch"
                    {{ $wish->destination }}
                    " für dich finden können. Wir erfüllen Dir jedoch gerne unter folgender Nummer Deine Wünsche
                    <br>
                    <a href="tel:040238859-82">
                        040 23 88 59-82
                    </a>."
                @else
                <h1>Herzlich willkommen</h1>
                    "Hallo, wir haben wunderbare Angebote zu deinem Reisewunsch "{{ $wish->destination }}" für dich gefunden.
                    Bei Rückfragen stehen wir gerne auch unter folgender Nummer zur Verfügung:
                    <br>
                    <a href="tel:040238859-82">
                        040 23 88 59-82
                    </a>."
                @endif
            </div>
        </div>

        @if (count($autooffers) > 0)
            <div id="map" class="map"></div>
        @endif

    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <h1 class="offer-header-text">Meine Angebote</h1>
    </div>
</div>
    @foreach($autooffers as $offer)
        <div class="pagecontainer">
            <div class="row">
                <div class="col-md-12 details-slider">
                    <span class="wid">Objekt-Nr: {{ $offer->hotel_code }}</span>
                    <div class="c-card c-card-1">
                        <div class="card" id="hotel-0">
                            <div class="offer-content">
                                <div class="offer-block offer-block--first">
                                    <img src="{{ $offer->thumbnail }}" style="width: 100%">
                                </div>
                                <div class="offer-block no-border">
                                    <div class="stars hide-mobile">
                                        <h3 class="hide-mobile"></h3>
                                        @for ($i = 1; $i <= intval($offer->tourOperator_code); $i++)
                                            <img src="https://www.novasol.de/themes/custom/solar_theme/images/icon-star--novasol-yellow.svg"
                                                 style="height: 20px;"
                                                 alt="">
                                        @endfor

                                        @for($i =1; $i <= (5 - $offer->tourOperator_code); $i++)
                                            <img src="https://www.novasol.de/themes/custom/solar_theme/images/icon-star--outline--gray-35.svg"
                                                 style="height: 20px;"
                                                 alt="">
                                        @endfor
                                        <span id="{{$offer->hotel_code}}" class="info-pin" onclick="open_description('{{$offer->hotel_code}}')"></span>
                                    </div>
                                    <div id="b-{{$offer->hotel_code}}" class="beschreibung" style="display: none">BESCHREIBUNG
                                        Diese schöne, gemütliche und helle Ferienwohnung befindet sich in der schönen Ortschaft Montanejos bei Castellón.
                                        Die Wohnung hat eine Kapazität für 6 Personen und verfügt über 3 Schlafzimmer (2 davon mit Ausziehbett für je 2 Personen), 1 Badezimmer und 1 WC. Die Küche ist in das Wohnzimmer mit Essbereich integriert. Nicht nur vom Balkon haben Sie einen fantastischen Blick auf die Berge. Die Einrichtung ist fröhlich und durchdacht. Ihnen steht ein Parkplatz zur Verfügung und 1 Haustier ist erlaubt.
                                        Die ruhige Wohnung liegt außerhalb von Montanejos und ist mit einer Heizung für die kühleren Monate ausgestattet.</div>
                                    <span class="location launch-map hide-mobile" data-address=",  Avsallar, TR" lat="36.60976" lng="31.77992">
                                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span>{{$offer->hotel_name}}, {{$wish->destination}}</span>
                                            </span>
                                    <div class="offer-touroperator hide-mobile" style="display: none">
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
                                        <div class="summary-icon" style="display: none">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <span class="text"></span>
                                        </div>
                                        <div class="summary-icon">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <span class="text">Pool</span>
                                        </div>
                                        <div class="summary-icon">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <span class="text">Internet</span>
                                        </div>
                                        <div class="summary-icon">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <span class="text">Entfernung zum Wasser: #m </span>
                                        </div>
                                        <div class="summary-icon">
                                            <i class="fa fa-check" aria-hidden="true"></i>
                                            <span class="text">Spa </span>
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
                                            {{-- <a href="/adetails/offer/5c5d4e7ce4b067a302abeefc/0/" class="price-click-area"> --}}
                                            <a target="_blank" href="{{ route('autooffer.to-the-offer', $wish->id) }}" class="price-click-area">

                                                <div class="offer-price">
                                                    <div class="price-all">
                                                        <div class="js-price-person">
                                                            <span>{{  number_format($offer->totalPrice, 0, ',', '.') }}€</span>
                                                            <span class="type">Gesamtpreis</span>
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
    @endforeach





@endsection

@section("after-scripts")
    <footer class="footer" role="contentinfo">
        <div class="region region-footer">
            <div class="site-footer site-footer--desktop">
                <div class="site-footer__limiter clearfix">
                    <div class="site-footer__brand"> <img alt="Novasol" src="https://www.novasol.de/themes/custom/solar_theme/images/logo_right--white.svg"></div>
                    <div class="site-footer__info">
                        <div class="site-footer__info-company"> <address class="site-footer__info-company-address">NOVASOL A/S, Virumgårdsvej 27, 2830 Virum - Dänemark</address> <span class="site-footer__info-company-cvr">VAT No. DK17484575</span> <span class="site-footer__info-company-telephone"> <a href="tel://0049(0)40-688715100"> Telefon: 0049 (0)40- 688 71 51 00 </a> </span></div>
                        <div class="site-footer__info-mail"> <span> <a href="mailto:"> </a> </span></div>
                        <div class="site-footer__info-links">
                            <ul class="site-footer__info-links-list">
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/uber-novasol">Über NOVASOL</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/faq/novasol_agb_deutsch/datenschutz">Datenschutz</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/faq/novasol_agb_deutsch/novasol_nutzungsbedingungen">Nutzungsbedingung</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/site/terms/nov/2019/terms-de.pdf">Allgemeine Geschäftsbedingungen</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/uber_novasol/impressum/kontakt">Impressum</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/cookie-politik">Cookie-Politik</a></li>
                            </ul>
                        </div>
                        <div class="site-footer__info-partners">
                            <ul class="site-footer__info-partners-list">
                                <li class="site-footer__info-partners-listitem"> <img src="https://www.novasol.de/sites/default/files/styles/partner_logo/public/2018-04/de_partner_logo_2.png?itok=oy8wzj6u" width="164" height="45" alt="DE partner logos" class="image-style-partner-logo"></li>
                            </ul>
                        </div>
                    </div>
                    <div class="site-footer__inner-wrap">
                        <div class="site-footer__payment">
                            <ul class="site-footer__payment-list">
                                <li class="site-footer__payment-listitem"> <img class="site-footer__payment-icon" src="https://www.novasol.de/themes/custom/solar_theme/images/payment/280cardline.gif" alt="Zahlungsmöglichkeiten"></li>
                            </ul>
                        </div>
                        <div class="site-footer__trustpilot"></div>
                    </div>
                </div>
            </div>
            <div class="site-footer site-footer--mobile">
                <div class="site-footer__limiter clearfix">
                    <div class="site-footer__info">
                        <div class="site-footer__info-company">
                            <div class="site-footer__brand"> <img alt="Novasol" src="https://www.novasol.de/themes/custom/solar_theme/images/logo_right--white.svg"></div> <address class="site-footer__info-company-address"> <a target="_blank" rel="noopener noreferrer" href="https://www.google.com/maps/place/NOVASOL A/S, Virumgårdsvej 27, 2830 Virum - Dänemark"> NOVASOL A/S, NOVASOL A/S, Virumgårdsvej 27, 2830 Virum - Dänemark </a> </address> <span class="site-footer__info-company-cvr">VAT No. DK17484575</span></div>
                        <div class="site-footer__info-buttons">
                            <div class="">
                                <a class="site-footer__info-button site-footer__info-button--faq" href="/faq"> <span>FAQs</span> </a>
                            </div>
                            <div class="">
                                <a class="site-footer__info-button site-footer__info-button--phone" href="tel://0049(0)40-688715100"> <i class="icon"></i><span>0049 (0)40- 688 71 51 00</span> </a> <span class="site-footer__info-openinghours">Mo - Fr 09:00 - 18:00 / Sa 9:00 - 15:00</span></div>
                            <div class="">
                                <a class="site-footer__info-button site-footer__info-button--mail" href="mailto:novasol@novasol.de"> <i class="icon"></i><span>novasol@novasol.de</span> </a>
                            </div>
                        </div>
                        <div class="site-footer__info-links">
                            <ul class="site-footer__info-links-list">
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/uber-novasol">Über NOVASOL</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/faq/novasol_agb_deutsch/datenschutz">Datenschutz</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/faq/novasol_agb_deutsch/novasol_nutzungsbedingungen">Nutzungsbedingung</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/site/terms/nov/2019/terms-de.pdf">Allgemeine Geschäftsbedingungen</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/uber_novasol/impressum/kontakt">Impressum</a></li>
                                <li class="site-footer__info-links-listitem"> <a href="https://www.novasol.de/cookie-politik">Cookie-Politik</a></li>
                            </ul>
                        </div>
                        <div class="site-footer__info-partners">
                            <ul class="site-footer__info-partners-list">
                                <li class="site-footer__info-partners-listitem"> <img src="https://www.novasol.de/sites/default/files/styles/partner_logo/public/2018-04/de_partner_logo_2.png?itok=oy8wzj6u" width="164" height="45" alt="DE partner logos" class="image-style-partner-logo"></li>
                                <li class="site-footer__info-partners-listitem site-footer__info-partners-listitem--payment-icon"> <img class="site-footer__payment-icon" src="/themes/custom/solar_theme/images/payment/280cardline.gif" alt=""></li>
                            </ul>
                        </div>
                    </div>
                    <div class="site-footer__trustpilot"></div>
                </div>
            </div>
        </div>
    </footer>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script type="text/javascript">
      function open_description(id) {
        //document.getElementById("b-"+id).style.display = "block";
        document.getElementById("b-"+ id).classList.toggle("openDesc");
      }
      function open_wish() {
        document.getElementsByClassName("wish-list")[0].style.display = "block";
      }
      function close_wish() {
        document.getElementsByClassName("wish-list")[0].style.display = "none";
      }
      var marker = new ol.Feature({
        geometry: new ol.geom.Point(
          ol.proj.fromLonLat([{{$autooffers[0]->hotel_location_lng}},{{$autooffers[0]->hotel_location_lat}}])
        ),  // Cordinates of New York's Town Hall
      });
      marker.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
          src: 'https://www.novasol.de/themes/custom/solar_theme/images/house-marker-highlight.svg'
        }))
      }));
      var marker1 = new ol.Feature({
        geometry: new ol.geom.Point(
          ol.proj.fromLonLat([{{$autooffers[1]->hotel_location_lng}},{{$autooffers[1]->hotel_location_lat}}])
        ),  // Cordinates of New York's Town Hall
      });
      marker1.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
          src: 'https://www.novasol.de/themes/custom/solar_theme/images/house-marker-highlight.svg'
        }))
      }));
      var marker2 = new ol.Feature({
        geometry: new ol.geom.Point(
          ol.proj.fromLonLat([{{$autooffers[2]->hotel_location_lng}},{{$autooffers[2]->hotel_location_lat}}])
        ),  // Cordinates of New York's Town Hall
      });
      marker2.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
          src: 'https://www.novasol.de/themes/custom/solar_theme/images/house-marker-highlight.svg'
        }))
      }));
      var marker3 = new ol.Feature({
        geometry: new ol.geom.Point(
          ol.proj.fromLonLat([{{$autooffers[3]->hotel_location_lng}},{{$autooffers[3]->hotel_location_lat}}])
        ),  // Cordinates of New York's Town Hall
      });
      marker3.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
          src: 'https://www.novasol.de/themes/custom/solar_theme/images/house-marker-highlight.svg'
        }))
      }));
      var marker4 = new ol.Feature({
        geometry: new ol.geom.Point(
          ol.proj.fromLonLat([{{$autooffers[4]->hotel_location_lng}},{{$autooffers[4]->hotel_location_lat}}])
        ),  // Cordinates of New York's Town Hall
      });
      marker4.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
          src: 'https://www.novasol.de/themes/custom/solar_theme/images/house-marker-highlight.svg'
        }))
      }));

      var vectorSource = new ol.source.Vector({
        features: [marker,marker1,marker2,marker3,marker4]
      });
      var map = new ol.Map({
        target: 'map',
        layers: [
          new ol.layer.Tile({
            source: new ol.source.OSM()
          })
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([{{$autooffers[2]->hotel_location_lng}},{{$autooffers[2]->hotel_location_lat}}]),
          zoom: 5
        })
      });
      var markerVectorLayer = new ol.layer.Vector({
        source: vectorSource,
      });
      map.addLayer(markerVectorLayer);
    </script>
@endsection
