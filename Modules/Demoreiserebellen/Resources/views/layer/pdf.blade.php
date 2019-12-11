@extends('frontend.layouts.app')
@section('title')
    {{ getCurrentWhiteLabelName() }}
@endsection
@section('before-scripts')
    <style>
        body, html {height: 100%;}
        #app{display: none}
    </style>
    <object data="https://demoreiserebellen.reise-wunsch.com/pdfs/tnb_reiserebellen.pdf" type="application/pdf" style="height: 100%;width: 100%">
        <embed src="https://demoreiserebellen.reise-wunsch.com/pdfs/tnb_reiserebellen.pdf" type="application/pdf" />
    </object>
@endsection
