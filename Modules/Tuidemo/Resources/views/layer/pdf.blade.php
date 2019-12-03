@extends('frontend.layouts.app')
@section('title')
    {{ getCurrentWhiteLabelName() }}
@endsection
@section('before-scripts')
    <style>
        body, html {height: 100%;}
        #app{display: none}
    </style>
    <object data="https://tui.reise-wunsch.com/pdfs/tnb_tui.pdf" type="application/pdf" style="height: 100%;width: 100%">
        <embed src="https://tui.reise-wunsch.com/pdfs/tnb_tui.pdf" type="application/pdf" />
    </object>
@endsection
