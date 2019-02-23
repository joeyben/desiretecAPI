@extends('frontend.layouts.newapp')

@section('content')

<section class="section-top">

    <div class="img-background">
        <div class="container">
            <div class="col-md-8 bg-left-content">
                <h3>Hallo {{ $wish->owner->first_name }} {{ $wish->owner->last_name }},</h3>
                <p>Dein Reisewunsch wurde am <b>{{ \Carbon\Carbon::parse($wish->created_at)->format('d.m.Y') }}</b> an <b>{{ $wish->group->users[0]->name }}</b> <br>
                    ubermittelt. Leider liegt momentan noch kein Angebot vor.</p>

                <button class="primary-btn" data-toggle="modal" data-target="#myModal">Reiseburo kontaktieren</button>
                <button class="secondary-btn"data-toggle="modal" data-target="#myModal2">Ruckrufbitte einstellen</button>
            </div>
        </div>
    </div>

    <div class="bg-bottom">
        <div class="container">
            <h4>Zustandiges Reiseburo</h4>
            <div class="col-md-3">
                <p>
                    {{ $wish->group->users[0]->name }}</p>
                <p>
                    {{ $wish->group->users[0]->address }} <br>
                    {{ $wish->group->users[0]->zip_code }} {{ $wish->group->users[0]->city }}
                </p>
            </div>
            <div class="col-md-3 c-info">
                <i class="glyphicon glyphicon-user"></i>
                <span>{{ $wish->group->users[0]->agents[0]->name }}</span>
            </div>
            <div class="col-md-3 c-info c-tel">
                <i class="glyphicon glyphicon-earphone"></i>
                <a href="tel:08971459535">{{ $wish->group->users[0]->agents[0]->telephone }}</a>
            </div>
            <div class="col-md-3 c-info">
                <i class="glyphicon glyphicon-envelope"></i>
                <a href="mailto:mail@reisebuero.de">{{ $wish->group->users[0]->agents[0]->email }}</a>
            </div>
        </div>
    </div>

</section>
<div class="container">
    <div class="col-md-12 hr"><hr></div>
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
                <span class="circle"></span>
                <input class="data-content" value="{{ $wish->airport }}">
            </div>
            <div class="col-md-3">
                <span class="circle"></span>
                <input class="data-content" value="{{ \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.y') }} - {{ \Carbon\Carbon::parse($wish->earliest_start)->format('d.m.y') }}">
            </div>
            <div class="col-md-3">
                <span class="circle"></span>
                <input class="data-content" value="{{  number_format($wish->budget, 0, ',', '.') }}€">
            </div>
            <div class="col-md-3">
                <span class="circle"></span>
                <input class="data-content" value="{{ $wish->category }} Sterne">
            </div>

            <div class="col-md-3">
                <span class="circle"></span>
                <input class="data-content" value="{{ $wish->destination }}">
            </div>
            <div class="col-md-3">
                <span class="circle"></span>
                <input class="data-content" value="{{ $wish->adults }}">
            </div>
            <div class="col-md-3">
                <span class="circle"></span>
                <input class="data-content" value="{{ $wish->duration }}">
            </div>
            <div class="col-md-3">
                <span class="circle"></span>
                <input class="data-content" value="{{ $wish->catering }}">
            </div>
            <button class="secondary-btn">Daten andern</button>
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
    <div class="col-md-12 hr hr-mobile"><hr></div>
</div>

<section class="section-data">
    <div class="container">
        <div class="col-md-6 s3-left">
            <h4>Haufige Fragen anderer Nutzer</h4>
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">&#60;Haufig festellte Frage 1 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">&#60;Haufig festellte Frage 2 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">&#60;Haufig festellte Frage 3 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">&#60;Haufig festellte Frage 3 - Lorem ipsum dolor&#62; <span class="glyphicon glyphicon-minus"></span><span class="glyphicon glyphicon-plus"></span></a>
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

@endsection