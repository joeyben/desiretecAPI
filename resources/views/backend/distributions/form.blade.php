<div class="box-body">
    <div class="form-group">
        {{ Form::label('name', trans('validation.attributes.backend.distributions.name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.distributions.name'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('display_name', trans('validation.attributes.backend.distributions.display_name'), ['class' => 'col-lg-2 control-label required']) }}

        <div class="col-lg-10">
            {{ Form::text('display_name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.distributions.display_name'), 'required' => 'required']) }}
        </div><!--col-lg-10-->
    </div><!--form control-->

    <div class="form-group">
        {{ Form::label('description', trans('validation.attributes.backend.distributions.description'), ['class' => 'col-lg-2 control-label']) }}

        <div class="col-lg-10 mce-box">
            {{ Form::textarea('description', null,['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.distributions.description')]) }}
        </div><!--col-lg-3-->
    </div><!--form control-->


</div>

@section("after-scripts")
    <script type="text/javascript">

        
    </script>
@endsection