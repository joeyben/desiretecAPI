@extends('frontend.layouts.app')

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

                <div class="panel-heading">{{ trans('labels.frontend.passwords.reset_password_box_title') }}</div>

                <div class="panel-body">

                    {{ Form::open(['route' => 'frontend.auth.password.reset', 'class' => 'form-horizontal']) }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group mb-30">
                        <p class="form-control-static">{{ $email }}</p>
                        {{ Form::input('hidden', 'email', $email, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
                    </div>

                    <div class="form-group float-label">
                        {{ Form::input('password', 'password', null, ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
                        {{ Form::label('password', trans('validation.attributes.frontend.register-user.password')) }}
                    </div>

                    <div class="form-group float-label">
                        {{ Form::input('password', 'password_confirmation', null, ['id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
                        {{ Form::label('password_confirmation', trans('validation.attributes.frontend.register-user.password_confirmation')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit(trans('labels.frontend.passwords.reset_password_button'), ['class' => 'btn btn-primary']) }}
                    </div>

                    {{ Form::close() }}

                </div>

            </div>

        </div>

    </div>
@endsection
