@extends('frontend.layouts.app')


@section("after-styles")
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.5.5/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.5.5/slick-theme.css" />
@endsection

@section('content')
    <main class="main">
        <div class="shell">

            <div class="wave-image"></div>

            <section class="about-section">
                <div class="shell">
                    <h1>Hallo lieber {{ $logged_in_user->name }}</h1>
                    <!--h3>Hallo, wir haben wunderbare Angebote zu Ihrem Reiseziel "{{ $wish->destination }}" gefunden. Bei Rückfragen stehen wir gerne auch unter folgender Nummer zur Verfügung: <a href="tel:040238859-82">
                            040 23 88 59-82
                        </a></h3-->
                    <h3>wir haben diese wunderbaren Angebote für dich gefunden. Bei Rückfragen stehen wir dir gerne zur Verfügung.</h3>
                    <a class="btn btn-primary" onclick="scrollToAnchor('listed-offers-section')">Angebote ansehen</a>
                </div>
            </section>

            <section class="main-offer-section">
                <div class="shell" id="main-offer-section-shell">
                    <h2>Auf einen Blick</h2>

                    <div class="main-offer">
                        <div class="offer-info">
                            <div class="agency-info">
                                <div class="avatar avatar-circle size-1"></div>
                                <div class="text">
                                    <h3>Wir sind für dich da!</h3>
                                    <h4>Reise-Experten</h4>
                                    <!--h4>Auf dem Sande 1</h4>
                                    <h4>20457 Hamburg</h4-->
                                </div>
                            </div>

                            <div class="agency-contact-info">
                                <ul>
                                    <li class="name">
                                        <h4>Reise-Experten Kontaktdaten: </h4>
                                    </li>
                                    <li class="phone">
                                        <!-- <i class="fal fa-phone-alt"></i> -->
                                        <i class="fas fa-phone"></i>
                                        <h4>0228 - 3875 7256</h4>
                                    </li>
                                    <li class="name">
                                        <i class="fal fa-calendar"></i>
                                        <h4>Mo. - Fr. 08:00 - 17:00 Uhr </h4>
                                    </li>
                                    <li class="name">
                                        <i class="fal fa-envelope"></i>
                                        <h4>reiseanfrage@reise-rebellen.de </h4>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="offer-highlights" id="offer-highlights">
                            <ul>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-home-lg-alt" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->airport }}</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-users" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->adults }} Erwachsene</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="far fa-map-marker-check"></i>
                                    </div>
                                    <h4>{{ $wish->destination }}</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-h-square" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->category }} Sterne</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-credit-card" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->budget }}€</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-bed" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ getCateringFromCode($wish->catering) }}</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fa fa-clock" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{ $wish->duration }}</h4>
                                </li>
                                <li>
                                    <div class="icon-background">
                                        <i class="fas fa-calendar" aria-hidden="true"></i>
                                    </div>
                                    <h4>{{  \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.Y') }} - {{  \Carbon\Carbon::parse($wish->latest_return)->format('d.m.Y') }}</h4>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <!--<div class="map"></div>-->

                    <a class="btn btn-secondary" onclick="showMenu()">Reisewunsch ansehen</a>
                </div>

            </section>

            <section class="listed-offers-section" id="listed-offers-section">
                <div class="shell">
                    <div class="vertical-line"></div>
                    <h1>Meine Angebote</h1>

                    <ul class="offers">
                        @php
                            $count = 0;
                        @endphp
                        @foreach($offers as $offer)
                            <li class="offer box-shadow">
                                <div class="left-side">
                                    @if ($count === 1)
                                        <div class="label">Unser Tipp</div>
                                    @endif
                                    <div class="slick-slider">
                                        <!-- TODO: Add images and style them -->
                                        @if (is_array($offer['hotel_data']['data']['Bildfile']))
                                            @foreach($offer['hotel_data']['data']['Bildfile'] as $image)
                                                <div class="slider-item" style="background-image: url({!! str_replace('180', '600', $image) !!})"></div>
                                            @endforeach
                                        @else
                                            <div class="slider-item" style="background-image: url({!! str_replace('180', '600', $offer['hotel_data']['data']['Bildfile']) !!})"></div>
                                        @endif
                                    </div>
                                </div>
                                <div class="right-side">
                                    <div class="title">
                                        <h3>{{ $offer['data']['hotelOffer']['hotel']['name'] }}</h3>
                                        <div class="rating">
                                            @for ($i = 0; $i < intval($offer['data']['hotelOffer']['hotel']['category']); $i++)
                                                <i class="fas fa-heart"></i>
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <h5>{{ $offer['hotel_data']['data']['Stadtname'] }}, {{ $offer['hotel_data']['data']['Landname'] }}</h5>
                                    </div>

                                    <div class="fulfill">
                                        <progress value="{{ $offer['data']['hotelOffer']['hotel']['rating']['recommendation'] }}" max="100"></progress>
                                        <h4> <span>{{ $offer['data']['hotelOffer']['hotel']['rating']['recommendation'] }}%</span> Weiterempfehlung</h4>
                                    </div>

                                    <div class="recommandations">
                                        <div class="average"><?= number_format(intval($offer['data']['hotelOffer']['hotel']['rating']['overall']) / 10, 1 , ',', '.') ?></div>
                                        <div class="text">
                                            <h4 class="dark-grey-2">Empfehlenswert</h4>
                                            <h4>{{ $offer['data']['hotelOffer']['hotel']['rating']['count'] }} Bewertungen</h4>
                                        </div>
                                    </div>

                                    <div class="highlights">
                                        <h4 class="dark-grey-2">Highlights der Unterkunft:</h4>
                                        <ul>
                                            @for ($i = 0; $i < 3; $i++)
                                                <li>
                                                    <i class="fas fa-check"></i>
                                                    <h4 class="dark-grey">{{ getKeywordText($offer['data']['hotelOffer']['hotel']['keywordList'][$i]) }}</h4>
                                                </li>
                                            @endfor
                                        </ul>

                                        <div class="travel-info">
                                            <h4 data-toggle="tooltip" data-placement="bottom" title="{{ $offer['data']['serviceOffer']['description'] }}">{{ $offer['data']['travelDate']['duration'] }} Tage, {{ str_limit($offer['data']['serviceOffer']['description'], 20, "...") }}</h4>
                                        </div>
                                    </div>

                                    <div class="price">
                                        <h3>{{ number_format($offer['data']['totalPrice']['value'], 0, ',', '.') }} <span>&#8364;</span></h3>
                                        <a class="btn btn-primary" href="{{ route('autooffer.details', [$wish->id, $count]) }}">
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </div>

                                </div>
                            </li>
                            @php
                                $count++;
                            @endphp
                        @endforeach

                    </ul>
                </div>
            </section>

        </div>
    </main>
@endsection

@section('after-scripts')

    <!-- jquery -->
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <!-- sllick slider -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.5.5/slick.min.js"></script>


    <script type="application/javascript">

      $(function () {
        $('[data-toggle="tooltip"]').tooltip()
      })

      function scrollToAnchor(id) {
        $('html, body').animate({
          scrollTop: $("#"+id).offset().top - 75
        }, 1000);
      }

      function showMenu() {
        $('#offer-highlights').detach().appendTo('#main-offer-section-shell');
        $('#offer-highlights').css('height', '180px');
        $('#offer-highlights').toggle();

        // TODO: Fix animation
        // $('#offer-highlights').animate({
        //     height: '180px'
        // }, 500);
      }

      $('.slick-slider').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 1,
        prevArrow: '<div class="btn btn-primary arrow-left"><i class="fa fa-chevron-left"></i></div>',
        nextArrow: '<div class="btn btn-primary arrow-right"><i class="fa fa-chevron-right"></i></div>'
      });

    </script>
@endsection
