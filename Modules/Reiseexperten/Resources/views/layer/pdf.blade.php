@extends('frontend.layouts.app')
@section('title')
    {{ getCurrentWhiteLabelName() }}
@endsection
@section('before-scripts')
    <style>
        body, html {height: 100%;}
        #app{display: none}
    </style>
    <object data="https://reiseexperten.reise-wunsch.com/pdfs/tnb_REISEEXPERTEN.pdf" type="application/pdf" style="height: 100%;width: 100%">
        <embed src="https://reiseexperten.reise-wunsch.com/pdfs/tnb_REISEEXPERTEN.pdf" type="application/pdf" />
    </object>
@endsection
