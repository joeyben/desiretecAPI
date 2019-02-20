@extends ('frontend.layouts.app')

@section ('title', trans('labels.backend.wishes.management') . ' | ' . trans('labels.backend.wishes.create'))

@section("after-styles")
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.wishes.management') }}
        <small>{{ trans('labels.backend.wishes.create') }}</small>
    </h1>
@endsection

@section('content')
<!-- CONTENT -->

<p>Ihre Reisewunsch von <strong>{{ $wish->airport }}</strong> nach <strong>{{ $wish->destination }}</strong> für

    <strong>{{ $wish->adults }}</strong>

    <span class="muted">Person</span>
    von {{ $wish->adults }}<strong>{{  \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.Y') }}</strong> bis <strong>{{  \Carbon\Carbon::parse($wish->latest_return)->format('d.m.Y') }}</strong>
    , {{ $wish->duration }} days
    {% endif %}
    mit dem Budget von <strong>{{ kwizz.getModel('price_model').value |number_format(0, ',', '.') }}€</strong>,
    {% for service in kwizz.servicesModels %}
    {% if service.value|length > 0 %}

    {% if service.name == 'hotelcat' %}
    Hotel: {{ service.displayValue.getLabel(app.request.locale)|replace({'*': '<span class="glyphicon glyphicon-star"></span>'})|raw }}
    {% endif %}
    {% endif %}
    {% endfor %}
</p>
{% for key,offer in autoOffers %}

<div class="pagecontainer">
    <div class="row">
        <div class="col-md-12">
            <div class="row">

                <div class="col-md-12 details-slider md-no-padding-right">
                    <div class="c-card">
                        <div id="0" data-hotel="3986" class="card">
                            <div class="c-card__offer-content">
                                <div class="c-card__offer-block c-card__offer-block--first">
                                    {% set pictureArray = [] %}
                                    {% for key,image in offer["fullHotelData"]["hotel"]["catalogData"]["imageList"] %}
                                    {% set pictureUrl = image|replace({'size=180': "size=600"}) %}
                                    {% set pictureArray = pictureArray|merge([pictureUrl]) %}
                                    {% endfor %}
                                    {{ include('CSKwizzmeBundle:Message:carousel_bootstrap.html.twig', {'images': pictureArray, 'attachments': [pictureUrl], 'types': 'offer', 'keyNumber':key,  'details_type':'kwizz'}) }}
                                </div>
                                <div class="c-card__offer-block c-card__offer-block no-border">
                                    <h3>{{ offer["fullHotelData"]["hotel"]["name"] }}
                                        {% for service in kwizz.servicesModels %}
                                        {% if service.value|length > 0 %}

                                        {% if service.name == 'hotelcat' %}
                                        {{ service.displayValue.getLabel(app.request.locale)|replace({'*': '<span class="glyphicon glyphicon-star"></span>'})|raw }}
                                        {% endif %}
                                        {% endif %}
                                        {% endfor %}
                                    </h3>
                                    <div class="c-card__offer-touroperator"><img width="50" src="{{ offer["tourOperator"]['logo'] }}" alt="{{ offer["tourOperator"]['code'] }}" title="{{ offer["tourOperator"]['name'] }}" class="c-card__offer-tourop-logo">
                                    </div>
                                    <div class="c-hotel-rating__recommendation">{{ offer["hotelOffer"]["hotel"]["rating"]['recommendation'] }}%</div>

                                    <span class="location launch-map" lat="{{ offer["fullHotelData"]["hotel"]["location"]["latitude"] }}" lng="{{ offer["fullHotelData"]["hotel"]["location"]["longitude"] }}"><i class="glyphicon glyphicon-globe"></i>{{ offer["fullHotelData"]["hotel"]["location"]["name"] }}, {{ offer["fullHotelData"]["hotel"]["location"]["region"]["name"] }}</span>
                                    <hr class="line-padding"/>
                                <!-- <div class="c-card__offer-headline"><span class="js-offer-duration">{{ offer["travelDate"]['duration'] }}</span>&nbsp;Tage</div>
                                            <div class="c-card__offer-dates">
                                                <span data-value="2018-05-10" class="c-card__offer-dates-from">{{ offer["travelDate"]['fromDate']|date('l, d. M Y') }}</span>
                                                <span class="c-card__offer-dates-divider">-</span>
                                                <span data-value="2018-05-17" class="c-card__offer-dates-to">{{ offer["travelDate"]['toDate']|date('l, d. M Y') }}</span></div> -->

                                    <div class="c-card__offer-headline">
                                        {{ offer["fullHotelData"]["hotel"]["catalogData"]["previewText"] }}
                                    </div>
                                    <div class="c-card__offer-services">
                                        <div class="c-card__offer-icon c-card__offer-icon--room-type">{{ offer["hotelOffer"]['roomType']['name'] }} ({{ offer["hotelOffer"]['roomType']['code'] }})</div>
                                        <div class="c-card__offer-icon c-card__offer-icon--board-type">{{ offer["hotelOffer"]['boardType']['name'] }} ({{ offer["hotelOffer"]['boardType']['code'] }})</div>
                                    </div>

                                    <div class="c-card__offer-facilities">
                                        {% for facility in offer["hotelOffer"]["facilityList"] %}
                                        <div>+ {{ facility }}</div>
                                        {% endfor %}
                                        <div>{{ offer["serviceOffer"]["description"] }}</div>
                                    </div>
                                    <div class="c-card__offer-headline">
                                        <button type="button" class="c-card__offer-tourop-info waves-effect btn-flat" data-toggle="modal" data-target="#hotel-{{ key }}">Hotel Informationen</button>
                                        <div class="clearfix"></div>
                                        <button type="button" class="c-card__offer-tourop-info waves-effect btn-flat" data-toggle="modal" data-target="#flug-{{ key }}">Flug Informationen</button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr class="line-padding"/>
                                    <div class="c-card__facts-summary c-card__facts-summary">
                                        {% for keyword in offer["hotelOffer"]["hotel"]["keywordList"] %}
                                        <i class="c-card__facts-summary-icon has-tooltip" aria-describedby="tooltip_p9r98vylgp">
                                            <span class="{{ keyword }}"></span>
                                        </i>
                                        {% endfor %}
                                    </div>
                                </div>
                            </div>

                            <div class="c-card__price">
                                <div class="c-card__offer-price">
                                    <div class="c-card__offer-price-container">
                                        <span class="c-card__price-person--old"></span>
                                        <span class="c-card__price-person">
                                                        <span class="js-price-person">{{ offer['personPrice']['value']|number_format(0, ',', '.') }}</span> €</span>
                                        <span class="c-card__price-person-extend">p.P.</span>
                                    </div>
                                    <div class="c-card__price-all">Gesamtpreis<span class="js-price-total"> {{ offer['totalPrice']['value']|number_format(0, ',', '.') }}</span> €</div>
                                </div>
                                <div class="c-card__offer-action">
                                    <a href="/adetails/pdfoffer/{{ kwizz.id }}/{{ key }}/"><img src="{{ asset('bundles/cskwizzme/images/pdf.png') }}" width="30" style="margin-right: 10px" /></a>
                                    <span data-textsuccess="Zur Buchung" data-textfail="Ausgebucht" data-card="0" class="js-ba-btn waves-effect btn c-card__action-offer">
                                                    <a href="{{ path('cs_kwizzme_adetails_offer', {id: kwizz.getId(), number: key}) }}" class="js-ba-btn-text">Angebot ansehen</a>
                                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Flug  -->
<div id="flug-{{ key }}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Flugdaten</h4>
            </div>
            <div class="modal-body">
                <div class="c-card__offer-flight js-flight-outbound">
                    {% set outboundLegList = offer["flightOffer"]["flight"]["outboundLegList"] %}
                    {% set estmTime = offer["flightOffer"]["flight"]["outboundEstimatedElapsedTime"] %}
                    {% set outboundLegListCount = outboundLegList|length %}

                    <div class="details-label">
                        Hinflug {{ offer["flightOffer"]["flight"]["outboundLegList"][0]["departureDate"]|date('l, d. M Y') }}
                    </div>
                    Dauer: {{ estmTime }}<br><br>
                    {% for key,flight in outboundLegList %}
                    {{ flight["departureTime"] }} {{ airport_service.getAiportFromCode(flight["departureAirportCode"]) }}  {{ flight["departureAirportCode"] }} <br>
                    <div class="path">{{ flight["flightCarrierName"] }} {{ flight["flightNumber"] }}</div>
                    {{ flight["arrivalTime"] }}   {{ airport_service.getAiportFromCode(flight["arrivalAirportCode"]) }} {{ flight["arrivalAirportCode"] }}<br><br>
                    {% endfor %}
                </div>

                <div class="c-card__offer-flight js-flight-inbound">

                    {% set inboundLegList = offer["flightOffer"]["flight"]["inboundLegList"] %}
                    {% set estmTime = offer["flightOffer"]["flight"]["inboundEstimatedElapsedTime"] %}
                    {% set inboundLegListCount = inboundLegList|length %}

                    <div class="details-label">
                        Rückflug {{ offer["flightOffer"]["flight"]["inboundLegList"][0]["departureDate"]|date('l, d. M Y') }}
                    </div>
                    Dauer: {{ estmTime }}<br><br>
                    {% for key,flight in inboundLegList %}
                    {{ flight["departureTime"] }} {{ airport_service.getAiportFromCode(flight["departureAirportCode"]) }}  {{ flight["departureAirportCode"] }} <br>
                    <div class="path">{{ flight["flightCarrierName"] }} {{ flight["flightNumber"] }}</div>
                    {{ flight["arrivalTime"] }}   {{ airport_service.getAiportFromCode(flight["arrivalAirportCode"]) }} {{ flight["arrivalAirportCode"] }}<br><br>
                    {% endfor %}
                </div>
                <div class="clearfix"></div>
            </div>
            <!--<div class="modal-footer">
            </div>-->
        </div>
    </div>
</div>

<!-- Modal Hotel  -->
<div id="hotel-{{ key }}" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ offer["fullHotelData"]["hotel"]["name"] }}
                    {% for service in kwizz.servicesModels %}
                    {% if service.value|length > 0 %}

                    {% if service.name == 'hotelcat' %}
                    {{ service.displayValue.getLabel(app.request.locale)|replace({'*': '<span class="glyphicon glyphicon-star"></span>'})|raw }}
                    {% endif %}
                    {% endif %}
                    {% endfor %}
                </h4>
            </div>
            <div class="modal-body">
                {{ offer["fullHotelData"]["hotel"]["catalogData"]["html"]| raw }}
            </div>
            <!--<div class="modal-footer">
            </div>-->
        </div>
    </div>
</div>
{% endfor %}
<div id="googleMaps" class="modal fade">
    <div class="modal-dialog maps">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
                <div id="map-canvas"></div>
            </div>
            <!--<div class="modal-footer">
            </div>-->
        </div>
    </div>
</div>

<!-- END OF CONTENT -->
@endsection

@section("after-scripts")
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@endsection