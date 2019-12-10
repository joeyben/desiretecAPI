@extends('frontend.layouts.app')
@section('title')
    {{ getCurrentWhiteLabelName() }}
@endsection
@section('before-scripts')
    <style>
        body, html {height: 100%;}
        #app{display: none}
    </style>
    <object data="https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/pdf/tnb_traveloverland.pdf" type="application/pdf" style="height: 100%;width: 100%">
        <embed src="https://desiretec.s3.eu-central-1.amazonaws.com/uploads/whitelabels/pdf/tnb_traveloverland.pdf" type="application/pdf" />
    </object>
@endsection
