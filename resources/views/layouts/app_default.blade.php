
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="i18" content="{{ App::getLocale() }}">
    <title> @yield('title') - {{ config('app.name', 'Laravel') }} </title>
<?php
if(!empty($google_analytics)){
    echo $google_analytics;
}
?>

<!-- Global stylesheets -->
    @yield('before-styles')
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('modules/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/bootstrap_limitless.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/layout.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/components.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/colors.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('modules/css/custom.css') }}" rel="stylesheet" type="text/css">
@yield('after-styles')
<!-- /global stylesheets -->


    <!-- Theme JS files -->
    <script src="{{ asset("modules/js/app.js") }}"></script>
    <!-- /theme JS files -->

</head>

<body class="navbar-top">
<?php $module = Module::collections() ?>
<!-- Main navbar -->
<div class="navbar navbar-dark navbar-expand-md fixed-top">
    <div class="navbar-brand">
        <a href="{{ route('admin.dashboard') }}" class="d-inline-block">
            <img src="{{ asset('img/logo_big.png') }}" alt="Logo">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile" style="color: #444 !important;">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button" style="color: #444 !important;">
            <i class="icon-paragraph-justify3"></i>
        </button>
    </div>

    <div class="collapse navbar-collapse" id="navbar-mobile">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
                    <i class="icon-paragraph-justify3"></i>
                </a>
            </li>
        </ul>
        @if(Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE) && !Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
            <a href="{{ live_preview_url() }}" target="_blank" class="btn bg-orange-800 text-uppercase font-size-sm line-height-sm font-weight-semibold py-2 px-3 ml-sm-4 shadow  d-block d-sm-inline-block">Live Preview <i class="icon-circle-right2 ml-2"></i></a>
        @endif
        <ul class="navbar-nav ml-auto" id="notificationsComponent">
            <notifications-component></notifications-component>


            @if (config('locale.status') && count(config('locale.languages')) > 1)
                <li class="nav-item dropdown dropdown-user backend-lang-switcher">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" style="height: 100%" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ trans('menus.language-picker.language') }}
                        <span class="caret"></span>
                    </a>

                    @include('includes.partials.lang')
                </li>
            @endif

            @auth('web')
                <li class="nav-item dropdown dropdown-user">
                    <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ asset("modules/images/image.png") }}" class="rounded-circle mr-2" height="34" alt="">
                        <span> {{ auth()->guard('web')->user()->email }} </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        @if ($logged_in_user && session()->has("admin_user_id") && session()->has("temp_user_id"))
                            <a href="{{ route("frontend.auth.logout-as") }}" class="dropdown-item  text-teal-800">
                                <i class="icon-enter3"></i>
                                Re-Login as {{ session()->get("admin_user_name") }}
                            </a>
                        @endif
                        <a href="{!! route('frontend.auth.logout') !!}" class="dropdown-item">
                            <i class="icon-switch2"></i>  {{ trans('navs.general.logout') }}
                        </a>
                    </div>
                </li>
            @endauth
        </ul>
    </div>
</div>
<!-- /main navbar -->


<!-- Page content -->
<div class="page-content">

    <!-- Main sidebar -->
    <div class="sidebar sidebar-dark sidebar-main sidebar-fixed sidebar-expand-md">

        <!-- Sidebar mobile toggler -->
        <div class="sidebar-mobile-toggler text-center">
            <a href="#" class="sidebar-mobile-main-toggle">
                <i class="icon-arrow-left8"></i>
            </a>
            Navigation
            <a href="#" class="sidebar-mobile-expand">
                <i class="icon-screen-full"></i>
                <i class="icon-screen-normal"></i>
            </a>
        </div>
        <!-- /sidebar mobile toggler -->


        <!-- Sidebar content -->
        <div class="sidebar-content">

            <!-- User menu -->
            <div class="sidebar-user">
                <div class="card-body">
                    <div class="media">
                        <div class="mr-3">
                            <a href="#"><img src="{{ asset('modules/images/image.png') }}" width="38" height="38" class="rounded-circle" alt=""></a>
                        </div>

                        <div class="media-body">
                            <div class="media-title font-weight-semibold">Desiretec</div>
                            <div class="font-size-xs opacity-50">
                                <i class="icon-pin font-size-sm"></i> &nbsp;Hamburg, DE
                            </div>
                        </div>

                        <div class="ml-3 align-self-center">
                            <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /user menu -->


            <!-- Main navigation -->
            <div class="card card-sidebar-mobile">
                <ul class="nav nav-sidebar" data-nav-type="accordion">

                    <!-- Main -->
                    <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
                    @if($module->has('Dashboard'))
                        <li class="nav-item">
                            <a href="{{ route('admin.dashboard') }}" class="nav-link">
                                <i class="icon-home4"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                    @endif
                    @if($module->has('Users')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
                        @permission('view-access-management')
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-copy"></i> <span> {{ __('menus.access_management') }}</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                                @permission('view-user-management')
                                <li class="nav-item"><a href="{{ route('admin.users') }}" class="nav-link {{ active_class(Active::checkUriPattern('admin/access/user*')) }}">{{ trans('labels.backend.access.users.management') }}</a></li>
                                @endauth
                                @if($module->has('Roles') && Auth::guard('web')->user()->hasPermission('view-role-management'))
                                    <li class="nav-item"><a href="{{ route('admin.access.role.index') }}" class="nav-link">{{ trans('labels.backend.access.roles.management') }}</a></li>
                                @endif
                                @if($module->has('Permissions') && Auth::guard('web')->user()->hasPermission('view-permission-management'))
                                    <li class="nav-item"><a href="{{ route('admin.access.permission.index') }}" class="nav-link">{{ trans('labels.backend.access.permissions.management') }}</a></li>
                                @endif
                            </ul>
                        </li>
                    @endauth
                    @endif
                    @if($module->has('Categories') && Auth::guard('web')->user()->hasPermission('read-category'))
                        <li class="nav-item">
                            <a href="{{ route('admin.categories') }}" class="nav-link">
                                <i class="icon-folder-open"></i>
                                <span>{{ __('menus.categories_management') }} </span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Wishes')  && Auth::guard('web')->user()->hasPermission('read-wish'))
                        <li class="nav-item">
                            <a href="{{ route('admin.wishes') }}" class="nav-link">
                                <i class="icon-heart5"></i>
                                <span>{{ __('menus.wishes_management') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Whitelabels')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE) && !Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('provider.whitelabels') }}" class="nav-link">
                                <i class="icon-atom2"></i>
                                <span>{{ __('labels.backend.whitelabels.table.display_name') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Whitelabels')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('admin.whitelabels') }}" class="nav-link">
                                <i class="icon-atom2"></i>
                                <span>{{ __('labels.backend.whitelabels.table.display_name') }}</span>
                            </a>
                        </li>
                    @endif

                    @if(Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('admin.whitelabels.layers') }}" class="nav-link">
                                <i class="icon-menu2"></i>
                                <span>{{ __('Layer Version') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.whitelabels.content') }}" class="nav-link">
                                <i class="icon-menu2"></i>
                                <span>{{ __('Layer Content') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.variants') }}" class="nav-link">
                                <i class="icon-menu2"></i>
                                <span>{{ __('Variants') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Languages')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('provider.email.signature', app()->getLocale()) }}" class="nav-link">
                                <i class="icon-mention"></i>
                                <span>{{ __('menus.email_signature') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Whitelabels')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('admin.footers') }}" class="nav-link">
                                <i class="icon-move-down"></i>
                                <span>{{ __('labels.footers') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Languages')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('provider.footer.tnb', app()->getLocale()) }}" class="nav-link">
                                <i class="icon-section"></i>
                                <span>{{ __('menus.footer_tnb') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Users')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE))
                        @permission('view-access-management')
                            @permission('view-seller-management')
                                <li class="nav-item">
                                    <a href="{{ route('admin.sellers') }}" class="nav-link">
                                        <i class="icon-users4"></i>
                                        <span>{{ __('menus.sellers_management') }}</span>
                                    </a>
                                </li>
                            @endauth
                        @endauth
                    @endif

                    @if($module->has('Groups') && Auth::guard('web')->user()->hasPermission('read-group'))
                        <li class="nav-item">
                            <a href="{{ route('admin.groups') }}" class="nav-link">
                                <i class="icon-collaboration"></i>
                                <span>{{ __('menus.groups_management') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Languages')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('provider.languages') }}" class="nav-link">
                                <i class="icon-flag3"></i>
                                <span>{{ __('menus.languages') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Languages')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('provider.language-lines') }}" class="nav-link">
                                <i class="icon-flag3"></i>
                                <span>{{ __('menus.languages_lines') }}</span>
                            </a>
                        </li>
                    @endif

                    @if(false && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE) && !Auth::guard('web')->user()->hasRole('Administrator'))
                        <li class="nav-item">
                            <a href="{{ route('admin.whitelabels.compile') }}" class="nav-link">
                                <i class="icon-atom2"></i>
                                <span>{{ __('labels.compile') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Rules')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('admin.rules') }}" class="nav-link">
                                <i class="icon-cube4"></i>
                                <span>{{ __('menus.rules_management') }}</span>
                            </a>
                        </li>
                    @elseif($module->has('Rules')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE))
                        <li class="nav-item" data-popup="tooltip" data-html="true" data-trigger="hover" data-original-title="{{ __('menus.backend.access.permissions.version_restrictions') }}">
                            <a href="{{ route('admin.rules') }}" class="nav-link {{ is_light() ? 'disabled' : '' }}">
                                <i class="icon-cube4"></i>
                                <span>{{ __('menus.rules_management') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Rules')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('admin.regions') }}" class="nav-link">
                                <i class="icon-cube4"></i>
                                <span>{{ __('menus.regions_management') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Rules')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::ADMINISTRATOR_ROLE))
                        <li class="nav-item">
                            <a href="{{ route('autooffer.setting') }}" class="nav-link">
                                <i class="icon-stack-picture"></i>
                                <span>{{ __('menus.autooffers_management') }}</span>
                            </a>
                        </li>
                    @elseif($module->has('Rules')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE))
                        <li class="nav-item" data-popup="tooltip" data-html="true" data-trigger="hover" data-original-title="{{ __('menus.backend.access.permissions.version_restrictions') }}">
                            <a href="{{ route('autooffer.setting') }}" class="nav-link {{ is_light() ? 'disabled' : '' }}">
                                <i class="icon-stack-picture"></i>
                                <span>{{ __('menus.autooffers_management') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Whitelabels')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE) && !Auth::guard('web')->user()->hasRole('Administrator'))
                        <li class="nav-item">
                            <a href="{{ route('provider.whitelabels.snippet') }}" class="nav-link">
                                <i class="icon-file-text"></i>
                                <span>{{ __('JS Snippet') }}</span>
                            </a>
                        </li>
                    @endif

                    @if($module->has('Whitelabels')  && Auth::guard('web')->user()->hasRole(\App\Services\Flag\Src\Flag::EXECUTIVE_ROLE) && !Auth::guard('web')->user()->hasRole('Administrator'))
                        <li class="nav-item">
                            <a href="{{ route('provider.whitelabels.how-it-works') }}" class="nav-link">
                                <i class="icon-help"></i>
                                <span>{{ __('How It Works') }}</span>
                            </a>
                        </li>
                    @endif

                    @if(Auth::guard('web')->user()->hasRole('Administrator'))
                        <li class="nav-item nav-item-submenu">
                            <a href="#" class="nav-link"><i class="icon-power3"></i> <span>Maintenance</span></a>

                            <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                                <li class="nav-item">
                                    <a href="{{ route('log-viewer::dashboard') }}" class="nav-link" target="_blank">
                                        <i class="icon-warning2"></i>
                                        <span>Logs</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.components') }}" class="nav-link">
                                        <i class="icon-cube4"></i>
                                        <span>Components Mgnt</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.backups') }}" class="nav-link">
                                        <i class="icon-file-text"></i>
                                        <span>Backups Mgnt</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                @endif
                <!-- /main -->

                </ul>
            </div>
            <!-- /main navigation -->

        </div>
        <!-- /sidebar content -->

    </div>
    <!-- /main sidebar -->


    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        <div class="page-header page-header-light" style="border: 1px solid #ddd; border-bottom: 0;">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title">
                    <h1>
                        @yield('page-title')
                    </h1>
                </div>
            </div>

            <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
                <div class="d-flex">
                    @yield('breadcrumb')
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>
            </div>
        </div>
        <!-- /page header -->


        <!-- Content area -->
    @yield('content')
    <!-- /content area -->


        <!-- Footer -->
        <div class="navbar navbar-expand-lg navbar-light">
            <div class="text-center d-lg-none w-100">
                <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
                    <i class="icon-unfold mr-2"></i>
                    Footer
                </button>
            </div>

            <div class="navbar-collapse collapse" id="navbar-footer">
                    <span class="navbar-text">
                        &copy; 2019 <a href="https://desiretec.com/" target="_blank">Desiretec GmbH</a>
                    </span>
            </div>
        </div>
        <!-- /footer -->

    </div>
    <!-- /main content -->

</div>
<!-- /page content -->

<!-- /page content -->
<!-- Core JS files -->
@yield('before-scripts')
<script src="{{ asset("modules/js/main/jquery.min.js") }}" ></script>
<script src="{{ asset("modules/js/main/bootstrap.bundle.min.js") }}" ></script>
<script src="{{ asset("modules/js/plugins/loaders/blockui.min.js") }}" ></script>
<script src="{{ asset('modules/js/plugins/notifications/bootbox.min.js') }}"></script>
<script src="{{ asset("storage/js/messages.js") }}" type="text/javascript" ></script>
<script src="{{ asset("storage/js/laroute.js") }}" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script>
  window.i18 = <?php echo json_encode([
        'lang'        => App::getLocale(),
        'placeholder' => asset('global_assets/images/placeholders/placeholder.jpg')
    ]); ?>
</script>
@yield('vue-js')
<script src="{{ asset('js/modules/user/notifications/notifications.js') }}"></script>
@yield('after-scripts')
</body>
</html>
