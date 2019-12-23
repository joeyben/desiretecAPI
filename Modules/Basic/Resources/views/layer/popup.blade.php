@if (isset($color))
<script type="application/javascript">
    var brandColor = {!! json_encode($color) !!};
</script>
@endisset


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<link media="all" type="text/css" rel="stylesheet" href="https://mvp.desiretec.com/fontawsome/css/all.css">
<link rel="stylesheet" href="/whitelabel/basic/css/layer-responsive.css">

    {{--Tabs --}}
    @if(count($layers) > 1)
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            @foreach($layers as $layer)
                    <a class="nav-item nav-link @if($layer['active']) active @endif" id="nav-{{ $layer['name'] }}-tab" data-toggle="tab" href="#nav-{{ $layer['name'] }}" role="tab" aria-controls="nav-{{ $layer['name'] }}" aria-selected="true">
                        {{ $layer['name'] }}
                    </a>
            @endforeach
        </div>
    @endif

    {{-- Content --}}
    <div class="tab-content" id="nav-tabContent">
        @foreach($layers as $layer)
            @include('basic::layer._parts.'.strtolower($layer['name']),[
                'layer' => $layer
            ])
        @endforeach
    </div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>




