@extends('frontend.layouts.app')


@section('content')
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.frontend.offers.management') }}</h3>

        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="offers-table" class="table table-condensed table-hover table-bordered">
                    <thead class="transparent-bg">
                        <tr>
                            <th>{{ trans('labels.frontend.offers.table.title') }}</th>
                            <th>{{ trans('labels.frontend.offers.table.createdby') }}</th>
                            <th>{{ trans('labels.frontend.offers.table.createdat') }}</th>
                            <th>{{ trans('labels.frontend.offers.table.status') }}</th>

                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

    <!--<div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.frontend.recent_history') }}</h3>
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
            var dataTable = $('#offers-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("frontend.offers.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'title', name: '{{config('module.offers.table')}}.title'},
                    {data: 'created_by', name: '{{config('module.offers.table')}}.created_by'},
                    {data: 'created_at', name: '{{config('module.offers.table')}}.created_at'},
                    {data: 'status', name: '{{config('module.offers.table')}}.status'},

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