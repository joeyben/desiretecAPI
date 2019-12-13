@extends('frontend.layouts.app')

@section('title')
    {{ ucfirst(getCurrentWhiteLabelName()) }} {{ trans('autooffer.list.tab_title') }}
@endsection

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
                    <h1>{{ trans('autooffer.message.welcome') }}</h1>
                    <h3>
                        @if (count($offers) === 0)
                            {{ trans('autooffer.message.no_offers') }}
                        @else
                            {{ trans('autooffer.message.offers', ['destination' => $wish->destination]) }}
                        @endif
                        {{ trans('autooffer.message.callback') }}
                    </h3>
                    @if (count($offers) > 0)
                        <a class="btn btn-primary" onclick="scrollToAnchor('listed-offers-section')">{{ trans('autooffer.offers.goto_button') }}</a>
                    @endif
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
                                    @if(!(trans('autooffer.contact.company_contact_person') == "autooffer.contact.company_contact_person"))<h3>{{ trans('autooffer.contact.company_contact_person') }}</h3>@endif
                                    @if(!(trans('autooffer.contact.company_name') == "autooffer.contact.company_name"))<h4>{{ trans('autooffer.contact.company_name') }}</h4>@endif
                                    @if(!(trans('autooffer.contact.company_addr') == "autooffer.contact.company_addr"))<h4>{{ trans('autooffer.contact.company_addr') }}</h4>@endif
                                    @if(!(trans('autooffer.contact.company_postal_addr') == "autooffer.contact.company_postal_addr"))<h4>{{ trans('autooffer.contact.company_postal_addr') }}</h4>@endif

                                </div>
                            </div>

                            <div class="agency-contact-info">
                                <ul>
                                    @if(!(trans('autooffer.contact.ansprechpartner') == "autooffer.contact.ansprechpartner"))
                                        <li class="name">
                                            <i class="fal fa-user-circle"></i>
                                            <h4>{{ trans('autooffer.contact.ansprechpartner') }}</h4>
                                        </li>
                                    @endif
                                    @if(!(trans('autooffer.contact.company_telephone') == "autooffer.contact.company_telephone"))
                                        <li class="phone">
                                            <div class="icon-background">
                                                <i class="fal fa-phone" aria-hidden="true"></i>
                                            </div>
                                            <h4>{{ trans('autooffer.contact.company_telephone') }}</h4>
                                        </li>
                                    @endif
                                    @if(!(trans('autooffer.contact.company_email') == "autooffer.contact.company_email"))
                                        <li class="name">
                                            <div class="icon-background">
                                                <i class="fal fa-envelope" aria-hidden="true"></i>
                                            </div>
                                            <h4>{{ trans('autooffer.contact.company_email') }}</h4>
                                        </li>
                                    @endif
                                    @if(!(trans('autooffer.contact.timings') == "autooffer.contact.timings"))
                                        <li class="name">
                                            <div class="icon-background">
                                                <i class="fal fa-clock" aria-hidden="true"></i>
                                            </div>
                                            <h4>{{ trans('autooffer.contact.timings') }}</h4>
                                        </li>
                                    @endif
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
                            $locations = [];
                        @endphp
                        @foreach($offers as $offer)
                            <li class="offer box-shadow">
                                <span class="wish_offer_id">{{ $wish->id }}/{{ $count + 1 }}</span>
                            <div class="left-side">
                                @if ($count === 1)
                                    <div class="label">Unser Tipp</div>
                                @endif
                                <div class="slick-slider">
                                    @if (isset($offer['hotel_data']['data']['Bildfile']) and is_array($offer['hotel_data']['data']['Bildfile']))
                                        @foreach($offer['hotel_data']['data']['Bildfile'] as $image)
                                            <div class="slider-item" style="background-image: url({!! str_replace('180', '600', $image) !!})"></div>
                                        @endforeach
                                    @elseif (isset($offer['hotel_data']['data']['Bildfile']))
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
                                    <div class="average"><?= number_format((int) ($offer['data']['hotelOffer']['hotel']['rating']['overall']) / 10, 1, ',', '.'); ?></div>
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
                                            <i class="fal fa-check"></i>
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

        $(document).ready(function(){
            var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};

            $('.btn-primary').css({
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            });
            $('.btn-secondary').css({
                'background': '#fff',
                'border': '1px solid ' + brandColor,
                'color': brandColor,
            });
            $('.about-section h3 a').css({'color': brandColor});
            $('.listed-offers-section .vertical-line').css({'background-color': brandColor});
            $('.fas.fa-heart, .fal.fa-check, .offers .fulfill span, .fas.fa-map-marker-alt, .offers .slick-slider i').css({'color': brandColor});
            $('.offers .recommandations .average').css({'border-color': brandColor});
            $('head').append('<style> progress::-webkit-progress-value { background: ' + brandColor + ' !important; } </style>');

            if($('.offers .info-icons').length === 0) {
                $('.offers .highlights').css({'padding-bottom': '15px'});
            }
        });

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
            prevArrow: '<div class="btn arrow-left"><i class="fa fa-chevron-left"></i></div>',
            nextArrow: '<div class="btn arrow-right"><i class="fa fa-chevron-right"></i></div>'
        });

    </script>


@endsection
