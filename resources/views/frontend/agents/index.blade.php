@extends('frontend.layouts.app')

@section('content')
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal_content">
        {{ Form::open(['route' => 'frontend.agents.store', 'class' => 'form-horizontal', 'method' => 'post', 'files' => true]) }}
            <div class="modal-header">
                <h5 class="modal-title">{{isset($customer)?'Edit':'New'}} Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- Including Form blade file --}}
                @include("frontend.agents.form")
            </div>
            <div class="modal-footer">
                {{ link_to_route('frontend.agents.index', 'Cancel', [], ['class' => 'btn btn-danger btn-md']) }}
                {{ Form::submit('Create', ['class' => 'btn btn-primary btn-md']) }}
            </div>
        {{ Form::close() }} 
        </div>
    </div>
</div>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('labels.frontend.agents.management') }}</h3>
        <div class="box-tools pull-right">
            @include('frontend.agents.partials.agents-header-buttons')
        </div>
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="table-responsive data-table-wrapper">
            <table id="agents-table" class="table table-condensed table-hover table-bordered">
                <thead class="transparent-bg">
                <tr>
                    <th>{{ trans('labels.frontend.agents.table.avatar') }}</th>
                    <th>{{ trans('labels.frontend.agents.table.id') }}</th>
                    <th>{{ trans('labels.frontend.agents.table.name') }}</th>
                    <th>{{ trans('labels.frontend.agents.table.status') }}</th>
                    <th>{{ trans('labels.frontend.agents.table.created_at') }}</th>
                </tr>
                </thead>
            </table>
        </div><!--table-responsive-->
    </div><!-- /.box-body -->
</div><!--box-->
<!--<div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
</div><!-- /.box-header -->
<div class="box-body">
    {{-- {!! history()->renderType('Blog') !!} --}}
</div><!-- /.box-body -->
</div><!--box box-info-->
@endsection
@section('after-scripts')

{{ Html::script(mix('js/dataTable.js')) }}

<script>
    $(function() {
        var dataTable = $('#agents-table').dataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("frontend.agents.get") }}',
                type: 'post'
            },
            columns: [
                {data: 'avatar', name: '{{config('module.agents.table')}}.avatar'},
                {data: 'id', name: '{{config('module.agents.table')}}.name'},
                {data: 'name', name: '{{config('module.agents.table')}}.display_name'},
                {data: 'status', name: '{{config('module.agents.table')}}.status'},
                {data: 'created_at', name: '{{config('module.agents.table')}}.created_at'}
            ],
            order: [[4, "asc"]],
            searchDelay: 500,
            dom: 'lBfrtip',
            buttons: {
                buttons: [

                ]
            }
        });

        //Backend.DataTableSearch.init(dataTable);
    });
</script>

@endsection