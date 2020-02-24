@extends('layouts.default')
@section('title')
    Language Lines
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">{{ __('menus.footer_tnb') }}</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">{{ __('menus.footer_tnb') }}</span>
    </div>
@stop

@section('content')
    <!-- Language Filter -->
    <div class="content" id="footerTnbComponent">
        @include('includes.alert')
        {{ Form::open(['route' => 'provider.footer.tnb.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'footerTnbForm']) }}
        <div class="card">
            <div class="card-header">
                <a href="#" class="dropdown-toggle language_select_label" data-toggle="dropdown">{{$result['data']['language']}}</a>
                <div class="dropdown-menu">
                    @foreach(array_keys(config()->get('locale')['languages']) as $lang)
                        <a href="{{ route('provider.footer.tnb', $lang) }}" value="{{ $lang }}" class="dropdown-item">{{ $lang }}</a>
                    @endforeach
                </div>
            </div>
            <div class="card-body">
                <div class="form-group row">
                    {{ Form::textarea('footer_tnb_editor', $result['data']['text'], ['id' => 'footerTnbEditor', 'name' => 'footer_tnb_editor', 'class' => 'form-control']) }}
                </div>
                <div class="form-group row">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" name="checkbox" class="form-check-input">
                            <p class="font-italic font-size-xs">
                                 <span class="font-weight-black">@lang('tnb.title')</span>
                                 @lang('tnb.message')
                            </p>
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                {{ Form::submit(trans('button.save'), ['class' => 'btn', 'style' => 'background-color: rgb(19, 206, 102); border-color: rgb(19, 206, 102); color: white;']) }}
            </div>
        </div>
        {{ Form::close() }}
    </div>
    <!-- /Language Filter-->
@stop

@section('after-scripts')    <script src="https://cdn.ckeditor.com/4.13.0/full-all/ckeditor.js"></script>
<script>
  CKEDITOR.plugins.addExternal( 'lineheight', "{!! asset('js/lineheight/plugin.js') !!}" );
  CKEDITOR.replace('footerTnbEditor', {
    height: 400,
    baseFloatZIndex: 10005,
    width: '100%',
    height: '15em',
    removeButtons: 'Anchor,ShowBlocks,CreateDiv,Flash,PageBreak,Iframe',
    removePlugins: 'elementspath',
    extraPlugins: 'lineheight',
    enterMode: CKEDITOR.ENTER_BR,
    toolbarGroups: [
      { name: 'styles' },
      { name: 'editing', groups: ['lineheight'] },
      { name: 'insert', groups: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar'] },
      '/',
      { name: 'colors' },
      { name: 'clipboard' },
      { name: 'links' },
      { name: 'basicstyles' },
      { name: 'tools' },
      { name: 'paragraph', groups: ['list','blocks'] },
    ]
  });
  $("#footerTnbForm").submit( function(eventObj) {
    $("<input />").attr("type", "hidden")
      .attr("name", "language")
      .attr("value", "{!! $result['data']['language'] !!}")
      .appendTo("#footerTnbForm");
    return true;
  });
</script>
@stop
