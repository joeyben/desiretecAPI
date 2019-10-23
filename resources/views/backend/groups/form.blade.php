<div class="box-body">
    <div class="form-group">
        {{ Form::label('name', trans('validation.attributes.backend.groups.name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.groups.name'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('display_name', trans('validation.attributes.backend.groups.display_name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('display_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.groups.display_name'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('description', trans('validation.attributes.backend.groups.description'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description', null,['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.groups.description')]) }}
        </div><!--col-lg-3-->
    </div><!--form control-->


    <div class="form-group">
        {{ Form::label('status', trans('validation.attributes.backend.groups.status'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
           {{ Form::select('status', $status, null, ['class' => 'form-control select2 status box-size', 'placeholder' => trans('validation.attributes.backend.groups.status'), 'required' => 'required']) }}
        </div><!--col-lg-3-->
    </div><!--form control-->

    {{-- Associated Whitelabels --}}
    <div class="form-group">
        {{ Form::label('status', trans('validation.attributes.backend.groups.associated_whitelabels'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-8">
            @if (count($whitelabels) > 0)
                @foreach($whitelabels as $whitelabel)
                    <div>
                            <label for="whitelabel-{{$whitelabel->id}}" class="control control--radio">
                            <input type="radio" value="{{$whitelabel->id}}" name="whitelabel_id" id="whitelabel-{{$whitelabel->id}}" class=""  @if (isset($group) && $group->whitelabel_id == $whitelabel->id) checked @endif/>  &nbsp;&nbsp;{!! $whitelabel->name !!}
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                @endforeach
            @else
                {{ trans('labels.backend.access.groups.no_whitelabels') }}
            @endif
        </div><!--col-lg-3-->
    </div><!--form control-->
</div>

@section("after-scripts")
    <script type="text/javascript">


    </script>
@endsection
