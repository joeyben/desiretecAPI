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
        $(document).ready(function(){
            $("input").focus(function(){
                $(this).css({'border-color': brandColor});
            });
            $("input").blur(function(){
                $(this).css({'border-color': 'inherit'});
            });
        });
    </script>
@endsection

@section('content')


    <div class="row auth">
        @include('includes.alert')
        <div class="col-md-6 col-md-offset-4">

            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('labels.frontend.auth.login_box_title') }}</div>

                <div class="panel-body">

                    {{ Form::open(['route' => 'frontend.auth.login', 'class' => 'form-horizontal']) }}

                    <div class="form-group float-label">
                        {{ Form::input('email', 'email', null, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'transparent', 'required']) }}
                        {{ Form::label('email', trans('validation.attributes.frontend.register-user.email')) }}
                    </div>

                    <div class="form-group float-label mb-0">
                        {{ Form::input('password', 'password', null, ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'transparent', 'required']) }}
                        {{ Form::label('password', trans('validation.attributes.frontend.register-user.password')) }}
                    </div>

                    <div class="form-group mb-30">
                        <div class="checkbox">
                            <label>
                                {{ Form::checkbox('remember') }} {{ trans('labels.frontend.auth.remember_me') }}
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'btn btn-primary', 'style' => 'margin-right:15px']) }}
                        <a href="{{ route('frontend.auth.password.reset') }}" class="link-btn">{{ trans('labels.frontend.passwords.forgot_password') }}</a>
                    </div>

                    {{ Form::close() }}

                    <div class="row text-center">

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
