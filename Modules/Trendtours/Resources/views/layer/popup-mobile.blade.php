{{ Form::open(['route' => 'master.store' , 'method' => 'get', 'class' => '', 'role' => 'form', 'files' => true]) }}


<div class="kwp-minimal">
    <div class="kwp-content kwp-with-expansion">
        <script>
            dt.triggerButton();
        </script>
        <div class="kwp-row">
            <div class="kwp-col-4">
                {{ Form::label('destination', trans('layer.general.destination'), ['class' => 'control-label required']) }}
                {{ Form::text('destination', key_exists('destination', $request) ? $request['destination'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('layer.placeholder.destination'), 'required' => 'required']) }}
                <i class="fal fa-globe-europe"></i>
                @if ($errors->any() && $errors->get('destination'))
                    @foreach ($errors->get('destination') as $error)
                        <span class="error-input">{{ $error }}</span>
                    @endforeach
                @endif
            </div>

            <div class="kwp-col-4">
                {{ Form::label('airport', trans('layer.general.airport'), ['class' => 'control-label required']) }}
                {{ Form::text('airport', key_exists('airport', $request) ? $request['airport'] : null, ['class' => 'form-control box-size','autocomplete' => "off", 'placeholder' => trans('layer.placeholder.airport'), 'required' => 'required']) }}
                <i class="fal fa-home"></i>
                @if ($errors->any() && $errors->get('airport'))
                    @foreach ($errors->get('airport') as $error)
                        <span class="error-input">{{ $error }}</span>
                    @endforeach
                @endif
            </div>

            <div class="kwp-col-4 duration-col main-col">
                <div class="kwp-form-group duration-group">
                    <label for="duration-time" class="required">{{ trans('layer.general.when') }}</label>
                    <div class="kwp-custom-select">
                        {{ Form::select('earliest_start', array_merge(['' => trans('layer.general.months_empty')], $months_arr), key_exists('earliest_start', $request) ? $request['earliest_start'] : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                    </div>
                    <i class="fal fa-calendar-alt"></i>
                    @if ($errors->any() && $errors->get('earliest_start'))
                        @foreach ($errors->get('earliest_start') as $error)
                            <span class="error-input">{{ $error }}</span>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="kwp-col-4 pax-col main-col">
                <div class="kwp-form-group pax-group">
                    <label for="travelers" class="required">{{ trans('layer.general.with_whom') }}</label>
                    <div class="kwp-custom-select">
                        {{ Form::select('adults', $adults_arr , ['class' => 'form-control box-size', 'required' => 'required']) }}
                    </div>
                    <i class="fal fa-users"></i>
                </div>
            </div>


        </div>

        <div class="kwp-row">
            <div class="kwp-col-time">
                <div class="kwp-row">


                  
                    <div class="kwp-col-4 email-col">
                        {{ Form::label('email', trans('layer.general.email'), ['class' => 'control-label']) }}
                        {{ Form::text('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('layer.placeholder.email'), 'required' => 'required']) }}
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
                            <p>Ich habe die <a id="datenschutz" href="https://www.trendtours.de/trendtours/datenschutz" target="_blank">Datenschutzrichtlinien</a> zur Kenntnis genommen und möchte meinen Reisewunsch absenden.</p>
                            <script>$('#agb_link').click(dt.agbModal);</script>
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

            

            $(".pax-more .button a").click(function(e) {
                e.preventDefault();
                $(this).parents('.pax-col').removeClass('open');
                var pax = $("#pax").val();
                var children_count = parseInt($("#children").val());
                var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind" : ", "+children_count+" Kinder")  : "" ;

                var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
                $(".travelers .txt").text(pax+" "+erwachsene+" "+children);
                return false;
            });



            $(document).ready(function(){

                var pax = $("#pax").val();
                var children_count = parseInt($("#children").val());
                var children = children_count > 0 ? (children_count == 1 ? ", "+children_count+" Kind" : ", "+children_count+" Kinder")  : "" ;
                var erwachsene = parseInt(pax) > 1 ? "Erwachsene" : "Erwachsener";
                $(".travelers .txt").text(pax+" "+erwachsene+" "+children);

                if($(".dt-modal .haserrors").length){
                    $('.dt-modal #submit-button').addClass('error-button');
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
            <div class="kwp-col-4">
                <button id="submit-button" type="submit">Reisewunsch abschicken</button>
            </div>
        </div>
    </div>
</div>
{{ Form::close() }}