{{ Form::open(['route' => 'lastminute.store' , 'method' => 'get', 'class' => '', 'role' => 'form', 'files' => true]) }}

<link media="all" type="text/css" rel="stylesheet" href="https://mvp.desiretec.com/fontawsome/css/all.css">

<div class="kwp-minimal">
    <div class="kwp-content kwp-with-expansion">
        <script>
          dt.triggerButton();
        </script>
        <div class="kwp-row">
            <div class="kwp-col-4">
                {{ Form::label('destination', trans('lastminute::layer.general.destination'), ['class' => 'control-label required']) }}
                {{ Form::text('destination', key_exists('destination', $request) ? $request['destination'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('lastminute::layer.placeholder.destination'), 'required' => 'required']) }}
                <i class="fal fa-home"></i>
                @if ($errors->any() && $errors->get('destination'))
                    @foreach ($errors->get('destination') as $error)
                        <span class="error-input">{{ $error }}</span>
                    @endforeach
                @endif
            </div>

            <div class="kwp-col-4">
                {{ Form::label('airport', trans('lastminute::layer.general.airport'), ['class' => 'control-label required']) }}
                {{ Form::text('airport', key_exists('airport', $request) ? $request['airport'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('lastminute::layer.placeholder.airport'), 'required' => 'required']) }}
                @if ($errors->any() && $errors->get('airport'))
                    @foreach ($errors->get('airport') as $error)
                        <span class="error-input">{{ $error }}</span>
                    @endforeach
                @endif
                <i class="fal fa-plane"></i>
                <div class="direktflug " style="margin-top: 5px">
                    {{ Form::checkbox('direkt_flug', null, key_exists('direkt_flug', $request) ? 'true' : null,['class' => 'form-control box-size', 'required' => 'required']) }}
                    <span>Direktflug</span>
                </div>
            </div>

            <div class="kwp-col-4 pax-col main-col" style="margin-top: 10px">
                <div class="kwp-form-group pax-group">
                    <label for="travelers" class="required">Reisende</label>
                    <span class="travelers dd-trigger">
                        <span class="txt">2 Erwachsene</span>
                         <i class="fal fa-users not-triggered"></i>
                         <i class="fal fa-times triggered"></i>
                    </span>
                    <div class="pax-more">
                        <div class="kwp-col-4">
                            {{ Form::label('adults', trans('lastminute::layer.general.adults'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('adults', $adults_arr, key_exists('adults', $request) ? $request['adults'] : 2, ['class' => 'form-control box-size', 'required' => 'required']) }}
                            </div>
                            <i class="fal fa-users"></i>
                        </div>
                        <div class="kwp-col-4" style="position: relative;">
                            {{ Form::label('kids', trans('lastminute::layer.general.kids'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('kids', $kids_arr, key_exists('kids', $request) ? $request['kids'] : null, ['class' => 'form-control box-size']) }}
                            </div>
                            <i class="fal fa-child"></i>
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

            <div class="kwp-col-4 duration-col main-col">
                <div class="kwp-form-group duration-group">
                    <label for="duration-time" class="required">Reisezeitraum/-dauer</label>
                    <span class="duration-time dd-trigger">
                        <span class="txt">15.11.2018 - 17.06.2019</span>
                        <i class="fal fa-calendar-alt not-triggered"></i>
                        <i class="fal fa-times triggered"></i>
                    </span>
                    <div class="duration-more">
                        <div class="kwp-col-4">
                            {{ Form::label('earliest_start', trans('lastminute::layer.general.earliest_start'), ['class' => 'control-label required']) }}
                            {{ Form::text('earliest_start', key_exists('earliest_start', $request) ? $request['earliest_start'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('lastminute::layer.general.earliest_start'), 'required' => 'required']) }}
                            @if ($errors->any() && $errors->get('earliest_start'))
                                @foreach ($errors->get('earliest_start') as $error)
                                    <span class="error-input">{{ $error }}</span>
                                @endforeach

                            @endif
                            <i class="fal fa-calendar-alt"></i>
                        </div>
                        <div class="kwp-col-4">
                            {{ Form::label('latest_return', trans('lastminute::layer.general.latest_return'), ['class' => 'control-label required']) }}
                            {{ Form::text('latest_return', key_exists('latest_return', $request) ? $request['latest_return'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('lstminute::layer.general.latest_return'), 'required' => 'required']) }}
                            @if ($errors->any() && $errors->get('latest_return'))
                                @foreach ($errors->get('latest_return') as $error)
                                    <span class="error-input">{{ $error }}</span>
                                @endforeach
                            @endif
                            <i class="fal fa-calendar-alt"></i>
                        </div>
                        <div class="kwp-col-4">
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

                        <hr>
                        <div class="kwp-col-12 button">
                            <a href="#">OK</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kwp-col-4 pax-col main-col budget">
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

            <div class="kwp-col-4 white-col stars">
                <div class="kwp-form-group">
                    {{ Form::label('category', trans('lastminute::layer.general.category'), ['class' => 'control-label']) }}
                    {{ Form::number('category', key_exists('category', $request) ? $request['category'] : 0, ['class' => 'form-control box-size hidden', 'placeholder' => trans('lastminute::layer.placeholder.category')]) }}

                    <!--span class="text">ab 3 Sterne</span-->
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

            <div class="kwp-col-4 white-col catering">
                {{ Form::label('catering', trans('lastminute::layer.general.catering'), ['class' => 'control-label']) }}
                <div class="kwp-custom-select">
                {{ Form::select('catering', $catering_arr, key_exists('catering', $request) ? $request['catering'] : null,['class' => 'travelerss']) }}
                </div>
                <span class="caret"></span>
            </div>


        </div>
        <div class="kwp-row">
            <div class="kwp-col-time">
                <div class="kwp-row">



                    <div class="kwp-col-4 email-col">
                        {{ Form::label('email', trans('layer.general.email'), ['class' => 'control-label']) }}
                        {{ Form::text('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('lastminute::layer.placeholder.email'), 'required' => 'required']) }}
                        <i class="fal fa-envelope"></i>
                        <div class="kwp-form-email-hint"></div>
                        @if ($errors->any() && $errors->get('email'))
                            @foreach ($errors->get('email') as $error)
                                <span class="error-input">{{ $error }}</span>
                            @endforeach
                        @endif

                        @php
                            $terms_class = 'dt_terms'
                        @endphp

                        @if ($errors->any() && $errors->get('terms'))
                            @php
                                $terms_class = 'dt_terms hasError'
                            @endphp
                        @endif
                    </div>

                    <div class="kwp-col-4 white-col">
                        <div class="kwp-agb">
                            {{ Form::checkbox('terms', null, key_exists('terms', $request) && $request['terms']  ? 'true' : null,['class' => $terms_class, 'required' => 'required']) }}
                            <p>Ich habe die <a href="https://lastminute.reise-wunsch.com/pdfs/tnb_Lastminute.pdf" id="agb_link" target="_blank">Teilnahmebedingungen</a> und <a id="datenschutz" href="https://www.lastminute.ch/datenschutz/" target="_blank">Datenschutzrichtlinien</a> zur Kenntnis genommen und möchte meinen Reisewunsch absenden.</p>
                        </div>
                    </div>

                </div>
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

            $('.kwp-content').animate({ scrollTop: $(this).offset().top - 60}, 500);
          });

          $(".duration-more .button a").click(function(e) {
            e.preventDefault();
            $(this).parents('.duration-col').removeClass('open');
            var from = $("#earliest_start").val();
            var back = $("#latest_return").val();
            var duration = $("#duration option:selected").text();

            $(".duration-time .txt").text(from+" - "+back);
            return false;
          });

          $(".pax-more .button a").click(function(e) {
            e.preventDefault();
            $(this).parents('.pax-col').removeClass('open');
            var pax = $("#adults").val();
            var children_count = parseInt($("#kids").val());
            var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind(er)" : ", "+children_count+" Kind(er)")  : "" ;
            var pets = $("#pets").val() !== "0" ? ", "+$( "#pets option:selected" ).text() : "";
            var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
            $(".travelers .txt").text(pax+" "+erwachsene+""+children+ ""+pets);
            return false;
          });


          $(document).ready(function(){
            dt.startDate = new Pikaday({
              field: document.getElementById('earliest_start'),
              format: 'dd.mm.YYYY',
              defaultDate: '01.01.2019',
              minDate: new Date(),
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
              onSelect: function() {
                validateDuration();
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
            $(".duration-time .txt").text($("#earliest_start").val()+" - "+$("#latest_return").val());
            var $start_date = $("#earliest_start").val().split('.');
            var $end_date = $("#latest_return").val().split('.');

            dt.startDate.setDate($start_date[2]+"."+$start_date[1]+"."+$start_date[0]);
            dt.endDate.setDate($end_date[2]+"."+$end_date[1]+"."+$end_date[0]);

            validateDuration();
            var pax = $("#adults").val();
            var children_count = parseInt($("#kids").val());
            var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind" : ", "+children_count+" Kinder")  : "" ;
            var pets = $("#pets").val() !== "0" ? ", "+$( "#pets option:selected" ).text() : "";
            var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
            $(".travelers .txt").text(pax+" "+erwachsene+" "+children+ ""+pets);

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
            $(".duration-time").on('click',function(){
              validateDuration();
            });
          });

          function check_button(){
            if(!$(".dt-modal .haserrors").length){
              $('.dt-modal #submit-button').removeClass('error-button');
            }
          }

          function validateDuration() {
            var days_diff = (dt.endDate.getDate() - dt.startDate.getDate()) / 60000 / 60 / 24;
            var $element = $('#duration > option');
            $element.attr('disabled',false) ;
            $element.each(function() {
              var $value_arr = $(this).val().split("-");
              var $value = $value_arr.length > 1 && $value_arr[1] ? parseInt($value_arr[1]) : ($value_arr.length > 1 ? parseInt($value_arr[0]) : parseInt($value_arr[0])+1 );

              if($value > days_diff){
                $(this).attr('disabled','disabled');
              }
            });
            if($element.parent().val()) {
              $element.removeAttr('selected').parent().val('');
            }
          }
        </script>

        <div class="kwp-row">
            <div class="kwp-col-4">
                <button id="submit-button" type="submit">Reisewunsch abschicken</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
