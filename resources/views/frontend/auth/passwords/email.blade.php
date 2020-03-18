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

        <div class="col-md-6 col-md-offset-4">
            @include('includes.alert')
        </div>

        <div class="col-md-6 col-md-offset-4">

            <div class="panel panel-default">

                <div class="panel-heading">{{ trans('labels.frontend.passwords.reset_password_box_title') }}</div>

                <div class="panel-body">

                    {{ Form::open(['route' => 'frontend.auth.password.email', 'class' => 'form-horizontal']) }}

                    <div class="form-group float-label">
                        {{ Form::input('email', 'email', null, ['id' => 'email', 'class' => 'form-control', 'placeholder' => 'transparent']) }}
                        {{ Form::label('email', trans('validation.attributes.frontend.register-user.email')) }}
                    </div>

                    <div class="form-group">
                        {{ Form::submit(trans('labels.frontend.passwords.send_password_reset_link_button'), ['class' => 'btn btn-primary']) }}
                    </div>

                    {{ Form::close() }}

                </div>

            </div>

        </div>

    </div>
@endsection
