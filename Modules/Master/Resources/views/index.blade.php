@extends('master::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from new module: {!! config('master.name') !!}
    </p>
@endsection