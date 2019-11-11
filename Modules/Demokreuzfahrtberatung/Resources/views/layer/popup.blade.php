<link media="all" type="text/css" rel="stylesheet" href="https://mvp.desiretec.com/fontawsome/css/all.css">

<div class="kwp-middle">
    Bevor Sie diese Seite verlassen, möchte ich Ihnen noch meinen <span style="text-decoration: underline">persönlichen</span> Kreuzfahrt-Service vorstellen. Ich erstelle für jeden Kunden individuelle Kreuzfahrtangebote und berate Sie kostenfrei zu allen Reedereien & Routen weltweit. Probieren Sie es doch einfach mal aus.
    <br>
    Ihr Kreuzfahrtberater – Heiko Wiltfang
</div>
{{ Form::open(['route' => 'master.store' , 'method' => 'get', 'class' => '', 'role' => 'form', 'files' => true]) }}

<div class="kwp-minimal">
    <div class="kwp-content kwp-with-expansion">
        <div class="kwp-row">
            <div class="kwp-col-4 destination">
                {{ Form::label('destination', trans('layer.general.destination'), ['class' => 'control-label required']) }}
                {{ Form::text('destination', key_exists('destination', $request) ? $request['destination'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('layer.placeholder.destination'), 'required' => 'required']) }}
                @if ($errors->any() && $errors->get('destination'))
                        @foreach ($errors->get('destination') as $error)
                            <span class="error-input">{{ $error }}</span>
                        @endforeach
                @endif
                <i class="master-icon--location-fill"></i>
            </div>

            <div class="kwp-col-4 duration-col main-col">
                <div class="kwp-form-group duration-group">
                    <label for="duration-time" class="required">{{ trans('layer.general.duration') }}</label>
                    <span class="duration-time dd-trigger">
                        <span class="txt">15.11.2018 - 17.06.2019, 1 Woche</span>
                        <i class="master-icon--calendar-month not-triggered"></i>
                        <i class="master-icon--close triggered"></i>
                    </span>
                    <div class="duration-more">
                        <div class="kwp-col-4">
                            {{ Form::label('earliest_start', trans('layer.general.earliest_start'), ['class' => 'control-label required']) }}
                            {{ Form::text('earliest_start', key_exists('earliest_start', $request) ? $request['earliest_start'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('layer.general.earliest_start'), 'required' => 'required']) }}
                            @if ($errors->any() && $errors->get('earliest_start'))
                                @foreach ($errors->get('earliest_start') as $error)
                                    <span class="error-input">{{ $error }}</span>
                                @endforeach

                            @endif
                            <i class="master-icon--calendar-month"></i>
                        </div>
                        <div class="kwp-col-4">
                            {{ Form::label('latest_return', trans('layer.general.latest_return'), ['class' => 'control-label required']) }}
                            {{ Form::text('latest_return', key_exists('latest_return', $request) ? $request['latest_return'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('layer.general.latest_return'), 'required' => 'required']) }}
                            @if ($errors->any() && $errors->get('latest_return'))
                                @foreach ($errors->get('latest_return') as $error)
                                    <span class="error-input">{{ $error }}</span>
                                @endforeach
                            @endif
                            <i class="master-icon--calendar-month"></i>
                        </div>
                        <div class="kwp-col-12">
                            {{ Form::label('duration', trans('layer.general.duration'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('duration', array_merge(['' => trans('layer.general.duration_empty')], $duration_arr), key_exists('duration', $request) ? $request['duration'] : null, ['class' => 'form-control box-size']) }}
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

        </div>
        <div class="kwp-row">

            <div class="kwp-col-4 pax-col main-col">
                <div class="kwp-form-group pax-group">
                    <label for="travelers" class="required">{{ trans('whitelabel.layer.general.pax') }}</label>
                    <span class="travelers dd-trigger">
                        <span class="txt">1 Erwachsener</span>
                         <i class="master-icon--user-family not-triggered"></i>
                         <i class="master-icon--close triggered"></i>
                    </span>
                    <div class="pax-more">
                        <div class="kwp-col-12">
                            {{ Form::label('adults', trans('layer.general.adults'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('adults', $adults_arr , key_exists('adults', $request) ? $request['adults'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                            </div>
                            <i class="master-icon--user-family"></i>
                        </div>
                        <div class="kwp-col-12 kids" style="position: relative;">
                            <div class="kwp-col-12">
                                {{ Form::label('kids', trans('layer.general.kids'), ['class' => 'control-label required']) }}
                                <div class="kwp-custom-select">
                                    {{ Form::select('kids', $kids_arr, key_exists('kids', $request) ? $request['kids'] : null, ['class' => 'form-control box-size']) }}
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
            <div class="kwp-col-4 destination">
                    {{ Form::label('klasse', trans('layer.general.klasse'), ['class' => 'control-label required']) }}
                <div class="kwp-custom-select">
                    {{ Form::select('category', $class_arr, key_exists('category', $request) ? $request['category'] : null, ['class' => 'form-control box-size']) }}
                </div>
            </div>
        </div>

        <div class="kwp-row">
            <div class="kwp-col-12 description">
                {{ Form::label('description', trans('layer.general.description'), ['class' => 'control-label required']) }}
                {{ Form::textarea('description', key_exists('description', $request) ? $request['description'] : null,['class' => 'form-control', 'placeholder' => trans('layer.placeholder.description')]) }}
                <i class="master-icon--calendar-month"></i>
            </div>
        </div>

        <div class="kwp-row">
            <div class="kwp-col-4 email-col">
                {{ Form::label('email', trans('layer.general.email'), ['class' => 'control-label']) }}
                {{ Form::text('email', key_exists('email', $request) ? $request['email'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('layer.placeholder.email'), 'required' => 'required']) }}
                <i class="master-icon--mail"></i>
                <div class="kwp-form-email-hint"></div>
                @if ($errors->any() && $errors->get('email'))
                           @foreach ($errors->get('email') as $error)
                                  <span class="error-input">{{ $error }}</span>
                           @endforeach
                @endif
            </div>
            <div class="kwp-col-4 white-col">
                <button id="submit-button" type="submit">Reisewunsch abschicken</button>
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
                $('.selectpicker').selectpicker();

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
                     <p>Ich habe die <a href="https://demokreuzfahrtberatung.reise-wunsch.com/pdfs/tnb_Kreuzfahrtberatung.pdf" id="agb_link" target="_blank">Teilnahmebedingungen</a> und <a id="datenschutz" href="https://www.kreuzfahrtberatung.de/datenschutz.html" target="_blank">Datenschutzrichtlinien</a> zur Kenntnis genommen und möchte meinen Reisewunsch absenden.</p>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
