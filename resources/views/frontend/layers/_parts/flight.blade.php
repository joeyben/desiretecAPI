<div class="tab-pane fade show @if($active) active @endif" id="flight" role="tabpanel" aria-labelledby="flight-tab">
    <div class="kwp dt-modal-visible" style="margin: 0; width: 100%">
        <div class="kwp-header kwp-variant-eil-n1" style="background-image: url({{ $bgImage }} )!important;">

            <div class="kwp-overlay"></div>
            <div class="kwp-logo"></div>
            <div class="kwp-header-content">
                <h1>{{ $title }}<br></h1>
                <p>{{ $text }}</p>
            </div>
        </div>
        <div class="kwp-body eil-n1-body">
            <form method="GET" action="https://master.reise-wunsch.com/store" accept-charset="UTF-8" class="" role="form" enctype="multipart/form-data">

                <div class="kwp-minimal">
                    <div class="kwp-content kwp-with-expansion">
                        <div class="kwp-row">
                            <div class="kwp-col-4 destination">
                                <label for="destination" class="control-label required">Wo soll es hingehen?</label>
                                <div class="bootstrap-tagsinput"><input type="text" placeholder="Destination"></div><input class="form-control box-size" autocomplete="new-password" placeholder="Destination" required="required" name="destination" type="text" id="destination" style="display: none;">
                                <i class="master-icon--location-fill"></i>
                            </div>

                            <div class="kwp-col-4">
                                <label for="airport" class="control-label required">Start</label>
                                <div class="bootstrap-tagsinput"><input type="text" placeholder="z. B. München"></div><input class="form-control box-size" autocomplete="new-password" placeholder="z. B. München" required="required" name="airport" type="text" id="airport" style="display: none;">
                                <i class="master-icon--aircraft-up"></i>
                            </div>

                        </div>
                        <div class="kwp-row">

                            <div class="kwp-col-4 duration-col main-col">
                                <div class="kwp-form-group duration-group">
                                    <label for="duration-time" class="required">Reisedauer</label>
                                    <span class="duration-time dd-trigger">
                        <span class="txt">07.12.2019 - 14.12.2019, Beliebig</span>
                        <i class="master-icon--calendar-month not-triggered"></i>
                        <i class="master-icon--close triggered"></i>
                    </span>
                                    <div class="duration-more">
                                        <div class="kwp-col-4">
                                            <label for="earliest_start" class="control-label required">Hinreise</label>
                                            <input class="form-control box-size" placeholder="Hinreise" required="required" name="earliest_start" type="text" id="earliest_start">
                                            <i class="master-icon--calendar-month"></i>
                                        </div>
                                        <div class="kwp-col-4">
                                            <label for="latest_return" class="control-label required">Rückreise</label>
                                            <input class="form-control box-size" placeholder="Rückreise" required="required" name="latest_return" type="text" id="latest_return">
                                            <i class="master-icon--calendar-month"></i>
                                        </div>
                                        <div class="kwp-col-12">
                                            <label for="duration" class="control-label required">Reisedauer</label>
                                            <div class="kwp-custom-select">
                                                <select class="form-control box-size" id="duration" name="duration"><option value="0">Beliebig</option><option value="exact">Exakt wie angegeben</option><option value="7-">1 Woche</option><option value="14-">2 Wochen</option><option value="21-">3 Wochen</option><option value="28-">4 Wochen</option><option value="1-4">1-4 Tage</option><option value="5-8">5-8 Tage</option><option value="9-12">9-12 Tage</option><option value="13-15">13-15 Tage</option><option value="16-22">16-22 Tage</option><option value="22-">&gt;22 Tage</option><option value="1">1 Nacht</option><option value="2">2 Nächte</option><option value="3">3 Nächte</option><option value="4">4 Nächte</option><option value="5">5 Nächte</option><option value="6">6 Nächte</option><option value="7">7 Nächte</option><option value="8">8 Nächte</option><option value="9">9 Nächte</option><option value="10">10 Nächte</option><option value="11">11 Nächte</option><option value="12">12 Nächte</option><option value="13">13 Nächte</option><option value="14">14 Nächte</option><option value="15">15 Nächte</option><option value="16">16 Nächte</option><option value="17">17 Nächte</option><option value="18">18 Nächte</option><option value="19">19 Nächte</option><option value="20">20 Nächte</option><option value="21">21 Nächte</option><option value="22">22 Nächte</option><option value="23">23 Nächte</option><option value="24">24 Nächte</option><option value="25">25 Nächte</option><option value="26">26 Nächte</option><option value="27">27 Nächte</option><option value="28">28 Nächte</option></select>
                                            </div>
                                            <i class="master-icon--time"></i>
                                        </div>
                                        <div class="clearfix"></div>
                                        <hr>
                                        <div class="kwp-col-12 button">
                                            <a href="#" style="background: rgb(249, 101, 0);">OK</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="kwp-col-4 pax-col main-col">
                                <div class="kwp-form-group pax-group">
                                    <label for="travelers" class="required">Reisende</label>
                                    <span class="travelers dd-trigger">
                        <span class="txt">1 Erwachsener </span>
                         <i class="master-icon--user-family not-triggered"></i>
                         <i class="master-icon--close triggered"></i>
                    </span>
                                    <div class="pax-more">
                                        <div class="kwp-col-12">
                                            <label for="adults" class="control-label required">Erwachsene</label>
                                            <div class="kwp-custom-select">
                                                <select class="form-control box-size" required="required" id="adults" name="adults"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option></select>
                                            </div>
                                            <i class="master-icon--user-family"></i>
                                        </div>
                                        <div class="kwp-col-12 kids" style="position: relative;">
                                            <div class="kwp-col-12">
                                                <label for="kids" class="control-label required">Kinder</label>
                                                <div class="kwp-custom-select">
                                                    <select class="form-control box-size" id="kids" name="kids"><option value="0">0</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option></select>
                                                </div>
                                                <i class="master-icon--baby"></i>
                                            </div>
                                            <div class="kwp-col-ages">
                                                <div class="kwp-form-group">
                                                    <label class="main-label">Alter (Hinreise)</label>
                                                    <div class="kwp-col-3">
                                                        <i class="master-icon--aircraft-down"></i>
                                                    </div>
                                                    <div class="kwp-col-3">
                                                        <i class="master-icon--aircraft-down"></i>
                                                    </div>
                                                    <div class="kwp-col-3">
                                                        <i class="master-icon--aircraft-down"></i>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <script>dt.childrenAges();</script>
                                        <hr>
                                        <div class="kwp-col-12 button">
                                            <a href="#" style="background: rgb(249, 101, 0); border: 1px solid rgb(249, 101, 0); color: rgb(255, 255, 255);">OK</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="kwp-row">
                            <div class="kwp-col-3 rangeslider-wrapper">
                                <div class="kwp-form-group ">
                                    <label for="budget" class="control-label required">Gesamtpreis</label>
                                    <input class="form-control box-size hidden" placeholder="Gesamtpreis" required="required" name="budget" type="number" id="budget">
                                </div>
                                <span class="text">&nbsp;</span>
                                <input type="range" min="100" max="10000" value="50" step="50" id="budgetRange" style="position: absolute; width: 1px; height: 1px; overflow: hidden; opacity: 0;"><div class="rangeslider rangeslider--horizontal" id="js-rangeslider-0"><div class="rangeslider__fill" style="width: 7.5px;"></div><div class="rangeslider__handle" style="left: 0px;"></div></div>
                            </div>

                            <div class="kwp-col-3 white-col stars">
                                <div class="kwp-form-group">
                                    <label for="category" class="control-label required">Hotelkategorie</label>
                                    <input class="form-control box-size hidden" placeholder="Hotelkategorie" name="category" type="number" id="category">

                                    <span class="text">ab 0 Sonnen</span>
                                    <div class="kwp-star-input">
                                        <span class="kwp-star" data-val="1"></span>
                                        <span class="kwp-star" data-val="2"></span>
                                        <span class="kwp-star" data-val="3"></span>
                                        <span class="kwp-star" data-val="4"></span>
                                        <span class="kwp-star" data-val="5"></span>
                                    </div>
                                    <script>dt.hotelStars();</script>
                                </div>
                            </div>

                            <div class="kwp-col-3 white-col catering">
                                <label for="catering" class="control-label required">Verpflegung (mind.)</label>
                                <div class="kwp-custom-select">
                                    <select class="travelers form-control box-size" id="catering" name="catering"><option value="1">Ohne Verpflegung</option><option value="2">Frühstück</option><option value="3">Halbpension</option><option value="4">Vollpension</option><option value="5">all inclusive</option></select>
                                </div>
                                <i class="master-icon--chevron-down"></i>
                            </div>

                        </div>

                        <div class="kwp-row">
                            <div class="kwp-col-12 description">
                                <label for="description" class="control-label required">Anmerkungen?</label>
                                <textarea class="form-control" placeholder="Beschreiben Sie hier Ihre Wünsche oder stellen Sie uns Ihre Fragen" name="description" cols="50" rows="10" id="description"></textarea>
                                <i class="master-icon--calendar-month"></i>
                            </div>
                        </div>

                        <div class="kwp-row">
                            <div class="kwp-col-4 email-col">
                                <label for="email" class="control-label">Ihre E-Mail-Adresse</label>
                                <input class="form-control box-size" placeholder="max.mustermann@urlaub.de" required="required" name="email" type="text" id="email">
                                <i class="master-icon--mail"></i>
                                <div class="kwp-form-email-hint"></div>
                            </div>
                            <div class="kwp-col-4 white-col">
                                <button id="submit-button" type="submit" class="primary-btn" style="background: {{ $color }}; border: 1px solid {{ $color }}; color: rgb(255, 255, 255);">Reisewunsch abschicken</button>
                            </div>


                        </div>

                    </div>


                    <div class="kwp-footer">


                        <div class="kwp-row">
                            <div class="kwp-col-12 white-col">
                                <div class="kwp-agb ">

                                    <input class="dt_terms" required="required" name="terms" type="checkbox">
                                    <p>Ich habe die <a href="#" id="agb_link" target="_blank" style="color: rgb(249, 101, 0);">Teilnahmebedingungen</a> und <a id="datenschutz" href="#" target="_blank" style="color: rgb(249, 101, 0);">Datenschutzrichtlinien</a> zur Kenntnis genommen und möchte meinen Reisewunsch absenden.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div><div style="clear:both;"></div></div>
</div>
