@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.groups.management') . ' | ' . trans('labels.backend.groups.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.groups.management') }}
        <small>{{ trans('labels.backend.groups.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.groups.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission', 'files' => true]) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.groups.create') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.groups.partials.groups-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            {{-- Including Form blade file --}}
            <div class="box-body">
                <div class="form-group">
                    @include("backend.groups.form")
                    <div class="edit-form-btn">
                    {{ link_to_route('admin.groups.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!--box-->
    </div>
    {{ Form::close() }}
@endsection
