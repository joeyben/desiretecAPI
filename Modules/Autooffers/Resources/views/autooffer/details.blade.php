@extends ('frontend.layouts.app')

@section ('title', trans('labels.backend.wishes.management') . ' | ' . trans('labels.backend.wishes.create'))

@section("after-styles")
    <link rel="stylesheet" href="{{ mix('modules/css/offers.css') }}">
@endsection

@section('page-header')
    <h1>
        {{ trans('labels.backend.wishes.management') }}
        <small>{{ trans('labels.backend.wishes.create') }}</small>
    </h1>
@endsection

@section('content')
<!-- CONTENT -->

<div class="row">
    <div class="col-sm-9">
        <div id="gallery" class="">
            <div class="main-image" style="background-image:url(https://a0.muscache.com/4ea/air/v2/pictures/85cd1227-6ebf-4164-9e95-12eeb1023e8d.jpg?t=r:w2500-h1500-sfit,e:fjpg-c90)"></div>
            <div class="side-image" style="background-image:url(https://a0.muscache.com/4ea/air/v2/pictures/563fe933-c9c3-49df-a366-162dccabb140.jpg?t=r:w2500-h1500-sfit,e:fjpg-c90)"></div>
            <div class="side-image" style="background-image:url(https://a0.muscache.com/4ea/air/v2/pictures/75587de5-88b9-4510-a087-1910fc6fca55.jpg?t=r:w2500-h1500-sfit,e:fjpg-c90)"></div>
            <div class="clearfix"></div>
            <a class="primary-btn">Fotogalerie ansehen</a>
        </div>
    </div>
    <div class="col-sm-3">

    </div>
</div>

<!-- END OF CONTENT -->
@endsection

@section("after-scripts")
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@endsection