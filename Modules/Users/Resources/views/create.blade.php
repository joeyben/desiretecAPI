@extends('layouts.default')
@section('title')
    {{ trans('labels.backend.access.users.create') }}
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold"> {{ trans('labels.backend.access.users.create') }}</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">{{ trans('labels.backend.access.users.create') }}</span>
    </div>
@stop

@section('after-styles')
    <style>
        #permissions-list
        {
            height: 400px;
            overflow-x: scroll;
        }
    </style>
@stop

@section('vue-js')
    <script src="{{ asset('js/modules/admin/users/edit.js') }}"></script>
@stop
@section('content')
    @include('includes.alert')
    <!-- Basic card -->
    <div class="card">
        <div class="card-header header-elements-inline">
            <div class="card-title">
                <div class="box-header with-border">
                    <div class="box-tools pull-right">
                        @include('backend.access.includes.partials.user-header-buttons')
                    </div><!--box-tools pull-right-->
                </div><!-- /.box-header -->
            </div>
        </div>
        <div class="card-body">
            {{ Form::open(['route' => 'admin.access.user.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) }}

            <div class="form-group row">
                {{ Form::label('name', trans('validation.attributes.backend.access.users.firstName'), ['class' => 'col-lg-3 col-form-label required']) }}
                <div class="col-lg-9">
                    {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.users.firstName'), 'required' => 'required']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('name', trans('validation.attributes.backend.access.users.lastName'), ['class' => 'col-lg-3 col-form-label required']) }}

                <div class="col-lg-9">
                    {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.users.lastName'), 'required' => 'required']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('email', trans('validation.attributes.backend.access.users.email'), ['class' => 'col-lg-3 col-form-label required']) }}

                <div class="col-lg-9">
                    {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.users.email'), 'required' => 'required']) }}
                </div>
            </div>


            <div class="form-group row">
                {{ Form::label('password', trans('validation.attributes.backend.access.users.password'), ['class' => 'col-lg-3 col-form-label required']) }}

                <div class="col-lg-9">
                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.users.password'), 'required' => 'required']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('password_confirmation', trans('validation.attributes.backend.access.users.password_confirmation'), ['class' => 'col-lg-3 col-form-label required']) }}

                <div class="col-lg-9">
                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.access.users.password_confirmation'), 'required' => 'required']) }}
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('status', trans('validation.attributes.backend.access.users.active'), ['class' => 'col-lg-3 col-form-label']) }}

                <div class="col-lg-9">
                    <div class="form-check">
                        <label class="form-check-label">
                            {{ Form::checkbox('status', '1', true, ['class' => 'form-check-input']) }}
                            &nbsp;
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                {{ Form::label('confirmed', trans('validation.attributes.backend.access.users.confirmed'), ['class' => 'col-lg-3 col-form-label']) }}

                <div class="col-lg-9">
                    <div class="form-check">
                        <label class="form-check-label">
                            {{ Form::checkbox('confirmed', '1', true, ['class' => 'form-check-input']) }}
                            &nbsp;
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label">{{ trans('validation.attributes.backend.access.users.send_confirmation_email') }}<br/>
                    <small>{{ trans('strings.backend.access.users.if_confirmed_off') }}</small>
                </label>

                <div class="col-lg-9">
                    <div class="form-check">
                        <label class="form-check-label">
                            {{ Form::checkbox('confirmation_email', '1', false, ['class' => 'form-check-input']) }}
                            &nbsp;
                            <div class="control__indicator"></div>
                        </label>
                    </div>
                </div>
            </div>
            @if (auth()->guard('web')->user()->hasRole('Administrator'))
                <div class="form-group row">
                    {{ Form::label('whitelabels', trans('validation.attributes.backend.access.users.associated_whitelabels'), ['class' => 'col-lg-3 col-form-label']) }}

                    <div class="col-lg-9">
                        @if (count($whitelabels) > 0)
                            @foreach($whitelabels as $whitelabel)
                                <div class="form-check">
                                    <label for="whitelabel-{{$whitelabel->id}}" class="form-check-label">
                                        <input type="checkbox" value="{{$whitelabel->id}}" name="whitelabels[]" id="whitelabel-{{$whitelabel->id}}" class="form-check-input"  />  &nbsp;&nbsp;{!! $whitelabel->name !!}
                                        <div class="control__indicator"></div>
                                    </label>
                                </div>
                            @endforeach
                        @else
                            {{ trans('labels.backend.access.users.no_whitelabels') }}
                        @endif
                    </div>
                </div>
            @endif

            @if (auth()->guard('web')->user()->hasRole('Executive'))
                <div class="form-group row">
                    {{ Form::label('whitelabels', trans('validation.attributes.backend.access.users.associated_whitelabels'), ['class' => 'col-lg-3 col-form-label']) }}

                    <div class="col-lg-9">
                        @if (count($whitelabels) > 0)
                            @foreach($whitelabels as $whitelabel)
                                @if (isset($userWhitelabels) && in_array($whitelabel->id, $userWhitelabels))
                                    <div class="form-check">
                                        <label for="whitelabel-{{$whitelabel->id}}" class="form-check-label">
                                            <input type="checkbox"  value="{{$whitelabel->id}}" name="whitelabels[]" id="whitelabel-{{$whitelabel->id}}" class="form-check-input"  {{ isset($userWhitelabels) && in_array($whitelabel->id, $userWhitelabels) ? 'checked' : '' }}/>  {!! $whitelabel->name !!}
                                            <div class="control__indicator"></div>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            {{ trans('labels.backend.access.users.no_whitelabels') }}
                        @endif
                    </div>
                </div>
            @endif

            <div class="form-group row">
                {{ Form::label('associated_roles', trans('validation.attributes.backend.access.users.associated_roles'), ['class' => 'col-lg-3 col-form-label']) }}
                <div class="col-lg-9">
                    @if (count($roles) > 0)
                        @foreach($roles as $role)
                            @if (auth()->guard('web')->user()->hasRole('Administrator'))
                                <div>
                                    <label for="role-{{$role->id}}" class="control" id="roles-list">
                                        <input type="radio" value="{{$role->id}}" name="assignees_roles[]" id="role-{{$role->id}}" class="get-role-for-permissions" {{ $role->id == 3 ? 'checked' : '' }} />  &nbsp;&nbsp;{!! $role->name !!}
                                        <div class="control__indicator"></div>
                                        <a data-role="role_{{$role->id}}" class="show-permissions small" data-toggle="collapse" href="#collapse-link-collapsed-{{ $role->id }}">
                                            (
                                            <span class="show-text">{{ trans('labels.general.show') }}</span>
                                            <span class="hide-text hidden">{{ trans('labels.general.hide') }}</span>
                                            {{ trans('labels.backend.access.users.permissions') }}
                                            )
                                        </a>
                                    </label>
                                </div>
                                <div class="permission-list collapse" data-role="role_{{$role->id}}" id="collapse-link-collapsed-{{ $role->id }}">
                                    @if ($role->all)
                                        {{ trans('labels.backend.access.users.all_permissions') }}
                                    @else
                                        @if (count($role->permissions) > 0)
                                            <blockquote class="small">
                                                @foreach ($role->permissions as $perm)
                                                    <span data-id="{{ $perm->id }}"> {{$perm->display_name}} </span><br/>
                                                @endforeach
                                            </blockquote>
                                        @else
                                            {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
                                        @endif
                                    @endif
                                </div><!--permission list-->
                            @elseif(auth()->guard('web')->user()->hasRole('Executive') && ($role->name === 'Seller'))
                                <div>
                                    <label for="role-{{$role->id}}" class="control" id="roles-list">
                                        <input type="checkbox" value="{{$role->id}}" name="assignees_roles[]" id="role-{{$role->id}}" class="get-role-for-permissions" checked/>  &nbsp;&nbsp;{!! $role->name !!}
                                        <div class="control__indicator"></div>
                                        <a data-role="role_{{$role->id}}" class="show-permissions small" data-toggle="collapse" href="#collapse-link-collapsed-{{ $role->id }}">
                                            (
                                            <span class="show-text">{{ trans('labels.general.show') }}</span>
                                            <span class="hide-text hidden">{{ trans('labels.general.hide') }}</span>
                                            {{ trans('labels.backend.access.users.permissions') }}
                                            )
                                        </a>
                                    </label>
                                </div>
                                <div class="permission-list collapse" data-role="role_{{$role->id}}" id="collapse-link-collapsed-{{ $role->id }}">
                                    @if ($role->all)
                                        {{ trans('labels.backend.access.users.all_permissions') }}
                                    @else
                                        @if (count($role->permissions) > 0)
                                            <blockquote class="small">
                                                @foreach ($role->permissions as $perm)
                                                    <span data-id="{{ $perm->id }}"> {{$perm->display_name}} </span><br/>
                                                @endforeach
                                            </blockquote>
                                        @else
                                            {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
                                        @endif
                                    @endif
                                </div><!--permission list-->
                            @endif
                        @endforeach
                    @else
                        {{ trans('labels.backend.access.users.no_roles') }}
                    @endif
                </div>
            </div>
            <input type="checkbox" class="form-check-input" name="permissions[]" value="" checked style="display: none"/>
            @if (auth()->guard('web')->user()->hasRole('Administrator'))
            <div class="form-group row hidden">
                {{ Form::label('associated-permissions', trans('validation.attributes.backend.access.roles.associated_permissions'), ['class' => 'col-lg-3 col-form-label']) }}
                <div class="col-lg-9" id="permissions-list">
                    @if ($permissions)
                        @foreach ($permissions as $id => $display_name)

                                <div class="form-check">
                                    <label class="form-check-label" for="perm_{{ $id }}">
                                        <input type="checkbox" class="form-check-input" name="permissions[{{ $id }}]" value="{{ $id }}" id="perm_{{ $id }}" {{ isset($userPermissions) && in_array($id, $userPermissions) ? 'checked' : '' }} /> {{ $display_name }}
                                        <div class="control__indicator"></div>
                                    </label>
                                </div>
                        @endforeach
                    @else
                        <p>There are no available permissions.</p>
                    @endif
                </div>
            </div>
            @endif
            {{-- Buttons --}}
            <div class="edit-form-btn">
                {{ link_to_route('admin.access.user.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                <div class="clearfix"></div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@stop

