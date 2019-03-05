<div class="box-body">
    <div class="form-group">
        {{ Form::label('title', trans('validation.attributes.frontend.offers.title'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('title', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.frontend.offers.title'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('description', trans('validation.attributes.frontend.offers.text'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description', null,['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.offers.text')]) }}
        </div><!--col-lg-3-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('link', trans('validation.attributes.frontend.offers.link'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('link', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.frontend.offers.link_placeholder')]) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('file', trans('validation.attributes.frontend.offers.file'), ['class' => 'col-lg-2 control-label required']) }}
        @if(!empty($offer->featured_image))
            <div class="col-lg-1">
                <img src="{{ Storage::disk('s3')->url('img/offer/' . $offer->featured_image) }}" height="80" width="80">
            </div>
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="featured_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @else
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="file[]" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" multiple />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @endif
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('status', trans('validation.attributes.frontend.offers.status'), ['class' => 'col-lg-2 control-label required']) }}
        <div class="col-lg-10">
           {{ Form::select('status', $status, null, ['class' => 'form-control select2 status box-size', 'placeholder' => trans('validation.attributes.frontend.offers.status'), 'required' => 'required']) }}
        </div><!--col-lg-3-->
        {{ Form::hidden('wish_id', $wish_id) }}
    </div><!--form control-->
</div>

@section("after-scripts")
    <script type="text/javascript">

        
    </script>
@endsection