@if(is_step_finished())
    @include('layouts.app_default')
@else
    @include('step::layouts.master')
@endif
