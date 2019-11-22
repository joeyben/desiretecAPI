@extends('frontend.layouts.app')

@section('title')
    {{ trans('general.url.login') }}
@endsection

@section('before-scripts')
    <script type="application/javascript">
        var brandColor = {!! json_encode(getCurrentWhiteLabelColor()) !!};
    </script>
@endsection

@section('after-scripts')
    <script type="application/javascript">
        var cssPrimaryBtn = '.primary-btn, .btn-primary { background: ' + brandColor + ' !important; border: 1px solid ' + brandColor + ' !important; } ';
        var cssSecondaryBtn = '.secondary-btn, .btn-secondary { background: transparent !important; color: ' + brandColor + ' !important; border: 1px solid ' + brandColor + ' !important; margin-top: 8px; } ';
        var cssFormElements = '.form-control:focus { border-bottom: 1px solid ' + brandColor + ' !important; } .form-group a { color: ' + brandColor + ' !important; }';
        $('head').append('<style>' + cssPrimaryBtn + cssSecondaryBtn + cssFormElements + '</style>');
    </script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login/token') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">{{ trans('label.tokenlogin.email') }}</label>

                            <div class="col-md-8">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--<div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>-->

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn primary-btn mb-0">
                                    {{ trans('button.tokenlogin.send') }}
                                </button>
                                <a href="{{route('frontend.auth.login')}}" class="btn secondary-btn">
                                    {{ trans('account.login.seller') }}
                                </a>


                                <!--<a href="{{ url('/login') }}" class="btn btn-link">Login with password instead</a>-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
