
{{ Form::open(['route' => 'store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission', 'files' => true]) }}


<div class="kwp-minimal">
    <div class="kwp-content kwp-with-expansion">
        <div class="kwp-row">
            <div class="kwp-col-4">
                {{ Form::label('airport', trans('tui::layer.general.airport'), ['class' => 'control-label required']) }}
                {{ Form::text('airport', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.airport'), 'required' => 'required']) }}
            </div>
            <div class="kwp-col-4">
                {{ Form::label('destination', trans('tui::layer.general.destination'), ['class' => 'control-label required']) }}
                {{ Form::text('destination', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.destination'), 'required' => 'required']) }}

            </div>
            <div class="kwp-col-2">
                {{ Form::label('adults', trans('tui::layer.general.adults'), ['class' => 'control-label required']) }}
                {{ Form::select('adults', $adults_arr , ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.adults'), 'required' => 'required']) }}

            </div>
            <div class="kwp-col-2">
                {{ Form::label('kids', trans('tui::layer.general.kids'), ['class' => 'control-label required']) }}
                {{ Form::text('kids', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.kids'), 'required' => 'required']) }}

            </div>
            <script>kwizzme.childrenAges();</script>
        </div>

        <div class="kwp-row">
            <div class="kwp-col-time">
                <div class="kwp-row">
                    <div class="kwp-col-4">
                        {{ Form::label('earliest_start', trans('tui::layer.general.earliest_start'), ['class' => 'control-label required']) }}
                        {{ Form::text('earliest_start', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.earliest_start'), 'required' => 'required']) }}

                    </div>
                    <div class="kwp-col-4">
                        {{ Form::label('latest_return', trans('tui::layer.general.latest_return'), ['class' => 'control-label required']) }}
                        {{ Form::text('latest_return', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.latest_return'), 'required' => 'required']) }}

                    </div>
                    <div class="kwp-col-4">
                        {{ Form::label('duration', trans('tui::layer.general.duration'), ['class' => 'control-label required']) }}
                        {{ Form::text('duration', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.duration'), 'required' => 'required']) }}

                    </div>
                </div>
            </div>
        </div>
        <div class="kwp-row">
            <div class="kwp-col-4">
                <div class="kwp-form-group">
                    {{ Form::label('category', trans('tui::layer.general.category'), ['class' => 'control-label required']) }}
                    <div class="kwp-star-input">
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
                {{ Form::label('title', trans('tui::layer.general.title'), ['class' => 'control-label required']) }}
                {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.title'), 'required' => 'required']) }}

            </div>
            <div class="kwp-col-4">
                {{ Form::label('title', trans('tui::layer.general.title'), ['class' => 'control-label required']) }}
                {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.title'), 'required' => 'required']) }}

            </div>
        </div>
    </div>


    <div class="kwp-content-extra">
        <div class="kwp-content-extra-inner">
            <div class="kwp-row kwp-form-no-group-margin">
                <div class="kwp-col-12">
                    {{ Form::label('description', trans('tui::layer.general.description'), ['class' => 'control-label required']) }}
                    {{ Form::textarea('description', null,['class' => 'form-control', 'placeholder' => trans('tui::layer.general.description')]) }}

                </div>
            </div>
        </div>
    </div>

    <div class="kwp-footer">

        <div class="kwp-row">
            <div class="kwp-col-6">
                {{ Form::label('email', trans('tui::layer.general.email'), ['class' => 'control-label']) }}
            </div>
            <div class="kwp-col-6">
                {{ Form::label('name', trans('tui::layer.general.name'), ['class' => 'control-label']) }}
            </div>
        </div>
        <div class="kwp-row">
            <div class="kwp-col-6">
                {{ Form::text('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.email'), 'required' => 'required']) }}

                <div class="kwp-agb">
                    <a href="#" id="agb_link" target="_blank">Teilnahmebedingungen</a>
                    <script>$('#agb_link').click(kwizzme.agbModal);</script>
                </div>
            </div>
            <div class="kwp-col-6">
                {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('tui::layer.general.name'), 'required' => 'required']) }}

            </div>
        </div>
        <div class="kwp-row">
            <div class="kwp-col-6">
                &nbsp;
            </div>
            <div class="kwp-col-6">

                <button id="submit-button" type="submit">Reisewunsch abschicken</button>
            </div>
        </div>
    </div>

</div>
{{ Form::close() }}