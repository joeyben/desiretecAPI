@extends('layouts.default')
@section('title')
    How It Works
@stop
@section('page-title')
    <i class="icon-arrow-left52 mr-2"></i>
    <span class="font-weight-semibold">How It Works</span>
@stop
@section('breadcrumb')
    <div class="breadcrumb">
        <a href="{{ url('/') }}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Dashboard</a>
        <span class="breadcrumb-item active">How It Works</span>
    </div>
@stop
@section('vue-js')
@stop
@section('content')
    <!-- Basic card -->
    <div class="content" id="whitelabelsProviderComponent">
        <!-- Timeline -->
        <div class="timeline timeline-center">
            <div class="timeline-container">

                <!-- Blog post -->
                <div class="timeline-row timeline-row-left">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                           1
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">White Label</h6>
                        </div>

                        <div class="card-body">
                            <ul class="list mb-0">
                                <li>
                                    <p>
                                        Der Anzeigename ist für den User sichtbar und erscheint sowohl auf der Startseite des Reisewunschportals, als auch im E-Mail-Verkehr.
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Unter dem Domainnamen wird ihr Reisewunschportal zugänglich sein. User und Ihre Reisebüro- oder Servicecenter Mitarbeiter können sich hier einloggen, Reisewünsche und Angebote erstellen.
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Die Primärfarbe ist Ihre Brandcolor und wird an vielen Stellen Ihres White Label Portals verwendet.
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Die Domains geben an, auf welchen Seiten der Exit-Intent-Layer (EIL) angezeigt werden darf. Tragen Sie hier bitte die URL Ihrer Homepage im Format “https://homepage.de”, sowie die URL des gewünschten Reisewunschportals “https://domainname.wish-service.com” ein.
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Ihr hochgeladenes Logo wird automatisch an verschiedenen Stellen Ihres Reisewunschportals angezeigt. Wie z.B. auf der Website, auf dem Layer oder in den E-Mails. Verwenden sie nach Möglichkeit ein freigestelltes Logo mit transparentem Hintergrund.
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Das Favicon wird in jedem Browser Tab des Portals angezeigt.
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /blog post -->


                <!-- Video post -->
                <div class="timeline-row timeline-row-right">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            2
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Layer Version</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Sie können den Layer entsprechend Ihrem Hauptgeschäft gestalten und zwischen den verschiedenen Layer Varianten “Pauschal”, “Flug”, “Kreuzfahrt” und “Hotel” wählen oder je nach Preismodell auch mehrere Layer Varianten in Form eines Multi-Layers auswählen und kombinieren. Im Feld “Please input URL” unter den Layer Varianten tragen Sie bitte die URL inklusive Subdomain, auf welcher der jeweilige Layer aufpoppen soll, ein. Format: https://reiseportal.de/hotels oder https://hotels.reiseportal.de
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /video post -->

                <!-- Blog post -->
                <div class="timeline-row timeline-row-left">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            3
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Layer Content</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Um den EIL auf Desktop & Tablet ansprechend anzuzeigen, benötigen wir ein Bild (Visual), welches im Header dargestellt wird. Bitte beachten Sie die jeweiligen Format - und Größenvorgaben. Auch die Beschriftung der Layer kann hier angepasst werden.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /blog post -->

                <!-- Video post -->
                <div class="timeline-row timeline-row-right">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            4
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">E-Mail Signatur</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Aus dem Reisewunschportal werden E-Mails an Ihre Kunden und die Mitarbeiter aus den Reisebüros versendet. Ihre Signatur für diese E-Mails können Sie unter diesem Punkt eintragen. Auch Bilder können dabei mithilfe des “What you see is what you get” -Tools dargestellt werden.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /video post -->

                <!-- Blog post -->
                <div class="timeline-row timeline-row-left">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            5
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Footers</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Standard Footer, wie sie am unteren Ende Ihrer Homepage zu finden sind, lassen sich unter diesem Punkt leicht einfügen. Dazu geben Sie lediglich die jeweilige Bezeichnung des Footers an, die URL, wohin der hinterlegte Link führen soll und die Position, an welcher der Footer stehen soll. Formatvorgabe für die URL ist https://reiseportal.de/footer1
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /blog post -->

                <!-- Video post -->
                <div class="timeline-row timeline-row-right">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            6
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Teilnahmebedingungen</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Bei den angezeigten Teilnahmebedingungen handelt es sich lediglich um einen Vorschlag. Eine Haftung für die Richtigkeit der Vorlage übernimmt Desiretec nicht, insbesondere erteilen wir auch keine Rechtsberatung. Jeder Kunde muss selbst bestimmen, welche Nutzungsbedingungen er einbindet.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /video post -->


                <!-- Blog post -->
                <div class="timeline-row timeline-row-left">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            7
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Anbieter Management</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Unter Anbieter sind die Servicecenter oder Reisebüros zu verstehen, welche die gesammelten Wünsche bearbeiten dürfen/können/werden.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /blog post -->

                <!-- Video post -->
                <div class="timeline-row timeline-row-right">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            8
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Gruppen Management</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Die Reisewünsche werden im Rundlaufverfahren (Round Robin) der Reihe nach an die eingetragenen Gruppen verteilt. In den Preisstufen Basic oder Premium ist es zudem möglich, Gruppen mit verschiedenen Fachgebieten zu definieren und die Wünsche entsprechend der Expertise systematisch zu verteilen. Auch eine regionale Zuteilung steht zur Auswahl, um dem Endkunden einen persönlichen Kontakt im nahe gelegenen Reisebüro anbieten zu können.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /video post -->

                <!-- Blog post -->
                <div class="timeline-row timeline-row-left">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            9
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Lead Management</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                In den Preisstufen Basic oder Premium haben Sie die Möglichkeit über das Lead Management die Bearbeitungsart der eingehenden Reisewünsche einzustellen. Sie können bei der Mixed Version Ihre eigene Kriterienliste erstellen, wonach die Wünsche gefiltert und demnach manuell oder automatisch beantwortet werden. Beispielsweise ab welchem Budget oder für welche Zieldestinationen besondere Fachkenntnis hilfreich sind und die entsprechenden Wünsche zur manuellen Bearbeitung an ein Reisebüro weitergeleitet werden sollen.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /blog post -->

                <!-- Video post -->
                <div class="timeline-row timeline-row-right">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            10
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Offer Management</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Einen weiteren Mehrwert der Basic oder Premium Stufe bietet Ihnen das Offer Management, welches die Angebotsauswahl- und anzeige steuert. Wie viele Angebote sollen dem Kunden präsentiert werden, welche Mindest Weiterempfehlungsrate setzen Sie dafür voraus und wie hoch soll die durchschnittliche Bewertung liegen?
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /video post -->

                <!-- Blog post -->
                <div class="timeline-row timeline-row-left">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            11
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">JS Snippet</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Damit der Exit-Intent-Layer auf Ihrer Website erscheint und Sie das Reisewunschportal nutzen können, muss ein kleines JavaScript in Ihre Website eingebunden werden.
                            </p>
                            <p class="mb-3 text-justify">
                                Das Script sorgt dafür, dass
                            </p>
                            <ul class="list mb-0">
                                <li>
                                    <p>
                                        der Layer erscheint (Desktop sowie mobile devices)
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        nach dem Schließen des Layers der Trigger Button zu sehen ist, über den Ihr User den Layer jederzeit erneut öffnen kann
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        ein Cookie gesetzt wird, der die Anzahl der Erscheinungen des Layers pro Session begrenzt
                                    </p>
                                </li>
                            </ul>
                            <p class="mb-3 text-justify">
                                Implementierung
                            </p>
                            <ul class="list mb-0">
                                <li>
                                    <p>
                                        Die Implementierung kann sehr einfach über gängige Tag Tools z.B. via den Google Tag Manager (GTM) oder Tealium erfolgen
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Bitte beachten: Das Script muss geladen werden, nachdem jQuery geladen ist
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /blog post -->

                <!-- Video post -->
                <div class="timeline-row timeline-row-right">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            D
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Dashboard</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                Im Dashboard aggregieren wir für Sie alle relevanten Daten Ihres Reisewunschportals. So haben Sie ständig die volle Kontrolle. Außerdem haben Sie die Möglichkeit sich die Daten in einer Reporting Tabelle herunterzuladen.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /video post -->

                <!-- Blog post -->
                <div class="timeline-row timeline-row-left">
                    <div class="timeline-icon">
                        <div class="bg-warning-300">
                            W
                        </div>
                    </div>

                    <div class="card border-left-3 border-left-orange rounded-left-0">
                        <div class="card-header header-elements-sm-inline">
                            <h6 class="card-title">Wünsche Management</h6>
                        </div>

                        <div class="card-body">
                            <p class="mb-3 text-justify">
                                In dieser Tabelle finden Sie alle Reisewünsche die Sie generiert haben. Inklusive aller Parameter. Natürlich habe Sie auch die Möglichkeit, diese Daten jederzeit in einem beliebigen Umfang herunterzuladen.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /blog post -->
            </div>
        </div>
        <!-- /timeline -->
    </div>
@stop

