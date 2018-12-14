<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="i18" content="{{ App::getLocale() }}">
    <title> @yield('title') - {{ config('app.name', 'Laravel') }} </title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('modules/css/icons/icomoon/styles.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/bootstrap_limitless.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/layout.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/components.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset("modules/css/colors.min.css") }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('modules/css/custom.css') }}" rel="stylesheet" type="text/css">
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
        <a href="../full/index.html" class="d-inline-block">
            <img src="{{ asset('img/logo_big.png') }}" alt="">
        </a>
    </div>

    <div class="d-md-none">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
            <i class="icon-tree5"></i>
        </button>
        <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
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

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle caret-0" data-toggle="dropdown" data-hover="dropdown">
                    <i class="icon-envelop2"></i>
                    <span class="d-md-none ml-2">Notifications</span>
                    <span class="badge badge-pill bg-pink-800 ml-auto ml-md-0">8</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right dropdown-content wmin-md-350">
                    <div class="dropdown-content-header">
                        <span class="font-weight-semibold">Messages</span>
                        <a href="#" class="text-default"><i class="icon-compose"></i></a>
                    </div>

                    <div class="dropdown-content-body dropdown-scrollable">
                        <ul class="media-list">
                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="{{ asset('modules/images/placeholders/placeholder.jpg') }}" width="36" height="36" class="rounded-circle" alt="">
                                </div>

                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">James Alexander</span>
                                            <span class="text-muted float-right font-size-sm">04:58</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">who ws, maybe that would be the best thing for me...</span>
                                </div>
                            </li>

                            <li class="media">
                                <div class="mr-3 position-relative">
                                    <img src="{{ asset('modules/images/placeholders/placeholder.jpg') }}" width="36" height="36" class="rounded-circle" alt="">
                                </div>

                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">Margo Baker</span>
                                            <span class="text-muted float-right font-size-sm">12:16</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">That was something he was unable to do because...</span>
                                </div>
                            </li>

                            <li class="media">
                                <div class="mr-3">
                                    <img src="{{ asset('modules/images/placeholders/placeholder.jpg') }}" width="36" height="36" class="rounded-circle" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">Jeremy Victorino</span>
                                            <span class="text-muted float-right font-size-sm">22:48</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">But that would be extremely strained and suspicious...</span>
                                </div>
                            </li>

                            <li class="media">
                                <div class="mr-3">
                                    <img src="{{ asset('modules/images/placeholders/placeholder.jpg') }}" width="36" height="36" class="rounded-circle" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">Beatrix Diaz</span>
                                            <span class="text-muted float-right font-size-sm">Tue</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">What a strenuous career it is that I've chosen...</span>
                                </div>
                            </li>

                            <li class="media">
                                <div class="mr-3">
                                    <img src="{{ asset('modules/images/placeholders/placeholder.jpg') }}" width="36" height="36" class="rounded-circle" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-title">
                                        <a href="#">
                                            <span class="font-weight-semibold">Richard Vango</span>
                                            <span class="text-muted float-right font-size-sm">Mon</span>
                                        </a>
                                    </div>

                                    <span class="text-muted">Other travelling salesmen live a life of luxury...</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="dropdown-content-footer justify-content-center p-0">
                        <a href="#" class="bg-light text-grey w-100 py-2" data-popup="tooltip" title="Load more"><i class="icon-menu7 d-block top-0"></i></a>
                    </div>
                </div>
            </li>

            <li class="nav-item dropdown dropdown-user">
                <a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset("modules/images/image.png") }}" class="rounded-circle mr-2" height="34" alt="">
                    <span>Desiretec</span>
                </a>

                <div class="dropdown-menu dropdown-menu-right">
                    <a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
                    <a href="#" class="dropdown-item"><i class="icon-coins"></i> My balance</a>
                    <a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span class="badge badge-pill bg-blue ml-auto">58</span></a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a>
                    <a href="#" class="dropdown-item"><i class="icon-switch2"></i> Logout</a>
                </div>
            </li>
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
                    <li class="nav-item">
                        <a href="{{ route('provider.dashboard') }}" class="nav-link">
                            <i class="icon-home4"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item nav-item-submenu">
                        <a href="#" class="nav-link"><i class="icon-copy"></i> <span>Access Management</span></a>

                        <ul class="nav nav-group-sub" data-submenu-title="Layouts">
                            <li class="nav-item"><a href="javascript:;" class="nav-link active">User Management</a></li>
                            <li class="nav-item"><a href="javascript:;" class="nav-link">Role Management</a></li>
                            <li class="nav-item"><a href="javascript:;" class="nav-link">Permission Management</a></li>
                        </ul>
                    </li>
                    @if($module->has('Categories') )
                    <li class="nav-item">
                        <a href="{{ route('admin.categories') }}" class="nav-link">
                            <i class="icon-folder-open"></i>
                            <span>Categories Management</span>
                        </a>
                    </li>
                    @endif
                    @if($module->has('Groups') )
                    <li class="nav-item">
                        <a href="{{ route('admin.groups') }}" class="nav-link">
                            <i class="icon-collaboration"></i>
                            <span>Groups Management</span>
                        </a>
                    </li>
                    @endif
                    @if($module->has('Wishes')  && Auth::guard('web')->user()->hasPermission('read-wish'))
                    <li class="nav-item">
                        <a href="{{ route('admin.wishes') }}" class="nav-link">
                            <i class="icon-check"></i>
                            <span>Wishes</span>
                            <span class="badge bg-blue-400 align-self-center ml-auto">0</span>
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
<script src="{{ asset("modules/js/main/jquery.min.js") }}" ></script>
<script src="{{ asset("modules/js/main/bootstrap.bundle.min.js") }}" ></script>
<script src="{{ asset("modules/js/plugins/loaders/blockui.min.js") }}" ></script>
<script src="{{ asset('modules/js/plugins/notifications/bootbox.min.js') }}"></script>
<script src="{{ asset("js/messages.js") }}" type="text/javascript" ></script>
<script src="{{ asset("js/laroute.js") }}" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<script>
  window.i18 = <?php echo json_encode([
        'lang'        => App::getLocale(),
        'placeholder' => asset('global_assets/images/placeholders/placeholder.jpg')
    ]); ?>
</script>
@yield('vue-js')
<!-- /core JS files -->
</body>
</html>
