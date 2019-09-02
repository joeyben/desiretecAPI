@if ($logged_in_user->hasRole('Seller'))
    <div class="col-md-12 s2-first">
        <h4>Reisewunsch Angaben</h4>
        <p>Dies sind die Angaben zum Reisewunsch.</p>
        <p><b>Kundennachricht:</b><br>
            {{ $wish->description }}
        </p>
    </div>
@else
    <div class="col-md-12 s2-first">
        <h4>Dein Reisewunsch</h4>
        <p>Dies sind Deine Angaben zu Deinem Reisewunsch.</p>
        <p><b>Deine Nachricht:</b><br>
            {{ $wish->description }}
        </p>
    </div>
@endif


<div class="col-md-12 s2-second">

    <div class="col-md-3">
        <i class="fal fa-plane-departure"></i>
        <input class="data-content" value="{{ $wish->airport }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-calendar-alt"></i>
        <input class="data-content" value="{{ \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($wish->latest_return)->format('d.m.Y') }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-usd-circle"></i>
        <input class="data-content" value="{{  number_format($wish->budget, 0, ',', '.') }}€">
    </div>
    <div class="col-md-3">
        <i class="fal fa-star"></i>
        <input class="data-content" value="{{ $wish->category }} Sterne">
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
        <i class="fal fa-stopwatch"></i>
        <input class="data-content" value="{{ $wish->duration }}">
    </div>
    <div class="col-md-3">
        <i class="fal fa-utensils"></i>
        <input class="data-content" value="{{ $categories->getCategoryByParentValue('catering', $wish->catering) }}">
    </div>
    <button class="secondary-btn">Daten andern</button>
</div>