<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#frontend-navbar-collapse">
                <span class="sr-only">{{ trans('labels.general.toggle_navigation') }}</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

           {{--   @if(settings()->logo)
            <a href="{{ route('frontend.index') }}" class="logo"><img height="48" width="226" class="navbar-brand" src="{{route('frontend.index')}}/img/site_logo/{{settings()->logo}}"></a>
            @else
             {{ link_to_route('frontend.index',app_name(), [], ['class' => 'navbar-brand']) }}
           {{--  @endif --}}
            @yield('logo')


        </div><!--navbar-header-->

        <div class="collapse navbar-collapse" id="frontend-navbar-collapse">

            <ul class="nav navbar-nav navbar-right">
                @if (config('locale.status') && count(config('locale.languages')) > 1)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ trans('menus.language-picker.language') }}
                            <span class="caret"></span>
                        </a>

                        @include('includes.partials.lang')
                    </li>
                @endif

                @if ($logged_in_user && $logged_in_user->hasRole('Seller'))
                    <li>{{ link_to_route('frontend.wishes.list', trans('navs.frontend.wisheslist')) }}</li>
                @endif

                @if ($logged_in_user && $logged_in_user->hasRole('User'))
                    <li>{{ link_to_route('frontend.wishes.create', trans('navs.frontend.create_wish')) }}</li>
                @endif

                @if (! $logged_in_user)
                    <li>{{ link_to_route('frontend.auth.login', trans('navs.frontend.login')) }}</li>

                    @if (config('access.users.registration'))
                        <li>{{ link_to_route('frontend.auth.register', trans('navs.frontend.register')) }}</li>
                    @endif
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ $logged_in_user->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @permission('view-backend')
                                <li>{{ link_to_route('admin.dashboard', trans('navs.frontend.user.administration')) }}</li>
                            @endauth

                            @if ($logged_in_user && $logged_in_user->hasRole('Seller'))
                                <li>{{ link_to_route('frontend.offers.index', trans('navs.frontend.offers')) }}</li>
                                <li>{{ link_to_route('frontend.agents.index', trans('navs.frontend.agents')) }}</li>
                            @endif

                            @if ($logged_in_user && $logged_in_user->hasRole('User'))
                                <li>{{ link_to_route('frontend.wishes.list', trans('navs.frontend.wishes')) }}</li>
                            @endif

                            <li>{{ link_to_route('frontend.user.account', trans('navs.frontend.user.account')) }}</li>
                            <li>{{ link_to_route('frontend.auth.logout', trans('navs.general.logout')) }}</li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div><!--navbar-collapse-->
    </div><!--container-->
</nav>
