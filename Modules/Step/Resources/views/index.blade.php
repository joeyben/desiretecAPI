@extends('step::layouts.master')
@section('title')
    {{ trans('Step Management') }}
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold"> {{ trans('Step Management') }}</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">{{ trans('Step Management') }}</span>
    </div>
@stop
@section('vue-js')
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="rolesComponent">
        @include('includes.alert')
        <div class="row">
            <div class="col-md-12">
                <div class="card card-body border-top-primary text-center">
                    <h6 class="mb-0 font-weight-semibold">
                        {{ Auth::user()->whitelabels()->first()->display_name }}
                        <span class="badge bg-warning-400 align-self-center ml-auto">In Bearbeitung</span>
                    </h6>
                    <p class="mb-3 text-muted">Bitte geben Sie die erforderlichen Informationen für jeden Schritt ein</p>

                    <div class="progress mb-3">
                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: {{ $quote }}%">
                            <span>{{ $quote }}% Complete</span>
                        </div>
                    </div>

                    <div>
                        @if(current_step() < \App\Services\Flag\Src\Flag::MAX_STEP)
                            <a role="button" class="btn bg-blue-400" href="{{ Flag::step()[current_step()]['url'] }}">{{ Flag::step()[current_step()]['name'] }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

