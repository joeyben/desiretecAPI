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
                    <h1>Herzlich willkommen</h1>
                    <h3>Hallo, wir haben wunderbare Angebote zu Ihrem Reiseziel "{{ $wish->destination }}" gefunden. Bei Rückfragen stehen wir gerne auch unter folgender Nummer zur Verfügung: <a href="tel:040238859-82">
                            040 23 88 59-82
                        </a></h3>
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
                                    <h3>Zuständiges Reisebüro</h3>
                                    <h4>Reisebüro desiretec</h4>
                                    <h4>Auf dem Sande 1</h4>
                                    <h4>20457 Hamburg</h4>
                                </div>
                            </div>

                            <div class="agency-contact-info">
                                <ul>
                                    <li class="name">
                                        <i class="fal fa-user-circle"></i>
                                        <h4>Name Ansprechpartner</h4>
                                    </li>
                                    <li class="phone">
                                        <!-- <i class="fal fa-phone-alt"></i> -->
                                        <i class="fas fa-phone"></i>
                                        <h4>089 - 714 595 35</h4>
                                    </li>
                                    <li class="name">
                                        <i class="fal fa-envelope"></i>
                                        <h4>main@reisebuero.de</h4>
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
                                    <h3>{{ $offer['hotel_data']['data']['Hotelname'] }}</h3>
                                    <div class="rating">
                                        @for ($i = 0; $i < intval($offer['hotel_data']['data']['Hotelkategorie']); $i++)
                                            <i class="fas fa-heart"></i>
                                        @endfor
                                    </div>
                                </div>

                                <div class="location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <h5>{{ $offer['hotel_data']['data']['Stadtname'] }}, {{ $offer['hotel_data']['data']['Landname'] }}</h5>
                                </div>

                                <div class="fulfill">
                                    <progress value="{{ $offer['data']['hotel_reviews']['recommendation'] }}" max="100"></progress>
                                    <h4> <span>{{ $offer['data']['hotel_reviews']['recommendation'] }}%</span> Weiterempfehlung</h4>
                                </div>

                                <div class="recommandations">
                                    <div class="average">{{ $offer['data']['hotel_reviews']['overall'] }}</div>
                                    <div class="text">
                                        <h4 class="dark-grey-2">Empfehlenswert</h4>
                                        <h4>{{ $offer['data']['hotel_reviews']['count'] }} Bewertungen</h4>
                                    </div>
                                </div>

                                <div class="highlights">
                                    <h4 class="dark-grey-2">Highlights der Unterkunft:</h4>
                                    <ul>
                                        @for ($i = 0; $i < 3; $i++)
                                        <li>
                                            <i class="fas fa-check"></i>
                                            <h4 class="dark-grey">{{ $offer['data']['hotel_attributes'][$i] }}</h4>
                                        </li>
                                        @endfor
                                    </ul>

                                    <div class="travel-info">
                                        <h4 data-toggle="tooltip" data-placement="bottom" title="{{ $offer['data']['offerFeatures'] }}">{{ $offer['data']['duration'] }} Tage, {{ str_limit($offer['data']['offerFeatures'], 20, "...") }}</h4>
                                    </div>
                                </div>

                                <div class="price">
                                    <div class="info-icons">
                                        <div class="info">
                                            <i class="fal fa-users"></i><div class="info-detail"><div class="up">Familie</div><div class="down"><ul><li>Babybett</li></ul></div></div>
                                        </div>
                                        <div class="info">
                                            <i class="fal fa-concierge-bell"></i></i><div class="info-detail" style="top: -270%;background: white;width: 180px;"><div class="up" style="width: 180px">Hotel Specials</div><div class="down" style="width: 180px"><ul><li>Kostenloses WLAN</li><li>Pool</li></ul></div></div>
                                        </div>
                                        <div class="info">
                                            <i class="fal fa-umbrella-beach"></i><div class="info-detail" style="width: 120px;"><div class="up">Familie</div><div class="down"><ul><li>Sandstrand</li></ul></div></div>
                                        </div>
                                    </div>
                                    <h3>{{ number_format($offer['data']['price']['value'], 0, ',', '.') }} <span>&#8364;</span></h3>
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
