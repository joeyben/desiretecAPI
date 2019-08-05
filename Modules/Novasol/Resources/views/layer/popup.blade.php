<link media="all" type="text/css" rel="stylesheet" href="https://mvpprod.desiretec.com/fontawsome/css/all.css">

{{ Form::open(['route' => 'novasol.store' , 'method' => 'get', 'class' => '', 'role' => 'form', 'files' => true]) }}

<div class="kwp-minimal">
    <div class="kwp-content kwp-with-expansion">
        <div class="kwp-row">
            <div class="kwp-col-4 destination">
                {{ Form::label('destination', trans('layer.general.destination'), ['class' => 'control-label required']) }}
                {{ Form::text('destination',  key_exists('destination', $request) ? $request['destination'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('layer.placeholder.destination'), 'required' => 'required']) }}
                @if ($errors->any() && $errors->get('destination'))
                    @foreach ($errors->get('destination') as $error)
                        <span class="error-input">{{ $error }}</span>
                    @endforeach
                @endif
                <i class="fal fa-home"></i>
            </div>

            <div class="kwp-col-4 pax-col main-col">
                <div class="kwp-form-group pax-group">
                    <label for="travelers" class="required">Wer reist mit?</label>
                    <span class="travelers dd-trigger">
                        <span class="txt">2 Erwachsener</span>
                         <i class="fal fa-users not-triggered"></i>
                         <i class="fal fa-times triggered"></i>
                    </span>
                    <div class="pax-more">
                        <div class="kwp-col-12">
                            {{ Form::label('adults', trans('layer.general.adults'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('adults', $adults_arr, key_exists('adults', $request) ? $request['adults'] : 2, ['class' => 'form-control box-size', 'required' => 'required']) }}
                            </div>
                            <i class="fal fa-users"></i>
                        </div>
                        <div class="kwp-col-12 kids" style="position: relative;">
                            <div class="kwp-col-12">
                                {{ Form::label('kids', trans('layer.general.kids'), ['class' => 'control-label required']) }}
                                <div class="kwp-custom-select">
                                    {{ Form::select('kids', $kids_arr, key_exists('kids', $request) ? $request['kids'] : null, ['class' => 'form-control box-size']) }}
                                </div>
                                <i class="fal fa-child"></i>
                            </div>
                        </div>
                        <script>dt.childrenAges();</script>

                        <div class="kwp-col-12">
                            {{ Form::label('pets', trans('layer.general.pets'), ['class' => 'control-label required']) }}
                            <div class="kwp-custom-select">
                                {{ Form::select('pets', $pets_arr, key_exists('pets', $request) ? $request['pets'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                            </div>
                            <i class="fal fa-dog-leashed"></i>
                        </div>

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
                    <label for="duration-time" class="required">Wann & Wie lange?</label>
                    <span class="duration-time dd-trigger">
                        <span class="txt">15.11.2018 - 17.06.2019, 1 Woche</span>
                        <i class="fal fa-calendar-alt not-triggered"></i>
                        <i class="fal fa-times triggered"></i>
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
                            <i class="fal fa-calendar-alt"></i>
                        </div>
                        <div class="kwp-col-4">
                            {{ Form::label('latest_return', trans('layer.general.latest_return'), ['class' => 'control-label required']) }}
                            {{ Form::text('latest_return', key_exists('latest_return', $request) ? $request['latest_return'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('layer.general.latest_return'), 'required' => 'required']) }}
                            @if ($errors->any() && $errors->get('latest_return'))
                                @foreach ($errors->get('latest_return') as $error)
                                    <span class="error-input">{{ $error }}</span>
                                @endforeach
                            @endif
                            <i class="fal fa-calendar-alt"></i>
                        </div>
                        <hr>
                        <div class="kwp-col-12 button">
                            <a href="#">OK</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="kwp-col-4 destination">
                <div class="kwp-form-group ">
                    {{ Form::label('budget', trans('layer.general.budget'), ['class' => 'control-label required']) }}
                    {{ Form::number('budget', key_exists('budget', $request) ? $request['budget'] : null, ['class' => 'form-control box-size', 'placeholder' => trans('layer.placeholder.budget'), 'required' => 'required', 'min' => '1', 'oninput' => 'validity.valid||(value="");']) }}
                    <i class="fal fa-euro-sign"></i>
                    @if ($errors->any() && $errors->get('budget'))
                        @foreach ($errors->get('budget') as $error)
                            <span class="error-input">{{ $error }}</span>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>


    <!--div class="kwp-row">
            <div class="kwp-col-12 description">
                {{ Form::label('description', trans('layer.general.description'), ['class' => 'control-label required']) }}
    {{ Form::textarea('description', key_exists('description', $request) ? $request['description'] : null,['class' => 'form-control', 'placeholder' => trans('layer.placeholder.description')]) }}
            <i class="fal fa-comment-alt-lines"></i>
        </div>
    </div-->

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
                weekdays: ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'],
                weekdaysShort: ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So']
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
                weekdays: ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'],
                weekdaysShort: ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So']
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



            $(".duration-time .txt").text($("#earliest_start").val()+" - "+$("#latest_return").val()+", "+$("#duration option:selected").text());
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
          });
          function check_button(){
            if(!$(".dt-modal .haserrors").length){
              $('.dt-modal #submit-button').removeClass('error-button');
            }
          }

          function validateDuration() {
            if($("#duration").val()){
              return false;
            }
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
                    <p>Ich habe die <a href="/pdfs/tnb_NOVASOL.pdf" id="agb_link" target="_blank">Teilnahmebedingungen</a> und <a id="datenschutz" href="https://www.novasol.de/faq/novasol_agb_deutsch/datenschutz" target="_blank">Datenschutzrichtlinien</a> zur Kenntnis genommen und möchte meinen Reisewunsch absenden.</p>

                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}
