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

                <li><span>{{ $logged_in_user->name }}</span></li>
                <li class='logout'>{{ link_to_route('frontend.auth.logout', '') }}</li>
            </ul>
        </div><!--navbar-collapse-->
    </div><!--container-->
</nav>
