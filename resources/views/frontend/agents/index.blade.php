@extends('frontend.layouts.app')

@section('content')
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
                {data: 'created_at', name: '{{config('module.agents.table')}}.created_at'},

            ],
            order: [[3, "asc"]],
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