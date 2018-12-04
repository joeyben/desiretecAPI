@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.wishes.management') . ' | ' . trans('labels.backend.wishes.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.wishes.management') }}
        <small>{{ trans('labels.backend.wishes.edit') }}</small>
    </h1>
@endsection

@section('before-styles')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('after-scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{ asset('js/backend/datepicker.js') }}"></script>
@endsection


@section('content')

    {{ Form::model($wish, ['route' => ['admin.wishes.update', $wish], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role', 'files' => true]) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.wishes.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.wishes.partials.wishes-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            {{-- Including Form blade file --}}
            <div class="box-body">
                <div class="form-group">
                    @include("backend.wishes.form")
                    <div class="edit-form-btn">
                    {{ link_to_route('admin.wishes.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div>
        </div><!--box-->
    </div>
    {{ Form::close() }}
@endsection

