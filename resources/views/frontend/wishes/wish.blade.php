@extends('frontend.layouts.app')

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
                    <button class="primary-btn" onclick="scrollToAnchor('angebote')">Angebot ansehen</button>
                @elseif (count($wish->messages) > 0)
                    <p class="header-p">{!! trans('wish.view.stage.user_message',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => $wish->group->users[0]->name]) !!}</p>
                    <button class="primary-btn" onclick="scrollToAnchor('messages')">Nachricht ansehen</button>
                @else
                    <p class="header-p">{!! trans('wish.view.stage.user_empty',['date' => \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y'), 'seller' => $wish->group->users[0]->name]) !!}</p>
                    <button class="primary-btn" data-toggle="modal" data-target="#contact_modal">Reisebüro kontaktieren</button>
                    <button class="secondary-btn" data-toggle="modal" data-target="#myModal2">Rückrufbitte einstellen</button>
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
                @if(count($wish->group->users[0]->agents))
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

@if (count($wish->offers) > 0)
    <section class="section-angebote-2" id="angebote">
        <div class="container">
            <div class="col-md-12 sa2-1">
                <h4>
                    {{ trans('wish.view.new_offers') }}
                </h4>
                <p class="sa2-p1">Du hast {{ count($wish->offers) }} Angebote</b>
                    @if ($logged_in_user->hasRole('Seller'))
                        erstellt
                    @else
                        erhalten
                    @endif
                </p>
            </div>
        </div>
    </section>
@endif

@foreach($wish->offers as $key => $offer)

    <section class="section-angebote-2" id="angebote">
        <div class="container">
            <div class="col-md-12 sa2-1">
                <h4>Angebot {{ $key+1 }}</h4>
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
                    <button class="primary-btn" data-toggle="modal" data-target="#contact_modal">Reisebüro kontaktieren</button>
                    <button class="secondary-btn" data-toggle="modal" data-target="#myModal2">Rückrufbitte einstellen</button>
                </div>
                @endif
            </div>
        </div>
    </section>
    @if (count($offer->offerFiles) > 0)
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
                    <button class="primary-btn" data-toggle="modal" data-target="#contact_modal">Reisebüro kontaktieren</button>
                    <button class="secondary-btn" data-toggle="modal" data-target="#myModal2">Rückrufbitte einstellen</button>
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

<div class="container">
    <div class="col-md-12">
        <hr class="sad-hr">
    </div>
</div>

<section class="section-contact">
    <div class="container">
        @include('frontend.wishes.partial.wish-user-details')
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
                                <p>{{ trans('wish.details.subheadline.your_wish_sub') }}</p>
                            </div>
                            <i class="fal fa-plus"></i>
                            <i class="fal fa-minus"></i>
                    </h4>
                </div>

                <div id="content" class="panel-collapse collapse">
                    <div class="panel-body">
                        @include('frontend.wishes.partial.wish-user-details')
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
                <h4 class="modal-title">Kontakt zum zuständigen Reisebüro</h4>
                <p>Schreibe dem zuständigen Reisebüro eine Nachricht oder nutze den <a href="#">Rückruf-Service</a></p>
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

                    @include('frontend.wishes.partial.modal-right-panel')

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

<div id="myModal2" class="modal wish-modal-1 fade" role="dialog">
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
                <h4 class="modal-title">Rückrufbitte zum zuständigen Reisebüro einstellen</h4>
                <p>Stelle einfach und bequem eine Rückrufbitte ein und das<br>
                    zuständige Reisebüro wird sich als bald bei dir melden
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
