@if ($logged_in_user->hasRole('Seller'))
    <div class="col-md-12 s2-first">
        <h4>{{ trans('wish.details.subheadline.giving_wish') }}</h4>
        <p>{{ trans('wish.details.subheadline.giving_wish_sub') }}</p>
        <p><b>Kundennachricht:</b><br>
            {{ $wish->description }}
        </p>
    </div>
@else
    <div class="col-md-12 s2-first">
        <h4>{{ trans('wish.details.subheadline.your_wish') }}</h4>
        <p>{{ trans('wish.details.subheadline.your_wish_sub') }}</p>
        <p><b>Deine Nachricht:</b><br>
            {{ $wish->description }}
        </p>
    </div>
@endif


<div class="col-md-12 s2-second">
    <div class="col-md-3">
        <i class="fal fa-calendar-alt"></i>
        <input class="data-content" value="{{ \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($wish->latest_return)->format('d.m.Y') }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-stopwatch"></i>
        <input class="data-content" value="{{ $wish->duration }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-usd-circle"></i>
        <input class="data-content" value="{{  number_format($wish->budget, 0, ',', '.') }}€">
    </div>
    <div class="col-md-3">
        <i class="fal fa-plane-arrival"></i>
        <input class="data-content" value="{{ $wish->destination }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-users"></i>
        <input class="data-content" value="{{ $wish->adults }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-child"></i>
        <input class="data-content" value="{{ $wish->kids }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-dog"></i>
        <input class="data-content" value="{{ trans('layer.pets.'.$wish->categories[0]->value) }}">
    </div>
    <div class="col-md-3">
        &nbsp;
        <input class="data-content">
    </div>
    @if ($logged_in_user->hasRole('User') && false)
        <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#edit-wish">Daten andern</button>
    @endif
</div>