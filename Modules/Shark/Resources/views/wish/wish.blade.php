@php
    $contactInactivClass = count($wish->contacts) ? " inactiv" : "";
    $callbackInactivClass = count($wish->callbacks) ? " inactiv" : "";
@endphp

@extends('frontend.layouts.app')
@section('title')
    {{ trans('general.whitelabel.browser.title') }}
@endsection

@section('before-styles')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,400italic,500,700,700italic,900" media="all">
@endsection

@section('after-styles')
    <link rel="stylesheet" href="{{ asset('whitelabel/shark/css/wish/details.css') }}">
    <link rel="stylesheet" href="{{ asset('whitelabel/shark/css/shark.css') }}">
@endsection


@section('content')
<section class="section-top">

    <div class="img-background">
        <div class="container">
            <div class="col-md-8 bg-left-content">
                @if ($logged_in_user->hasRole('User') && $wish->owner->first_name !== "Muster")
                    <h3>Hallo {{ $wish->owner->first_name }} {{ $wish->owner->last_name }},</h3>
                @elseif ($logged_in_user->hasRole('User') && $wish->owner->first_name)
                    <h3>Hallo lieber Kunde,</h3>
                @elseif ($logged_in_user->hasRole('Seller'))
                    <h3>Hallo {{ $logged_in_user->agents->where('status','Active')->first()->name }},</h3>
                @else
                    <h3>Hallo,</h3>
                @endif

                @if ($logged_in_user->hasRole('Seller') && $logged_in_user->allow('create-offer'))
                    <p class="header-p">{!! trans('wish.view.stage.seller_empty',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y')]) !!}</p>
                    <a href="{{route('frontend.offers.create', $wish->id)}}" class="primary-btn">{{ trans('buttons.wishes.frontend.create_offer')}}</a>
                @elseif (count($wish->offers) > 0)
                    <p class="header-p">{!! trans('wish.view.stage.user_offer',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => $wish->group->users[0]->name]) !!}</p>
                    <button class="primary-btn{{ $contactInactivClass }}" onclick="scrollToAnchor('angebote')">Angebot ansehen</button>
                @elseif (count($wish->messages) > 0)
                    <p class="header-p">{!! trans('wish.view.stage.user_message',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => $wish->group->users[0]->name]) !!}</p>
                    <button class="primary-btn{{ $contactInactivClass }}" onclick="scrollToAnchor('messages')">Nachricht ansehen</button>
                @else
                    <p class="header-p">{!! trans('wish.view.stage.user_empty',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => $wish->group->users[0]->name]) !!}</p>
                    <button class="primary-btn{{ $contactInactivClass }}" data-toggle="modal" data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
                    <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
                @endif
            </div>
        </div>
    </div>


        @if ($logged_in_user->hasRole('Seller') && count($wish->contacts) )
        <div class="bg-bottom">
            <div class="container">
                <h4>Kontaktdaten des Kunden</h4>
                <div class="row">
                    <div class="col-md-3 c-info">
                        <i class="fal fa-pencil"></i>
                        <span>{{ $wish->contacts[0]->subject }}</span>
                    </div>
                    <div class="col-md-3 c-info">
                        <i class="fas fa-user"></i>
                        <span>{{ $wish->contacts[0]->name }}</span>
                    </div>
                    <div class="col-md-3 c-info c-tel">
                        <i class="fas fa-phone"></i>
                        <a href="tel:{{ $wish->contacts[0]->telephone }}">{{ $wish->contacts[0]->telephone }}</a>
                    </div>
                    <div class="col-md-3 c-info">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:mail@reisebuero.de">{{ $wish->contacts[0]->email }}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p>
                           &nbsp;
                        </p>
                    </div>
                    <div class="col-md-12">
                        <h5>Nachricht:</h5>
                        <p>
                            {{ $wish->contacts[0]->message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
        </div>

        @elseif ($logged_in_user->hasRole('User'))
        <div class="bg-bottom">
            <div class="container">
                <h4>Zuständiges Reisebüro</h4>
                <div class="col-md-3">
                    <p>
                        {{ $wish->group->users[0]->name }}</p>
                    <p>
                        {{ $wish->group->users[0]->address }} <br>
                        {{ $wish->group->users[0]->zip_code }} {{ $wish->group->users[0]->city }}
                    </p>
                </div>
                @if(count($wish->offers) > 0 || count($wish->messages) > 0)
                    <div class="col-md-3 c-info">
                        <i class="fas fa-user"></i>
                        <span>{{ $wish->group->users[0]->agents[0]->name }}</span>
                    </div>
                    <div class="col-md-3 c-info c-tel">
                        <i class="fas fa-phone"></i>
                        <a href="tel:{{ $wish->group->users[0]->agents[0]->telephone }}">{{ $wish->group->users[0]->agents[0]->telephone }}</a>
                    </div>
                    <div class="col-md-3 c-info">
                        <i class="fas fa-envelope"></i>
                        <a href="mailto:mail@reisebuero.de">{{ $wish->group->users[0]->agents[0]->email }}</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="container">
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
        </div>

        @endif
</section>

@if (count($wish->offers) > 0 && $logged_in_user->hasRole('Seller') && count($wish->contacts) === 0)
    <div class="container">
        <div class="col-md-12">
            <p>&nbsp;</p>
        </div>
    </div>
@endif

@foreach($wish->offers as $key => $offer)

    <section class="section-angebote-2" id="angebote">
        <div class="container">
            <div class="col-md-12 sa2-1">
                <h4>
                    {{ trans('wish.view.new_offers') }}
                </h4>
                <p class="sa2-p1">Du hast {{ count($wish->offers) }} Angebote von <b>{{ $offer->owner->name }}</b>
                    @if ($logged_in_user->hasRole('Seller'))
                        erstellt
                    @else
                        erhalten
                    @endif
                </p>
                <p class="sa2-p2">
                    <span class="offer-avatar-cnt">
                        <img class="avatar" title="{{ $offer->agent->name }}" alt="{{ $offer->agent->name }}" src="{{ Storage::disk('s3')->url('img/agent/') }}{{ $offer->agent->avatar }}" />
                        <span class="agent-name">{{ $offer->agent->name }}</span>
                    </span>
                    <b>{{ $offer->title }}</b><br>
                    {{ $offer->description }}
                    @if ($offer->link)
                        <br><br>
                        <b>Hier geht es zu unserer Angebotsseite:</b> <a href="{{ $offer->link }}" target="_blank">{{ $offer->link }}</a>
                    @endif
                </p>
                @if (!$offer->offerFiles && $logged_in_user->hasRole('User'))
                <div class="sa2-buttons">
                    <button class="primary-btn{{ $contactInactivClass }}" data-toggle="modal" data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
                    <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
                </div>
                @endif
            </div>
        </div>
    </section>
    @if ($offer->offerFiles)
    <section class="section-angebote-download">
        <div class="container">
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
            <div class="col-md-12 sa-2">
                @foreach($offer->offerFiles as $key => $file)
                    <div class="col-md-4">
                        @if (strpos($file->file, '.pdf') !== false)
                            <i class="fal fa-file-pdf"></i>
                        @else
                            <i class="fal fa-file-image"></i>
                        @endif

                        <a href="{{ Storage::disk('s3')->url($offer_url . $file->file) }}" target="_blank">{{ trans('wish.view.offer_number') }} {{ $key+1 }}</a>
                    </div>
                @endforeach
            </div>
            @if ($logged_in_user->hasRole('User'))
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
            @endif
        </div>

        @if ($logged_in_user->hasRole('User'))
        <div class="container">
            <div class="col-md-12 sa-2">
                <div class="sa-buttons">
                    <button class="primary-btn{{ $contactInactivClass }}" data-toggle="modal" data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
                    <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
                </div>
            </div>
        </div>
        @endif
    </section>
  @endif

    <div class="container">
        <div class="col-md-12">
            <hr class="sad-hr">
        </div>
    </div>

@endforeach

@if (count($wish->offers) === 0 && $logged_in_user->hasRole('Seller') && count($wish->contacts) === 0)
    <div class="container">
        <div class="col-md-12">
            <p>&nbsp;</p>
        </div>
    </div>
@endif

<section class="section-comments" id="messages">
    <div class="container">
        <div class="col-md-12">
            <h4>
                Neue Nachrichten <span class="glyphicon glyphicon-bell"></span>
            </h4>
        <chat-messages :wishid="{{ $wish->id }}" :userid="{{ Auth::user()->id }}" :groupid="{{ $wish->group_id }}"></chat-messages>
    </div>
</section>

@if ($logged_in_user->hasRole('User') && count($wish->offers) == 0)
    <div class="container">
        <div class="col-md-12">
            <hr class="sad-hr">
        </div>
    </div>

    <div class="container">
        <div class="col-md-12 sa-2">
            <div class="sa-buttons">
                <button class="primary-btn{{ $contactInactivClass }}" data-toggle="modal" data-target="#contact_modal">{{ trans('wish.details.kontakt-button') }}</button>
                <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#callback">{{ trans('wish.details.callback-button') }}</button>
            </div>
        </div>
    </div>
@endif

<div class="container">
    <div class="col-md-12">
        <hr class="sad-hr">
    </div>
</div>

<section class="section-contact">
    <div class="container">
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
                <i class="fal fa-minus"></i>
                <input class="data-content">
            </div>
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
                <input class="data-content" value="{{ trans('layer.pets.-') }}">
            </div>
            @if ($logged_in_user->hasRole('User'))
            <button class="secondary-btn{{ $callbackInactivClass }}" data-toggle="modal" data-target="#edit-wish">Daten andern</button>
            @endif
        </div>

    </div>

</section>

<section class="section-contact-mobile">
    <div class="container">

        <div class="panel-group" id="accordion1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion1" href="#content">
                            <div class="col-md-12 s2-first">
                                <h4>{{ trans('wish.details.subheadline.your_wish') }}</h4>
                                <p>Dies sind Deine Angaben zu Deinem Reisewunsch.</p>
                            </div>
                            <span class="glyphicon glyphicon-plus"></span></a>
                        <span class="glyphicon glyphicon-minus"></span></a>
                    </h4>
                </div>

                <div id="content" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="col-md-12 s2-first">
                            <p><b>{{ trans('wish.details.subheadline.your_message') }}</b><br>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec purus libero, tempor eget mi vel,
                                pellentesque sodales dui. Nam pharetra neque et nibh vehicula, ut rutrum orci varius.
                                In quis sapien non turpis fermentum venenatis quis sed felis. Sed commodo scelerisque metus, consequat tempor turpis consectetur nec. Nullam a fermentum dolor.
                            </p>
                        </div>
                        <div class="col-md-12 s2-second">
                            <div class="col-md-3">
                                <i class="fal fa-minus"></i>
                                <input class="data-content" >
                            </div>
                            <div class="col-md-3">
                                <i class="fal fa-calendar-alt"></i>
                                <input class="data-content" value="{{ \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.y') }} - {{ \Carbon\Carbon::parse($wish->latest_return)->format('d.m.y') }}">
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
                                <i class="fal fa-star"></i>
                                <input class="data-content" value="{{ $wish->kids }} Sterne">
                            </div>
                            <div class="col-md-3">
                                <i class="fal fa-dog"></i>
                                <input class="data-content" value="{{ trans('layer.pets.-') }}">
                            </div>
                            @if ($logged_in_user->hasRole('User') && $is_owner)
                                <button class="secondary-btn{{ $callbackInactivClass }}">Daten andern</button>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
</section>


<div class="container">
    <div class="col-md-12">
        <hr class="sad-hr">
    </div>
</div>

{{-- @include('frontend.wishes.partials.faq') --}}
@section('footer')
    @include('shark::layouts.footer')
@endsection

<!-- Modal -->
<div id="contact_modal" class="modal wish-modal-1 fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="alert alert-success alert-dismissible fade" role="alert">
                <span class="text"></span>
                <a class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            {{ Form::open(['route' => 'frontend.contact.store', 'class' => 'form-horizontal contact_form', 'role' => 'form', 'method' => 'POST', 'id' => 'contact-seller']) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('wish.contact.title') }}</h4>
                <p>{{ trans('wish.contact.text') }}</p>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <p class="statusMsg"></p>
                    <div class="col-md-8 modal-body-left">

                        <div class="group">
                            <input type="text" class="form-control name" name="first_name" id="first_name" required>
                            <label>Name</label>
                        </div>
                        <div class="group">
                            <input type="text" class="form-control nachname" name="last_name" id="last_name" required>
                            <label>Nachname</label>
                        </div>
                        <div class="group">
                            <input type="text" class="form-control email" name="email" id="email" required value="{{ $wish->owner->email }}">
                            <label>E-Mail-Adresse</label>
                        </div>
                        <div class="group">
                            <input type="text" class="form-control tel" name="telephone" id="telephone" >
                            <label>Telefon-Nr.(optional)</label>
                        </div>
                        <div class="group">
                            <input type="text" class="form-control betreff" name="subject" id="subject" >
                            <label>Betreff</label>
                        </div>

                    </div>

                    <div class="col-md-4 modal-body-right">
                        <img src="/img/frontend/profile-picture/travel-agency.jpg" alt="">
                        <h4>{{ $wish->group->users[0]->name }}</h4>
                        <p>{{ $wish->group->users[0]->address }}<br>
                            {{ $wish->group->users[0]->zip_code }} {{ $wish->group->users[0]->city }}
                        </p>
                        <div class="modal-contact">
                            <div class="mc-tel">
                                <span class="glyphicon glyphicon-earphone"></span>
                                <a href="tel:08971459535">@if(count($wish->group->users[0]->agents)){{ $wish->group->users[0]->agents[0]->telephone }}@endif</a>
                            </div>
                            <div class="mc-mail">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <a href="mailto:mail@reisebuero.de">@if(count($wish->group->users[0]->agents)){{ $wish->group->users[0]->agents[0]->email }}@endif</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 modal-body-bottom">
                        <textarea name="message" id="modal-textarea" class="form-control" placeholder="Worum geht es? Deine Nachricht an uns."></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <input type="hidden" name="wish_id" value="{{ $wish->id }}" />
                <input type="hidden" name="period" value="no data" />
                <input type="submit" class="primary-btn wm-1-btn" value="Nachricht absenden" />
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<div id="callback" class="modal wish-modal-1 fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="alert alert-success alert-dismissible fade" role="alert">
                <span class="text"></span>
                <a class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            {{ Form::open(['route' => 'frontend.contact.storecallback', 'class' => 'form-horizontal contact_form', 'role' => 'form', 'method' => 'POST', 'id' => 'callback-seller']) }}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ trans('wish.callback.title') }}</h4>
                <p>{{ trans('wish.callback.text') }}
                </p>
            </div>

            <div class="modal-body">
                <div class="container-fluid">

                    <div class="col-md-8 modal-body-left">

                        <div class="group">
                            <input type="text" class="form-control name" name="first_name" id="first_name_" required>
                            <label>Vorname</label>
                        </div>
                        <div class="group">
                            <input type="text" class="form-control nachname" name="last_name" id="first_name_" required>
                            <label>Nachname</label>
                        </div>
                        <div class="group">
                            <input type="text" class="form-control tel" name="telephone" id="telephone_" required>
                            <label>Telefon-Nr unter der wir dich erreichen</label>
                        </div>
                        <div class="group">
                            <select name="period" id="period_" class="form-control">
                                <option value="">Wähle einen Zeitraum</option>
                                <option value="vormittags" id="">vormittags</option>
                                <option value="nachmittags" id="">nachmittags</option>
                                <option value="abends" id="">abends</option>
                            </select>
                        </div>

                        <input type="hidden" name="wish_id" value="{{ $wish->id }}" />
                        <input type="hidden" name="subject" value="no data" />
                        <input type="hidden" name="message" value="no data" />
                        <input type="hidden" name="email" value="no data" />

                        <button type="submit" class="primary-btn wm-2-btn">Nachricht absenden</button>
                    </div>

                    <div class="col-md-4 modal-body-right">
                        <img src="/img/frontend/profile-picture/travel-agency.jpg" alt="">
                        <h4>{{ $wish->group->users[0]->name }}</h4>
                        <p>{{ $wish->group->users[0]->address }}<br>
                            {{ $wish->group->users[0]->zip_code }} {{ $wish->group->users[0]->city }}
                        </p>
                        <div class="modal-contact">
                            <div class="mc-tel">
                                <span class="glyphicon glyphicon-earphone"></span>
                                <a href="tel:08971459535">@if(count($wish->group->users[0]->agents)){{ $wish->group->users[0]->agents[0]->telephone }}@endif</a>
                            </div>
                            <div class="mc-mail">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <a href="mailto:mail@reisebuero.de">@if(count($wish->group->users[0]->agents)){{ $wish->group->users[0]->agents[0]->email }}@endif</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">

            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

@if (false && $logged_in_user->hasRole('User') && $is_owner)
    <div id="edit-wish" class="modal wish-modal-1 fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="alert alert-success alert-dismissible fade" role="alert">
                    <span class="text"></span>
                    <a class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                {{ Form::open(['route' => ['frontend.wishes.update', $wish], 'class' => 'form-horizontal contact_form', 'role' => 'form', 'method' => 'POST', 'id' => 'update-wish']) }}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('wish.edit.title') }}</h4>
                    <p>{{ trans('wish.edit.text') }}
                    </p>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">

                        <div class="col-md-12 modal-body-left">
                            <div class="row row-no-padding">
                                <div class="group col-md-6">
                                    <input class="form-control" value="{{ \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.y') }}">
                                    <label>Von</label>
                                </div>
                                <div class="group col-md-6">
                                    <input class="form-control" value="{{ \Carbon\Carbon::parse($wish->latest_return)->format('d.m.y') }}">
                                    <label>Bis</label>
                                </div>
                            </div>
                            <div class="row row-no-padding">
                                <div class="group col-md-6">
                                    {{ Form::select('duration', array_merge(['' => trans('layer.general.duration_empty')], $duration_arr), $wish->durationval, ['class' => 'form-control']) }}
                                </div>
                                <div class="group col-md-6">
                                    <input class="form-control" value="{{  number_format($wish->budget, 0, ',', '.') }}€">
                                    <label>Budget</label>
                                </div>
                            </div>
                            <div class="row row-no-padding">
                                <div class="group col-md-6">
                                    {{ Form::text('destination',  $wish->destination  ? $wish->destination  : null, ['class' => 'form-control','autocomplete' => "off", 'placeholder' => trans('layer.placeholder.destination'), 'required' => 'required']) }}
                                    <label>Destination</label>
                                </div>
                                <div class="group col-md-6">
                                    {{ Form::select('adults', $adults_arr, $wish->adults ? $wish->adults : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                </div>
                            </div>
                            <div class="row row-no-padding">
                                <div class="group col-md-6">
                                    {{ Form::select('kids', $kids_arr, $wish->kids ? $wish->kids : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                </div>
                                <div class="group col-md-6">
                                    {{ Form::select('pets', $pets_arr, $wish->pets ? $wish->pets : null, ['class' => 'form-control box-size', 'required' => 'required']) }}
                                </div>
                            </div>

                            <div class="row row-no-padding">
                                <div class="group col-md-6">

                                </div>
                                <div class="group col-md-6">
                                    <button type="submit" class="primary-btn wm-2-btn full">{{ trans('wish.edit.save') }}</button>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">

                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endif

@if ($logged_in_user->hasRole('User') && $is_owner)
    <wish-edit-modal v-bind:wish_id="{{ $wish->id }}"
                     v-bind:adults_arr="{{ json_encode($adults_arr) }}"
                     v-bind:duration_arr="{{ json_encode(array_merge(['' => trans('layer.general.duration_empty')], $duration_arr)) }}"
    ></wish-edit-modal>
@endif

@endsection

@section('before-scripts')

    <script src="{{ mix('whitelabel/shark/js/shark.js') }}"></script>
@endsection

@section('after-scripts')

    <script type="application/javascript">
        function scrollToAnchor(id) {
            $('html, body').animate({
                scrollTop: $("#"+id).offset().top - 75
            }, 1000);
        }
    </script>
@endsection
