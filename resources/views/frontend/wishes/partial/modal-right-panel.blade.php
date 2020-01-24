@if(count($wish->offers) > 0 || count($wish->sellerMessages) > 0)
    @php
        $agent = $wish->agent()->first();
        if (is_null($agent)) {
            $agent = $wish->group->users[0]->currentAgent[0];
        }
    @endphp
    <div class="col-md-4 modal-body-right">
        <img title="{{ $agent->name }}" alt="{{ $agent->name }}" src="{{ Storage::disk('s3')->url('img/agent/') }}{{ $agent->avatar }}" />
        <h4>{{ $agent->name }}</h4>
        <div class="modal-contact">
            <div class="mc-tel">
                <span class="glyphicon glyphicon-earphone"></span>
                <a href="tel:{{ $agent->telephone }}">{{ $agent->telephone }}</a>
            </div>
            <div class="mc-mail">
                <span class="glyphicon glyphicon-envelope"></span>
                <a href="mailto:@if(!is_null($agent)){{ $agent->email }}@endif">@if(!is_null($agent)){{ $agent->email }}@endif</a>
            </div>
        </div>
    </div>
@else
    <div class="col-md-4 modal-body-right">
        <img src="/img/frontend/profile-picture/travel-agency.jpg" alt="">
        <h4>{{ $wish->group->users[0]->name }}</h4>
        <p>{{ $wish->group->users[0]->address }}<br>
            {{ $wish->group->users[0]->zip_code }} {{ $wish->group->users[0]->city }}
        </p>
        <div class="modal-contact">
            <div class="mc-mail">
                <span class="glyphicon glyphicon-envelope"></span>
                <a href="mailto:{{ $wish->group->users[0]->email }}">{{ $wish->group->users[0]->email }}</a>
            </div>
        </div>
    </div>
@endif
