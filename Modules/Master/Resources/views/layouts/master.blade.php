@extends('frontend.layouts.app')

@section('title')
    {!! config('master.name') !!}
@endsection

@section('after-styles')
    <link rel="stylesheet" href="{{ mix('css/master.css') }}">
@endsection

@section('logo')
    <a href="{{ route('frontend.index') }}" class="logo">
        <img class="navbar-brand" src="/img/logo_tui.png">
    </a>
@endsection

@section('after-scripts')
    <script src="{{ mix('js/master.js') }}"></script>
@endsection
