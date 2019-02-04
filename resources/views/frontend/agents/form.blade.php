<div class="form-group">
    {{ Form::label('name', 'First Name', ['class' => 'col-lg-2 control-label required']) }}
    <div class="col-lg-10">
        {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => 'First Name', 'required' => 'required']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('display_name', 'Display Name', ['class' => 'col-lg-2 control-label required']) }}
    <div class="col-lg-10">
        {{ Form::text('display_name', null, ['class' => 'form-control box-size', 'placeholder' => 'Display Name', 'required' => 'required']) }}
    </div>
</div>

<div class="form-group">
    {{ Form::label('status', 'Status', ['class' => 'col-lg-2 control-label required']) }}
    <div class="col-lg-10">
        {{ Form::select('status', array('active' => 'Active', 'inactive' => 'InActive', 'deleted' => 'Deleted'), 'Active') }}
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
            <div class="col-lg-5">
                <div class="custom-file-input">
                    <input type="file" name="avatar" id="file-1" class="inputfile inputfile-1" data-multiple-caption="{count} files selected" />
                    <label for="file-1"><i class="fa fa-upload"></i><span>Choose a file</span></label>
                </div>
            </div>
        @endif
</div>
