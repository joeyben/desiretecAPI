@extends('frontend.layouts.app')
@section('title')
    {{ getCurrentWhiteLabelName() }}
@endsection
@section('before-scripts')
    <style>
        body, html {height: 100%;}
        #app{display: none}
    </style>
    <object data="https://testkurenundwellness.reise-wunsch.com/pdfs/tnb_kurenundwellness.pdf" type="application/pdf" style="height: 100%;width: 100%">
        <embed src="https://testkurenundwellness.reise-wunsch.com/pdfs/tnb_kurenundwellness.pdf" type="application/pdf" />
    </object>
@endsection
