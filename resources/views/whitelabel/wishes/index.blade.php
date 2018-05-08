@extends('frontend.layouts.app')

@section('content')
    <div class="box box-info" style="display: none;">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.wishes.management') }}</h3>

        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive data-table-wrapper">
                <table id="wishes-table" class="table table-condensed table-hover table-bordered">
                    <thead class="transparent-bg">
                        <tr>
                            <th>{{ trans('labels.backend.wishes.table.title') }}</th>
                            <th>{{ trans('labels.backend.wishes.table.airport') }}</th>
                            <th>{{ trans('labels.backend.wishes.table.destination') }}</th>
                            <th>{{ trans('labels.backend.wishes.table.earliest_start') }}</th>
                            <th>{{ trans('labels.backend.wishes.table.latest_return') }}</th>
                            <th>{{ trans('labels.backend.wishes.table.createdby') }}</th>
                            <th>{{ trans('labels.backend.wishes.table.createdat') }}</th>
                            <th>{{ trans('labels.backend.wishes.table.whitelabel') }}</th>
                            <th>{{ trans('labels.backend.wishes.table.offerCount') }}</th>
                            <th>{{ trans('labels.backend.wishes.table.status') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

    <!-- Wish lis Box -->
    <div class="list-container row">
        <div class="col col-lg-12">
            <div class="filter">
                <div class="count">
                    <span class="count">{{ $count }} {{ trans('labels.frontend.wishes.wishes') }}</span>
                </div>
                <div class="filter-action">
                    <select class="selectpicker" id="filter-status" v-model="status" @change="fetchWishes()">
                        <option value="">{{ trans('menus.list.status.all') }}</option>
                        @foreach ($status as $st)
                            <option value="{{ $st }}">
                                {{ $st }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <hr>
            <div class="skeleton" v-if="loading"></div>
            <div class="list wishlist" v-cloak>
                <div class="list-element" v-for="wish in data">
                    <div class="image">
                        <a href="#" class="img" :style="{ 'background-image' : 'url({{ Storage::disk('s3')->url('img/wish/') }}' + wish.featured_image + ')' }">
                            <span class="caption"></span>
                        </a>
                    </div>
                    <div class="main-info">
                        <ul class="info">
                            <li><span class="value"><i class="icon_id-2"></i>@{{ wish.title }}</span></li>
                            <li><i class="icon_pin"></i><span class="value">@{{ wish.destination }}</span></li>
                            <li><i class="icon_calendar"></i><span class="value">@{{ wish.duration }}</span></li>
                            <li><i class="icon_group"></i><span class="value">@{{ wish.adults }} {{ trans('labels.frontend.wishes.table.adults') }}</span></li>
                            <li><i class="icon_hourglass"></i><span class="value">@{{ wish.earliest_start }}</span> - <span class="value">@{{ wish.latest_return }}</span></li>
                            <li><i class="icon_info"></i><span class="value">@{{ wish.status }}</span></li>
                            <li>{{ trans('labels.frontend.wishes.created_at') }} <span class="value">@{{ wish['created_at'] | moment("dddd, MMMM Do YYYY") }}</span></li>
                        </ul>
                    </div>
                    <div class="action">
                        <div class="wish-top-infos">
                            <span v-if="wish.offers > 0" class="offer-count">
                                @{{ wish.offers }}
                            </span>
                        </div>
                        <div class="budget">@{{ formatPrice(wish.budget) }}{{ trans('general.currency') }}</div>
                        <button type="button" class="btn btn-primary">{{ trans('labels.frontend.wishes.goto') }}</button>
                    </div>
                </div>
            </div>
            <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="10" @paginate="fetchWishes()"></pagination>
        </div>
    </div>


@endsection

@section('after-scripts')
    {{-- For DataTables --}}
    {{ Html::script(mix('js/dataTable.js')) }}

    <script>
        $(function() {
            var dataTable = $('#wishes-table').dataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("frontend.wishes.get") }}',
                    type: 'post'
                },
                columns: [
                    {data: 'title', name: '{{config('module.wishes.table')}}.title'},
                    {data: 'airport', name: '{{config('module.wishes.table')}}.airport'},
                    {data: 'destination', name: '{{config('module.wishes.table')}}.destination'},
                    {data: 'earliest_start', name: '{{config('module.wishes.table')}}.earliest_start'},
                    {data: 'latest_return', name: '{{config('module.wishes.table')}}.latest_return'},
                    {data: 'created_by', name: '{{config('module.wishes.table')}}.created_by'},
                    {data: 'created_at', name: '{{config('module.wishes.table')}}.created_at', searchable: false},
                    {data: 'whitelabel_name', name: '{{config('module.wishes.table')}}.whitelabel_name', searchable: false},
                    {data: 'offer_count', name: 'count' , searchable: false, sortable: false},
                    {data: 'status', name: '{{config('module.wishes.table')}}.status', searchable: false},
                    {data: 'add_offer', name: 'add_offer', searchable: false, sortable: false}
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