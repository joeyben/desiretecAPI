
{{ Form::open(['route' => 'frontend.wishes.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission', 'files' => true]) }}


<div class="kwp-minimal">
    <div class="kwp-content kwp-with-expansion">
        <div class="kwp-row">
            <div class="kwp-col-4">
                {{ Form::label('airport', trans('validation.attributes.backend.wishes.airport'), ['class' => 'col-lg-2 control-label required']) }}
                {{ Form::text('airport', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.airport'), 'required' => 'required']) }}
            </div>
            <div class="kwp-col-4">
                {{ Form::label('destination', trans('validation.attributes.backend.wishes.destination'), ['class' => 'col-lg-2 control-label required']) }}
                {{ Form::text('destination', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.destination'), 'required' => 'required']) }}

            </div>
            <div class="kwp-col-2">
                {{ Form::label('adults', trans('validation.attributes.backend.wishes.adults'), ['class' => 'col-lg-2 control-label required']) }}
                {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.adults'), 'required' => 'required']) }}

            </div>
            <div class="kwp-col-2">
                {{ Form::label('title', trans('validation.attributes.backend.wishes.title'), ['class' => 'col-lg-2 control-label required']) }}
                {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.title'), 'required' => 'required']) }}

            </div>
            <script>kwizzme.childrenAges();</script>
        </div>

        <div class="kwp-row">
            <div class="kwp-col-time">
                <div class="kwp-row">
                    <div class="kwp-col-4">
                        {{ Form::label('earliest_start', trans('validation.attributes.backend.wishes.earliest_start'), ['class' => 'col-lg-2 control-label required']) }}
                        {{ Form::text('earliest_start', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.earliest_start'), 'required' => 'required']) }}

                    </div>
                    <div class="kwp-col-4">
                        {{ Form::label('latest_return', trans('validation.attributes.backend.wishes.latest_return'), ['class' => 'col-lg-2 control-label required']) }}
                        {{ Form::text('latest_return', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.latest_return'), 'required' => 'required']) }}

                    </div>
                    <div class="kwp-col-4">
                        {{ Form::label('duration', trans('validation.attributes.backend.wishes.duration'), ['class' => 'col-lg-2 control-label required']) }}
                        {{ Form::text('duration', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.duration'), 'required' => 'required']) }}

                    </div>
                </div>
            </div>
        </div>
        <div class="kwp-row">
            <div class="kwp-col-4">
                <div class="kwp-form-group">
                    {{ Form::label('category', trans('validation.attributes.backend.wishes.category'), ['class' => 'col-lg-2 control-label required']) }}
                    <div class="kwp-star-input">
                        {{ Form::text('category', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.category'), 'required' => 'required']) }}
                        <span class="kwp-star kwp-star-full" data-val="1"></span>
                        <span class="kwp-star" data-val="2"></span>
                        <span class="kwp-star" data-val="3"></span>
                        <span class="kwp-star" data-val="4"></span>
                        <span class="kwp-star" data-val="5"></span>
                    </div>
                    <script>kwizzme.hotelStars();</script>
                </div>
            </div>
            <div class="kwp-col-4">
                {{ Form::label('title', trans('validation.attributes.backend.wishes.title'), ['class' => 'col-lg-2 control-label required']) }}
                {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.title'), 'required' => 'required']) }}

            </div>
            <div class="kwp-col-4">
                {{ Form::label('title', trans('validation.attributes.backend.wishes.title'), ['class' => 'col-lg-2 control-label required']) }}
                {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.title'), 'required' => 'required']) }}

            </div>
        </div>
        <a href="#" class="kwp-btn-expand {% if not collapse %}kwp-open{% endif %}">Reisewunsch konkreter
            beschreiben</a>
    </div>


    <div class="kwp-content-extra">
        <div class="kwp-content-extra-inner">
            <div class="kwp-row kwp-form-no-group-margin">
                <div class="kwp-col-12">
                    {{ Form::label('description', trans('validation.attributes.backend.wishes.title'), ['class' => 'col-lg-2 control-label required']) }}
                    {{ Form::textarea('description', null,['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.wishes.description')]) }}

                </div>
            </div>
        </div>
    </div>

    <div class="kwp-footer">

        <div class="kwp-row">
            <div class="kwp-col-6">
                {{ Form::label('email', trans('validation.attributes.backend.wishes.email'), ['class' => 'col-lg-2 control-label']) }}
            </div>
            <div class="kwp-col-6">
                {{ Form::label('name', trans('validation.attributes.backend.wishes.name'), ['class' => 'col-lg-2 control-label']) }}
            </div>
        </div>
        <div class="kwp-row">
            <div class="kwp-col-6">
                {{ Form::text('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.email'), 'required' => 'required']) }}

                <div class="kwp-agb">
                    <a href="#" id="agb_link" target="_blank">Teilnahmebedingungen</a>
                    <script>$('#agb_link').click(kwizzme.agbModal);</script>
                </div>
            </div>
            <div class="kwp-col-6">
                {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.wishes.name'), 'required' => 'required']) }}

            </div>
        </div>
        <div class="kwp-row">
            <div class="kwp-col-4of7">
                &nbsp;
            </div>
            <div class="kwp-col-3of7">

                <button id="submit-button" type="submit">Reisewunsch abschicken</button>
            </div>
        </div>
    </div>

</div>
{{ Form::close() }}