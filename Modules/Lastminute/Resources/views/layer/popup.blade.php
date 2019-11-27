<link media="all" type="text/css" rel="stylesheet" href="https://mvp.desiretec.com/fontawsome/css/all.css">

<style type="text/css">
    @media only screen and (max-width: 600px) {
        body {
            background-color: lightblue;
        }
    }
</style>

<script type="application/javascript">
    var brandColor = {!! json_encode($color) !!};
</script>

<div class="kwp-middle">
    Wir helfen Ihnen gerne, Ihre persönlichen Traumferien zu finden.<br> Probieren Sie es jetzt aus!
</div>
{{ Form::open(['route' => 'lastminute.store' , 'method' => 'get', 'class' => '', 'role' => 'form', 'files' => true]) }}

<div class="kwp-minimal">
    <div class="kwp-content kwp-with-expansion">
        <div class="kwp-row">
            <div class="kwp-col-4 destination">
                {{ Form::label('destination', trans('lastminute::layer.general.destination'), ['class' => 'control-label required']) }}
                {{ Form::text('destination', key_exists('destination', $request) ? $request['destination'] : null, ['class' => 'form-control box-size destination','autocomplete' => "off", 'placeholder' => trans('lastminute::layer.placeholder.destination'), 'required' => 'required']) }}
                @if ($errors->any() && $errors->get('destination'))
                    @foreach ($errors->get('destination') as $error)
                        <span class="error-input">{{ $error }}</span>
                    @endforeach
                @endif
                <i class="master-icon--location-fill"></i>
            </div>

            <div class="kwp-col-4">
                {{ Form::label('airport', trans('lastminute::layer.general.airport'), ['class' => 'control-label required']) }}
                {{ Form::text('airport', key_exists('airport', $request) ? $request['airport'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('lastminute::layer.placeholder.airport'), 'required' => 'required']) }}
                @if ($errors->any() && $errors->get('airport'))
                    @foreach ($errors->get('airport') as $error)
                        <span class="error-input">{{ $error }}</span>
                    @endforeach
                @endif
                <i class="master-icon--aircraft-up"></i>
                <div class="direktflug ">
                    {{ Form::checkbox('direkt_flug', null, key_exists('direkt_flug', $request) ? 'true' : null,['class' => 'form-control box-size', 'required' => 'required']) }}
                    <span>Direktflug</span>
                </div>
            </div>

        </div>
        <div class="kwp-row">

            <div class="kwp-col-4 duration-col main-col">
                <div class="kwp-form-group duration-group">
                    <label for="duration-time" class="required">{{ trans('lastminute::layer.general.duration') }}</label>
                    <span class="duration-time dd-trigger">
                        <span class="txt">15.11.2018 - 17.06.2019, 1 Woche</span>
                        <i class="master-icon--calendar-month not-triggered"></i>
                        <i class="master-icon--close triggered"></i>
                    </span>
                    <div class="duration-more">
                        <div class="kwp-col-4">
                            {{ Form::label('earliest_start', trans('lastminute::layer.general.earliest_start'), ['class' => 'control-label required']) }}
                            {{ Form::text('earliest_start', key_exists('earliest_start', $request) ? $request['earliest_start'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('lastminute::layer.general.earliest_start'), 'required' => 'required']) }}
                            @if ($errors->any() && $errors->get('earliest_start'))
                                @foreach ($errors->get('earliest_start') as $error)
                                    <span>{{ $error }}</span>
                                @endforeach

                            @endif
                            <i class="master-icon--calendar-month"></i>
                        </div>
                        <div class="kwp-col-4">
                            {{ Form::label('latest_return', trans('lastminute::layer.general.latest_return'), ['class' => 'control-label required']) }}
                            {{ Form::text('latest_return', key_exists('latest_return', $request) ? $request['latest_return'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('lastminute::layer.general.latest_return'), 'required' => 'required']) }}
                            @if ($errors->any() && $errors->get('latest_return'))
                                @foreach ($errors->get('latest_return') as $error)
                                    <span>{{ $error }}</span>
                                @endforeach
                            @endif
                            <i class="master-icon--calendar-month"></i>
                        </div>
                        <div class="kwp-col-12">
                            {{ Form::label('duration', trans('lastminute::layer.general.duration-more'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('duration', array_merge(['' => trans('lastminute::layer.general.duration_empty')], $duration_arr),key_exists('duration', $request) ? $request['duration'] : null, ['class' => 'form-control box-size']) }}
                                @if ($errors->any() && $errors->get('duration'))
                                    @foreach ($errors->get('duration') as $error)
                                        <span>{{ $error }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <i class="master-icon--time"></i>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="kwp-col-12 button">
                            <a href="#">OK</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kwp-col-4 pax-col main-col">
                <div class="kwp-form-group pax-group">
                    <label for="travelers" class="required">{{ trans('lastminute::layer.general.pax') }}</label>
                    <span class="travelers dd-trigger">
                        <span class="txt">2 Erwachsene</span>
                         <i class="master-icon--user-family not-triggered"></i>
                         <i class="master-icon--close triggered"></i>
                    </span>
                    <div class="pax-more">
                        <div class="kwp-col-12">
                            {{ Form::label('adults', trans('lastminute::layer.general.adults'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('adults', $adults_arr ,key_exists('adults', $request) ? $request['adults'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                @if ($errors->any() && $errors->get('adults'))
                                    @foreach ($errors->get('adults') as $error)
                                        <span>{{ $error }}</span>
                                    @endforeach
                                @endif
                            </div>
                            <i class="master-icon--user-family"></i>
                        </div>
                        <div class="kwp-col-12 kids" style="position: relative;">
                            <div class="kwp-col-12">
                                {{ Form::label('kids', trans('lastminute::layer.general.kids'), ['class' => 'control-label required']) }}
                                <div class="kwp-custom-select">
                                    {{ Form::select('kids', $kids_arr,key_exists('kids', $request) ? $request['kids'] : null, ['class' => 'form-control box-size']) }}
                                    @if ($errors->any() && $errors->get('kids'))
                                        @foreach ($errors->get('kids') as $error)
                                            <span>{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <i class="master-icon--baby"></i>
                            </div>
                            <div class="kwp-col-ages">
                                <div class="kwp-form-group">
                                    <label class="main-label">Alter der Kinder bei Rückreise</label>
                                    <input name="ages" type="hidden">
                                    <div id="age_1" class="kwp-col-3">
                                        <i class="master-icon--aircraft-down"></i>
                                        <div class="kwp-custom-select" style="display: none">
                                            {{ Form::select('ages1', $ages_arr,key_exists('ages1', $request) ? $request['ages1'] : null, ['class' => 'form-control box-size']) }}
                                        </div>
                                    </div>
                                    <div id="age_2" class="kwp-col-3">
                                        <i class="master-icon--aircraft-down"></i>
                                        <div class="kwp-custom-select" style="display: none">
                                            {{ Form::select('ages2', $ages_arr,key_exists('ages2', $request) ? $request['ages2'] : null, ['class' => 'form-control box-size']) }}
                                        </div>
                                    </div>
                                    <div id="age_3" class="kwp-col-3">
                                        <i class="master-icon--aircraft-down"></i>
                                        <div class="kwp-custom-select" style="display: none">
                                            {{ Form::select('ages3', $ages_arr,key_exists('ages3', $request) ? $request['ages3'] : null, ['class' => 'form-control box-size']) }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <script>dt.childrenAges();</script>
                        <hr>
                        <div class="kwp-col-12 button">
                            <a href="#">OK</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="kwp-row">
            <!--div class="kwp-col-3 rangeslider-wrapper">
                <div class="kwp-form-group ">
                    {{ Form::label('budget', trans('lastminute::layer.general.budget'), ['class' => 'control-label required']) }}
                    {{ Form::number('budget', old('budget'), ['class' => 'form-control box-size hidden', 'placeholder' => trans('lastminute::layer.placeholder.budget'), 'required' => 'required']) }}
                </div>
                <span class="text">&nbsp;</span>
                <input type="range" min="100" max="10000" value="50"  step="50" id="budgetRange">
            </div-->
                <div class="kwp-col-3 pax-col main-col budget">
                    <div class="kwp-form-group pax-group">
                        <label for="budget" class="required">{{ trans('lastminute::layer.general.budget') }}</label>
                        <span class="travelerss">
                            <span class="caret"></span>
                        <div class="kwp-custom-select">
                                    {{ Form::select('budget', $budget_arr , key_exists('budget', $request) ? $request['budget'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                            @if ($errors->any() && $errors->get('budget'))
                                @foreach ($errors->get('budget') as $error)
                                    <span>{{ $error }}</span>
                                @endforeach
                            @endif
                        </div>
                         <i class="master-icon--user-family not-triggered"></i>
                         <i class="master-icon--close triggered"></i>
                        </span>
                        <!--div class="budget-more">
                            <div class="kwp-col-12">
                                <div class="kwp-custom-select">
                                    {{ Form::select('budget', $budget_arr , null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                    @if ($errors->any() && $errors->get('budget'))
                                        @foreach ($errors->get('budget') as $error)
                                            <span>{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <i class="master-icon--user-family"></i>
                            </div>
                            <hr>
                            <div class="kwp-col-12 button">
                                <a href="#">OK</a>
                            </div>
                        </div-->
                    </div>
                </div>

            <div class="kwp-col-3 white-col stars">
                <div class="kwp-form-group">
                    {{ Form::label('category', trans('lastminute::layer.general.category'), ['class' => 'control-label']) }}
                    {{ Form::number('category', key_exists('category', $request) ? $request['category'] : null, ['class' => 'form-control box-size hidden', 'placeholder' => trans('lastminute::layer.placeholder.category')]) }}

                    <span class="text">ab 3 Sterne</span>
                    <div class="kwp-star-input">
                        <span class="fas fa-star" data-val="1"></span>
                        <span class="fas fa-star" data-val="2"></span>
                        <span class="fas fa-star" data-val="3"></span>
                        <span class="fal fa-star" data-val="4"></span>
                        <span class="fal fa-star" data-val="5"></span>
                    </div>
                    <script>dt.hotelStars();</script>
                </div>
            </div>

            <div class="kwp-col-3 white-col catering">
                {{ Form::label('catering', trans('lastminute::layer.general.catering'), ['class' => 'control-label']) }}
                <div class="kwp-custom-select">
                    {{ Form::select('catering', $catering_arr, key_exists('catering', $request) ? $request['catering'] : null,['class' => 'form-control box-size']) }}
                </div>
                <span class="caret"></span>
            </div>

        </div>

        <!--div class="kwp-row">
            <div class="kwp-col-12 description">
                {{ Form::label('description', trans('lastminute::layer.general.description'), ['class' => 'control-label required']) }}
                {{ Form::textarea('description', null,['class' => 'form-control', 'placeholder' => trans('lastminute::layer.placeholder.description')]) }}
                <i class="master-icon--calendar-month"></i>
            </div>
        </div-->

        <div class="kwp-row" style="margin-top: 10px">
            <div class="kwp-col-4 email-col">
                {{ Form::label('email', trans('lastminute::layer.general.email'), ['class' => 'control-label']) }}
                {{ Form::text('email', key_exists('email', $request) ? $request['email'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('lastminute::layer.placeholder.email'), 'required' => 'required']) }}
                <i class="master-icon--mail"></i>
                <div class="kwp-form-email-hint"></div>
                @if ($errors->any() && $errors->get('email'))
                    @foreach ($errors->get('email') as $error)
                        <span class="error-input">{{ $error }}</span>
                    @endforeach
                @endif
            </div>
            <div class="kwp-col-4 white-col">
                <button id="submit-button" type="submit" class="primary-btn">Reisewunsch abschicken</button>
            </div>


        </div>

    </div>


    <div class="kwp-footer">
        <script>
            $('.kwp-btn-expand').click(function(e) {
                e.preventDefault();
                $(this).toggleClass('kwp-open');
                $('.kwp-content-extra').toggleClass('kwp-collapsed');
                //$('.kwp-content-extra').stop().slideToggle();
                return false;
            });

            $(".dd-trigger").click(function(e) {
                if(!$(this).parents('.main-col').hasClass('open')){
                    $('.main-col').removeClass('open')
                    $(this).parents('.main-col').addClass('open');
                }else
                    $(this).parents('.main-col').removeClass('open');

                $('.kwp-content').animate({ scrollTop: $(this).offset().top}, 500);
            });

            $(".duration-more .button a").click(function(e) {
                e.preventDefault();
                $(this).parents('.duration-col').removeClass('open');
                var from = $("#earliest_start").val();
                var back = $("#latest_return").val();
                var duration = $("#duration option:selected").text();

                $(".duration-time .txt").text(from+" - "+back+", "+duration);
                return false;
            });

            $(".pax-more .button a").click(function(e) {
                e.preventDefault();
                $(this).parents('.pax-col').removeClass('open');
                var pax = $("#adults").val();
                var children_count = parseInt($("#kids").val());
                var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind" : ", "+children_count+" Kinder")  : "" ;

                var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
                $(".travelers .txt").text(pax+" "+erwachsene+" "+children);
                return false;
            });

            $(".budget-more .button a").click(function(e) {
              e.preventDefault();
              $(this).parents('.budget').removeClass('open');
              var pax = $("select[name='budget']").val();
                $(".pax-col.budget .txt").text(pax + " CHF");
              return false;
            });

            $('#budgetRange').rangeslider({
                // Callback function
                polyfill: false,
                onInit: function() {
                    $('.rangeslider__handle').on('mousedown touchstart mousemove touchmove', function(e) {
                        e.preventDefault();
                    })
                },
                fillClass: 'rangeslider__fill',
                onSlide: function(position, value) {
                    if($(".rangeslider-wrapper .haserrors").length)
                        $(".rangeslider-wrapper .haserrors").removeClass('haserrors');

                    if(value === 10000){
                        $(".rangeslider-wrapper .text").text("beliebig");
                        $("#budget").val("beliebig");
                    }else if(value === 100){
                        $(".rangeslider-wrapper .text").html("&nbsp;");
                        $("#budget").val("");
                    }else{
                        $(".rangeslider-wrapper .text").text("bis "+value+" €");
                        $("#budget").val(""+value);
                    }
                    check_button();
                },
            });



            $(document).ready(function(){
                autocomplete();
              var options = $('#duration option' );
              $( options[ 11 ] ).insertAfter( $( options[ 33 ] ) );
                dt.childrenAges();

                //$('.selectpicker').selectpicker();

                dt.startDate = new Pikaday({
                    field: document.getElementById('earliest_start'),
                    format: 'dd.mm.YYYY',
                    defaultDate: '01.01.2019',
                    firstDay: 1,
                    minDate: new Date(),

                    toString: function(date, format) {
                        // you should do formatting based on the passed format,
                        // but we will just return 'D/M/YYYY' for simplicity
                        const day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
                        const month = (date.getMonth() + 1) < 10 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
                        const year = date.getFullYear();
                        return day+"."+month+"."+year;
                    },
                    i18n: {
                        previousMonth: 'Vormonat',
                        nextMonth: 'Nächsten Monat',
                        months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                        weekdays: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
                        weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa']
                    },
                    onSelect: function() {
                        dt.endDate.setDate(this.getDate()+1);
                        dt.endDate.setMinDate(this.getDate());
                    },
                    onOpen: function() {

                    },
                });
                dt.endDate = new Pikaday({
                    field: document.getElementById('latest_return'),
                    format: 'dd.mm.YYYY',
                    defaultDate: '01.01.2019',
                    firstDay: 1,
                    toString: function(date, format) {
                        // you should do formatting based on the passed format,
                        // but we will just return 'D/M/YYYY' for simplicity
                        const day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate();
                        const month = (date.getMonth() + 1) < 10 ? "0" + (date.getMonth() + 1) : (date.getMonth() + 1);
                        const year = date.getFullYear();
                        return day+"."+month+"."+year;
                    },
                    i18n: {
                        previousMonth: 'Vormonat',
                        nextMonth: 'Nächsten Monat',
                        months: ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                        weekdays: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
                        weekdaysShort: ['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa']
                    }
                });

                if(!$("#earliest_start").val()){
                    var date = new Date();
                    date.setDate(date.getDate() + 3);
                    var d = date.getDate();
                    var m = date.getMonth()+1;
                    var y = date.getFullYear();
                    if (d < 10) {
                        d = "0" + d;
                    }
                    if (m < 10) {
                        m = "0" + m;
                    }
                    $("#earliest_start").val(d+"."+m+"."+y);
                }

                if(!$("#latest_return").val()){
                    var date = new Date();
                    date.setDate(date.getDate() + 10);
                    var d = date.getDate();
                    var m = date.getMonth()+1;
                    var y = date.getFullYear();
                    if (d < 10) {
                        d = "0" + d;
                    }
                    if (m < 10) {
                        m = "0" + m;
                    }
                    $("#latest_return").val(d+"."+m+"."+y);
                }

                var range = parseInt($("#budget").val().replace('.',''));
                if(range)
                    $('input[type="range"]').val(range).change();

                $(".duration-time .txt").text($("#earliest_start").val()+" - "+$("#latest_return").val()+", "+$("#duration option:selected").text());
                var pax = $("#adults").val();
                var children_count = parseInt($("#kids").val());
                var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind" : ", "+children_count+" Kinder")  : "" ;
                var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
                $(".travelers .txt").text(pax+" "+erwachsene+" "+children);

                if($(".dt-modal .haserrors").length){
                    $('.dt-modal #submit-button').addClass('error-button');
                }

                if($(".duration-more .haserrors").length){
                    $('.duration-group').addClass('haserrors');
                }

                $( ".haserrors input" ).keydown(function( event ) {
                    $(this).parents('.haserrors').removeClass('haserrors');
                    check_button();
                });
                $('.haserrors input[type="checkbox"]').change(function () {
                    $(this).parents('.haserrors').removeClass('haserrors');
                    check_button();
                });
            });

            function check_button(){
                if(!$(".dt-modal .haserrors").length){
                    $('.dt-modal #submit-button').removeClass('error-button');
                }
            }

            /**
             * Autocomplete
             */
            function autocomplete(){

                $.get('getTTRegions', function(data){
                    $("#destination").typeahead({
                        autoSelect: true,
                        minLength: 3,
                        delay: 200,
                        source: data
                    });
                });

                /* END Destinations */

                /* Airports */
                $.get('get-all-airports', function(data){
                    $("#airport").typeahead({
                        autoSelect: true,
                        minLength: 3,
                        delay: 200,
                        source: data
                    });
                });
                /* END Airports */

            }

            dt.applyBrandColor();

        </script>

        <div class="kwp-row">
            <div class="kwp-col-12 white-col">
                <div class="kwp-agb ">
                    @php
                        $terms_class = 'dt_terms'
                    @endphp

                    @if ($errors->any() && $errors->get('terms'))
                        @php
                            $terms_class = 'dt_terms hasError'
                        @endphp
                    @endif

                    {{ Form::checkbox('terms', null, key_exists('terms', $request) && $request['terms']  ? 'true' : null,['class' => $terms_class, 'required' => 'required']) }}
                    <p>Ich habe die <a href="https://lastminute.reise-wunsch.com/pdfs/tnb_Lastminute.pdf" id="agb_link" target="_blank">Teilnahmebedingungen</a> und <a id="datenschutz" href="https://www.lastminute.ch/datenschutz/" target="_blank">Datenschutzrichtlinien</a> zur Kenntnis genommen und möchte meinen Reisewunsch absenden.</p>

                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
