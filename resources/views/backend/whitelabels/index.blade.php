@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.whitelabels.management'))

@section('page-header')
    <h1>{{ trans('labels.backend.whitelabels.management') }}</h1>
@endsection

@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.whitelabels.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.whitelabels.partials.whitelabels-header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="whitelabels-table" class="table table-condensed table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.whitelabels.table.display_name') }}</th>
                            <th>{{ trans('labels.backend.whitelabels.table.name') }}</th>
                            <th>{{ trans('labels.backend.whitelabels.table.distribution') }}</th>
                            <th>{{ trans('labels.backend.whitelabels.table.status') }}</th>
                            <th>{{ trans('labels.backend.whitelabels.table.createdat') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
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
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        $(function() {
            var dataTable = $('#whitelabels-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("admin.whitelabels.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'display_name', name: '{{config('module.whitelabels.table')}}.display_name'},
                    {data: 'name', name: '{{config('module.whitelabels.table')}}.name'},
                    {data: 'distribution', name: 'distribution', searchable: false, sortable: false},
                    {data: 'status', name: '{{config('module.whitelabels.table')}}.status'},
                    {data: 'created_at', name: '{{config('module.whitelabels.table')}}.created_at'},
                    {data: 'actions', name: 'actions', searchable: false, sortable: false}
                ],
                order: [[3, "asc"]],
                searchDelay: 500,
                dom: 'lBfrtip',
                buttons: {
                    buttons: [
                        { extend: 'copy', className: 'copyButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }},
                        { extend: 'csv', className: 'csvButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }},
                        { extend: 'excel', className: 'excelButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }},
                        { extend: 'pdf', className: 'pdfButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }},
                        { extend: 'print', className: 'printButton',  exportOptions: {columns: [ 0, 1, 2, 3, 4 ]  }}
                    ]
                }
            });

            Backend.DataTableSearch.init(dataTable);
        });
    </script>
@endsection