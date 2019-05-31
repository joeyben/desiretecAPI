<div class="form-group">
    {{ Form::label('name', trans('seller.agent.name'), ['class' => 'col-lg-2 control-label required']) }}
    <div class="col-lg-10">
        {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => 'First Name', 'required' => 'required']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('email', trans('seller.agent.email'), ['class' => 'col-lg-2 control-label required']) }}
    <div class="col-lg-10">
        {{ Form::email('email', null, ['class' => 'form-control box-size', 'placeholder' => trans('seller.agent.email_placeholder'), 'required' => 'required']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('telephone', trans('seller.agent.tel'), ['class' => 'col-lg-2 control-label required']) }}
    <div class="col-lg-10">
        {{ Form::text('telephone', null, ['class' => 'form-control box-size', 'placeholder' => trans('seller.agent.tel_placeholder'), 'required' => 'required']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('avatar', 'Avatar', ['class' => 'col-lg-2 control-label required']) }}
        @if(!empty($agent->featured_image))
            <div class="col-lg-1">
                <img src="{{ Storage::disk('s3')->url('img/agent/' . $agent->featured_image) }}" height="80" width="80">
            </div>
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="featured_image" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @else
            <div class="col-lg-10">
                <div class="input-group">
                    <input type="text" class="form-control readonly" readonly>
                    <div class="input-group-btn">
                      <span class="fileUpload btn primary-btn">
                          <span class="upl" id="upload">{{ trans('agent.image.upload') }}</span>
                          <input type="file" name="avatar" class="upload up" id="up" onchange="" />
                      </span><!-- btn-orange -->
                    </div><!-- btn -->
                </div><!-- group -->
            </div>
        @endif
</div>

