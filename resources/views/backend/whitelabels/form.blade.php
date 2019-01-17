<div class="box-body">
    <div class="form-group">
        {{ Form::label('name', trans('validation.attributes.backend.whitelabels.name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.whitelabels.name'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('display_name', trans('validation.attributes.backend.whitelabels.display_name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('display_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.whitelabels.display_name'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('status', trans('validation.attributes.backend.whitelabels.status'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
           {{ Form::select('status', $status, null, ['class' => 'form-control select2 status box-size', 'placeholder' => trans('validation.attributes.backend.whitelabels.status'), 'required' => 'required']) }}
        </div><!--col-lg-3-->
    </div><!--form control-->

    {{-- Associated Whitelabels --}}
    <div class="form-group">
        {{ Form::label('distribution_id', trans('validation.attributes.backend.whitelabels.associated_distribution'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-8">
            @if (count($distributions) > 0)
                @foreach($distributions as $distribution)
                    <div>
                        <label for="distribution-{{$distribution->id}}" class="control control--radio">
                            <input type="radio" value="{{$distribution->id}}" name="distribution_id" id="distribution-{{$distribution->id}}" class=""  @if ($whitelabel->distribution_id == $distribution->id) checked @endif/>  &nbsp;&nbsp;{!! $distribution->display_name !!}
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                @endforeach
            @else
                {{ trans('labels.backend.access.wishes.no_whitelabels') }}
            @endif
        </div><!--col-lg-3-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('bg_image', trans('validation.attributes.backend.whitelabels.image'), ['class' => 'col-lg-2 control-label required']) }}
        @if(!empty($whitelabel->bg_image))
            <div class="col-lg-1">
                <img src="{{ Storage::disk('s3')->url('img/whitelabel/' . $whitelabel->bg_image) }}" height="80" width="80">
            </div>
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="featured_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @else
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="bg_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @endif
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('ga_view_id', trans('validation.attributes.backend.whitelabels.ga_view_id'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10">
            {{ Form::text('ga_view_id', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.whitelabels.ga_view_id')]) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

</div>

@section("after-scripts")
    <script type="text/javascript">

        
    </script>
@endsection