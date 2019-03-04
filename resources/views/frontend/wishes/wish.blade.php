@extends('frontend.layouts.app')

@section('logo')
    <a href="{{ route('frontend.index') }}" class="logo">
        @if(isWhiteLabel())
            <img class="navbar-brand" src="{{ getWhiteLabelLogoUrl() }}">
        @else
            <img class="navbar-brand" src="{{route('frontend.index')}}/img/logo_big.png">
        @endif
    </a>
@endsection

@section('content')
<section class="section-top">

    <div class="img-background">
        <div class="container">
            <div class="col-md-8 bg-left-content">
                <h3>Hallo {{ $wish->owner->first_name }} {{ $wish->owner->last_name }},</h3>
                <p class="header-p">Dein Reisewunsch wurde am <b>{{ \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y') }}</b> an <b>{{ $wish->group->users[0]->name }}</b> <br>
                    übermittelt. Leider liegt momentan noch kein Angebot vor.</p>

                @if (count($wish->offers) > 0)
                    <button class="primary-btn" onclick="scrollToAnchor('angebote')">Angebot ansehen</button>
                @else
                    <button class="primary-btn" data-toggle="modal" data-target="#contact_modal">Reisebüro kontaktieren</button>
                    <button class="secondary-btn" data-toggle="modal" data-target="#myModal2">Rückrufbitte einstellen</button>
                @endif
            </div>
        </div>
    </div>

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
</section>

<div class="container">
    <div class="col-md-12 hr"><hr></div>
</div>

@foreach($wish->offers as $key => $offer)
    <section class="section-angebote-2" id="angebote">
        <div class="container">
            <div class="col-md-12 sa2-1">
                <h4>
                    {{ trans('wish.view.new_offers') }}
                </h4>
                <p class="sa2-p1">Du hast {{ count($wish->offers) }} Angebote von <b>{{ $offer->owner->name }}</b> erhalten</p>
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
                @if (!$offer->offerFiles)
                <div class="sa2-buttons">
                    <button class="primary-btn" data-toggle="modal" data-target="#contact_modal">Reisebüro kontaktieren</button>
                    <button class="secondary-btn" data-toggle="modal" data-target="#myModal2">Rückrufbitte einstellen</button>
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
            <div class="col-md-12">
                <hr class="sad-hr">
            </div>
        </div>


        <div class="container">
            <div class="col-md-12 sa-2">
                <div class="sa-buttons">
                    <button class="primary-btn" data-toggle="modal" data-target="#contact_modal">Reisebüro kontaktieren</button>
                    <button class="secondary-btn" data-toggle="modal" data-target="#myModal2">Rückrufbitte einstellen</button>
                </div>
            </div>
        </div>

    </section>
  @endif
@endforeach

<div class="container">
    <div class="col-md-12">
        <hr class="sad-hr">
    </div>
</div>

<section class="section-comments">
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

        <div class="col-md-12 s2-first">
            <h4>Dein Reisewunsch</h4>
            <p>Dies sind Deine Angaben zu Deinem Reisewunsch.</p>
            <p><b>Deine Nachricht:</b><br>
                {{ $wish->description }}
            </p>
        </div>

        <div class="col-md-12 s2-second">

            <div class="col-md-3">
                <i class="fal fa-plane-departure"></i>
                <input class="data-content" value="{{ $wish->airport }}">
            </div>
            <div class="col-md-3">
                <i class="fal fa-calendar-alt"></i>
                <input class="data-content" value="{{ \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.y') }} - {{ \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.y') }}">
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
                <input class="data-content" value="{{ $wish->catering }}">
            </div>
        <!--<button class="secondary-btn">Daten andern</button>-->
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
                                <h4>Dein Reisewunsch</h4>
                                <p>Dies sind Deine Angaben zu Deinem Reisewunsch.</p>
                            </div>
                            <span class="glyphicon glyphicon-plus"></span></a>
                        <span class="glyphicon glyphicon-minus"></span></a>
                    </h4>
                </div>

                <div id="content" class="panel-collapse collapse">
                    <div class="panel-body">
                        <div class="col-md-12 s2-first">
                            <p><b>Deine Nachricht:</b><br>
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec purus libero, tempor eget mi vel,
                                pellentesque sodales dui. Nam pharetra neque et nibh vehicula, ut rutrum orci varius.
                                In quis sapien non turpis fermentum venenatis quis sed felis. Sed commodo scelerisque metus, consequat tempor turpis consectetur nec. Nullam a fermentum dolor.
                            </p>
                        </div>
                        <div class="col-md-12 s2-second">
                            <div class="col-md-3">
                                <span class="circle"></span>
                                <input class="data-content" value="Hamburg">
                            </div>
                            <div class="col-md-3">
                                <span class="circle"></span>
                                <input class="data-content" value="17.01 - 17.04.19">
                            </div>
                            <div class="col-md-3">
                                <span class="circle"></span>
                                <input class="data-content" value="3.094€">
                            </div>
                            <div class="col-md-3">
                                <span class="circle"></span>
                                <input class="data-content" value="4 Sterne">
                            </div>

                            <div class="col-md-3">
                                <span class="circle"></span>
                                <input class="data-content" value="Gran Canaria">
                            </div>
                            <div class="col-md-3">
                                <span class="circle"></span>
                                <input class="data-content" value="2 Etwachsene">
                            </div>
                            <div class="col-md-3">
                                <span class="circle"></span>
                                <input class="data-content" value="Genau 10 Tage">
                            </div>
                            <div class="col-md-3">
                                <span class="circle"></span>
                                <input class="data-content" value="Halbpension">
                            </div>
                            <button class="secondary-btn">Daten andern</button>
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

<section class="section-data">
    <div class="container">
        <div class="col-md-6 s3-left">
            <h4>Häufige Fragen anderer Nutzer</h4>
            <span><hr></span>
            <p>
                Ihre Frage ist nicht dabei? <br>
                <b><a href="mailto:service@desirectec.de">service@desirectec.de</a></b>
            </p>
        </div>
        <div class="col-md-6 s3-right">
            <div class="panel-group" id="accordion">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">&#60;Häufig festellte Frage 1 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
                        </h4>
                    </div>
                    <div id="collapse1" class="panel-collapse collapse">
                        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">&#60;Häufig festellte Frage 2 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">&#60;Häufig festellte Frage 3 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse">
                        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">&#60;Häufig festellte Frage 3 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
                        </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse">
                        <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                            sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>


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
                            <input type="text" class="form-control email" name="email" id="email" required>
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
                        <img src="/img/frontend/profile-picture/white.jpeg" alt="">
                        <h4>Reisebüro Sonnenklar</h4>
                        <p>Musterstrasse 7 <br>
                            12345 Wusterhausen
                        </p>
                        <div class="modal-contact">
                            <div class="mc-tel">
                                <span class="glyphicon glyphicon-earphone"></span>
                                <a href="tel:08971459535">089 - 714 595 35</a>
                            </div>
                            <div class="mc-mail">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <a href="mailto:mail@reisebuero.de">mail@reisebuero.de</a>
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
                <h4 class="modal-title">Kontakt zum zuständigen Reisebüro einstellen</h4>
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
                        <img src="/img/frontend/profile-picture/white.jpeg" alt="">
                        <h4>Reisebüro Sonnenklar</h4>
                        <p>Musterstrasse 7 <br>
                            12345 Wusterhausen
                        </p>
                        <div class="modal-contact">
                            <div class="mc-tel">
                                <span class="glyphicon glyphicon-earphone"></span>
                                <a href="tel:08971459535">089 - 714 595 35</a>
                            </div>
                            <div class="mc-mail">
                                <span class="glyphicon glyphicon-envelope"></span>
                                <a href="mailto:mail@reisebuero.de">mail@reisebuero.de</a>
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
