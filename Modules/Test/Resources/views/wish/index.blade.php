@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.whitelabel.browser.title') }}
@endsection

@section('before-styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,700,700italic,900" media="all">
@endsection

@section('after-styles')
    <link rel="stylesheet" href="{{ asset('whitelabel/test/css/test.css') }}">
@endsection

@section('before-scripts')
    <script type="text/javascript">
        var brandColor = {!! json_encode($color) !!};
    </script>
    <script src="{{ mix('whitelabel/test/js/test.js') }}"></script>
@endsection

@section('after-scripts')
    <script type="text/javascript">
        var cssPrimaryBtn = '.btn-primary { background: ' + brandColor + ' !important; border: 1px solid ' + brandColor + ' !important; color: #fff !important; } ';
        $('head').append('<style>' + cssPrimaryBtn + '</style>');
    </script>
@endsection

@section('content')

    <!-- Wish lis Box -->
    <div class="list-container row">
        <div class="col col-lg-12">
            <div class="filter">
                <div class="count">
                    <span class="count" v-cloak>@{{ pagination.total }} {{ trans_choice('labels.frontend.wishes.wishes', intval($count)) }}</span>
                </div>
                @if($logged_in_user->hasRole('Seller'))
                    <div class="filter-action">
                        <select class="selectpicker" id="filter-status" v-model="status" @change="fetchWishes()">
                            {{--<option value="">{{ trans('menus.list.status.all') }}</option>--}}
                            @foreach ($status as $st)
                                <option value="{{ $st }}">
                                    {{ trans('menus.list.status.'.strtolower($st)) }}
                                </option>
                            @endforeach
                        </select>
                        <input type="search" class="id-filter" placeholder="{{ trans('strings.wishlist.search') }}" v-model="id" @input="fetchWishes()">
                    </div>
                @endif
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
                            <li><i class="icon_pin"></i><span class="value">@{{ wish.destination }}</span></li>
                            <li><i class="icon_calendar"></i><span class="value">@{{ wish.earliest_start | moment("DD.MM.YYYY") }}</span> bis <span class="value">@{{ wish.latest_return | moment("DD.MM.YYYY") }}</span></li>
                            <li><i class="icon_hourglass"></i><span class="value">@{{ wish.duration }}</span></li>
                            <li><i class="icon_group"></i><span class="value">@{{ wish.adults }} @{{ wish.kids }} @{{ wish.categories }} @{{ wish.categories ? 'Haustier(e)' : ''  }}</span></li>
                            <li><i class="fal fa-usd-circle"></i><span class="value">@{{ wish.budget }}€</span></li>
                            <li>{{ trans('labels.frontend.wishes.created_at') }} <span class="value">@{{ wish['created_at'] | moment("DD.MM.YYYY") }}</span></li>
                        </ul>
                    </div>
                    <div class="action">
                        <div class="wish-top-infos">
                            <span class="wish-id">
                                @{{ wish.id }}
                            </span>
                            @if($logged_in_user->hasRole('Seller'))
                                <span v-if="wish.wlRule == 'mix'" class="wish-classification btn-secondary">
                                    <span v-if="wish.manuelFlag == true"><i class="fal fa-user"></i></span>
                                    <span v-if="wish.manuelFlag == false"><i class="fal fa-robot"></i></span>
                                </span>
                                <span v-if="wish.messageSentFlag" class="message-sent btn-secondary">
                                    <i class="fal fa-envelope"></i>
                                </span>
                                <span id="{{ trans('strings.wishlist.offer_ex') }}" v-if="wish.offers > 0" class="offer-count btn-secondary">
                                    @{{ wish.offers }}
                                </span>
                            @endif
                        </div>
                        <div class="budget">@{{ formatPrice(wish.budget) }}{{ trans('general.currency') }}</div>
                        @if($logged_in_user->allow('edit-wish') && !$logged_in_user->hasRole('Seller'))
                        <!--    <a type="button" class="btn btn-primary btn-main" :href="'/wish/edit/'+wish.id">{{ trans('labels.frontend.wishes.edit') }}</a>-->
                        @endif
                        <a type="button" class="primary-btn" :href="'/wish/'+wish.id">{{ trans('labels.frontend.wishes.goto') }}</a>
                        @if($logged_in_user->allow('create-offer'))
                            <!--<a :href="'/offers/create/'+wish.id" class="btn btn-flat btn-primary">{{ trans('buttons.wishes.frontend.create_offer')}}</a> -->
                        @endif
                        <!--<a :href="'/offer/create/'+wish.id" class="btn btn-flat btn-primary">{{ trans('buttons.wishes.frontend.create_autooffer')}}</a>-->
                        @if($logged_in_user->hasRole('Seller'))
                            <div class="status-change-action">
                                <select class="selectpicker" id="change-status" v-bind:value="wish.status" v-model="status" @change="changeStatus(wish.id)">
                                    @foreach ($status as $st)
                                        <option value="{{ $st }}">
                                            {{ trans('menus.list.status.'.strtolower($st)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="10" @paginate="fetchWishes()"></pagination>
        </div>
    </div>


@endsection
