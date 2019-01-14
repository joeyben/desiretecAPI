@extends('layouts.default')
@section('title')
    {{ trans('labels.backend.access.roles.create') }}
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold"> {{ trans('labels.backend.access.roles.create') }}</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">{{ trans('labels.backend.access.roles.create') }}</span>
    </div>
@stop
@section('vue-js')
    <script src="{{ asset("modules/js/plugins/forms/styling/uniform.min.js") }}" ></script>
    <script>
      $(function() {
        var _componentUniform = function() {
          if (!$().uniform) {
            console.warn('Warning - uniform.min.js is not loaded.');
            return;
          }
        }
        $('.form-check-input-styled-primary').uniform({
          wrapperClass: 'border-primary-600 text-primary-800'
        });
        $('#associated_permissions').change(function(){
          var data= $(this).val();
          if (data === 'all') {
            $("#available-permissions").css("display", "none");
          } else {
            $("#available-permissions").css("display", "block");
          }

        });
      });

    </script>
@stop
@section('content')
    <!-- Basic card -->
    <div class="content">
        @include('includes.alert')
        {{ Form::open(['route' => 'admin.access.role.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-role']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.access.roles.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.access.includes.partials.role-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ Form::label('name', trans('validation.attributes.backend.access.roles.name'), ['class' => 'col-lg-2 control-label required']) }}

                    <div class="col-lg-10">
                        {{ Form::text('name', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.roles.name'), 'required' => 'required']) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('associated_permissions', trans('validation.attributes.backend.access.roles.associated_permissions'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::select('associated_permissions', array('all' => trans('labels.general.all'), 'custom' => trans('labels.general.custom')), 'all', ['class' => 'form-control select2 box-size']) }}
                        <br>
                        <div id="available-permissions" class="hidden mt-20" style="width: 700px; height: 200px; overflow-x: hidden; overflow-y: scroll;display: none;">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    @if ($permissions->count())
                                        @foreach ($permissions as $perm)
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input type="checkbox" class="form-check-input-styled-primary" name="permissions[{{ $perm->id }}]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" {{ is_array(old('permissions')) && in_array($perm->id, old('permissions')) ? 'checked' : '' }} data-fouc/>
                                                    <label for="perm_{{ $perm->id }}">{{ $perm->display_name }}</label>
                                                </label>
                                            </div>
                                            <br/>
                                        @endforeach
                                    @else
                                        <p>There are no available permissions.</p>
                                    @endif
                                </div><!--col-lg-6-->
                            </div><!--row-->
                        </div><!--available permissions-->
                    </div><!--col-lg-3-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('sort', trans('validation.attributes.backend.access.roles.sort'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        {{ Form::text('sort', ($roleCount+1), ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.access.roles.sort')]) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ Form::label('status', trans('validation.attributes.backend.access.roles.active'), ['class' => 'col-lg-2 control-label']) }}

                    <div class="col-lg-10">
                        <div class="control-group">
                            <label class="control control--checkbox">
                                {{ Form::checkbox('status', 1, true) }}
                                <div class="control__indicator"></div>
                            </label>
                        </div>
                    </div><!--col-lg-3-->
                </div><!--form control-->
                <div class="edit-form-btn">
                    {{ link_to_route('admin.access.role.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div>
        {{ Form::close() }}
    </div>
@stop

