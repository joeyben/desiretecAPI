@extends('layouts.default')
@section('title')
    {{ trans('labels.backend.access.permissions.create') }}
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">{{ trans('labels.backend.access.permissions.create') }}</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">{{ trans('labels.backend.access.permissions.create') }}</span>
    </div>
@stop
@section('vue-js')
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="permissionsComponent">
        {{ Form::open(['route' => 'admin.access.permission.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.access.permissions.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.access.includes.partials.permission-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">

                {{-- Including Form --}}
                @include("backend.access.permissions.form")

                <div class="edit-form-btn">
                    {{ link_to_route('admin.access.permission.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
        {{ Form::close() }}
    </div>
@stop

