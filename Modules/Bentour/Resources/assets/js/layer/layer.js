var dt = window.dt || {};
var exitIntent = window.exitIntent || {};

(function ($) {

    dt.defaultConfig = {
        baseUrl: 'https://bentour.reise-wunsch.com',
        popupPath: '/show',
        popupStore:'/store',
        cssPath: '/whitelabel/bentour/css/layer/whitelabel.css'
    };

    dt.popupTemplate = function (variant) {

        var texts = {
            'eil-n1-social': {
                header: 'Dürfen wir Dich beraten?',
                body: 'Unsere besten Reiseberater helfen Dir gerne, Deine persönliche Traumreise zu finden. Probiere es einfach aus! Natürlich kostenlos und unverbindlich.'
            },
            'eil-n1': {
                header: 'Dürfen wir Sie beraten?',
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden. Probieren Sie es einfach aus! Natürlich kostenlos und unverbindlich.'
            },
            'eil-n2': {
                header: 'Dürfen wir Sie beraten?',
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden. Probieren Sie es einfach aus! Natürlich kostenlos und unverbindlich.'
            },
            'eil-n3': {
                header: 'Dürfen wir Ihnen helfen?',
                body: 'Einer unserer erfahrenen Reiseberater hilft Ihnen gerne, die für Sie passende Reise zu finden. Probieren Sie es einfach kostenlos und unverbindlich aus!'
            },
            'eil-n4': {
                header: 'Dürfen wir Ihnen helfen?',
                body: 'Einer unserer erfahrenen Reiseberater hilft Ihnen gerne, die für Sie passende Reise zu finden. Probieren Sie es einfach kostenlos und unverbindlich aus!'
            },
            'eil-n5': {
                header: 'Dürfen wir Sie beraten?',
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden. Probieren Sie es einfach aus! Natürlich kostenlos und unverbindlich.'
            },
            'eil-mobile': {
                header: 'Dürfen wir Dich beraten?',
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden!'
            }
        };

        return '' +
          '<div class="kwp-header kwp-variant-' + variant + '">' +
          '<div class="kwp-close-button kwp-close"></div>' +
          '<div class="kwp-overlay"></div>' +
          '<div class="kwp-logo"></div>' +
          '<div class="kwp-header-content">' +
          '<h1>' +
          texts[variant].header + ' <br/>' +
          '</h1>' +
          '<p>' +
          texts[variant].body +
          '</p>' +
          '</div>' +
          '</div>' +
          '<div class="kwp-body '+variant+'-body">' +
          '</div><div style="clear:both;"></div>'
          ;
    };


    /**** Mobile Decoder ****/
    var MasterIBETripDataDecoderMobile = $.extend({}, dt.AbstractTripDataDecoder, {
        name: 'Bentour WL',
        matchesUrl: 'https://bentour.reise-wunsch.com/|https://bentour.reisewunschservice.de/|http://bentour.com',
        dictionaries: {
            'catering': {
                'AI': 'all-inclusive',
                'AP': 'all-inclusive',
                'FB': 'Vollpension',
                'FP': 'Vollpension',
                'HB': 'Halbpension',
                'HP': 'Halbpension',
                'BB': 'Frühstück',
                'AO': 'ohne Verpflegung',
                'XX': null
            },
            'cateringWeight': {
                'AI': 5,
                'AP': 5,
                'FB': 4,
                'FP': 4,
                'HB': 3,
                'HP': 3,
                'BB': 2,
                'AO': 1,
                'XX': null
            },
            'allowedDestinations': {
                1340: 'Seychellen',
                1196: 'Malediven',
                1333: 'Kapverdische Inseln'
            }
        },
        filterFormSelector: '#search-form',
        filterDataDecoders: {
            'catering': function (form, formData) {
                return '';
            },
            'hotel_category': function (form, formData) {
                return '';
            },
            'destination': function (form, formData) {
                return $(".search-criteria-list li:eq( 0 ) strong").attr('title');
            },
            'pax': function (form, formData) {
                if($(".search-criteria-list li:eq( 4 ) strong").attr('title') !== undefined) {
                    var pax = $(".search-criteria-list li:eq( 4 ) strong").attr('title').split(',');
                    return parseInt(pax[0].replace(' Erwachsene',''));
                }
            },
            'budget': function (form, formData) {
                return '';
            },
            'children': function (form, formData) {
                if($(".search-criteria-list li:eq( 4 ) strong").attr('title') !== undefined) {
                    var pax = $(".search-criteria-list li:eq( 4 ) strong").attr('title').split(',')
                    return parseInt(pax[1].replace(' Kinder',''));
                }
            },
            'age_1': function (form, formData) {
                return '';
            },
            'age_2': function (form, formData) {
                return '';
            },
            'age_3': function (form, formData) {
                return '';
            },
            'earliest_start': function (form, formData) {
                var latest_return = $(".search-criteria-list li:eq( 3 )").text().split(' - ')
                return $.trim(latest_return[0]);
            },
            'latest_return': function (form, formData) {
                var latest_return = $(".search-criteria-list li:eq( 3 )").text().split(' - ')
                return $.trim(latest_return[1]);
            },
            'duration': function (form, formData) {
                if($(".search-criteria-list li:eq( 2 ) strong").attr('title') !== undefined) {
                    var duration = $(".search-criteria-list li:eq( 2 ) strong").attr('title');
                    duration = duration.replace(' Wochen', '-');
                    duration = duration.replace(' Tage', '');
                    return duration;
                }
            },
            'extra': function (form, formData) {
                return '';
            },
            'room_type': function (form, formData) {
                return '';
            },
            'cities': function (form, formData) {
                return '';
            },
            'airport': function (form, formData) {
                return $(".search-criteria-list li:eq( 1 ) strong").attr('title');
            },
            'is_popup_allowed': function (form, formData) {
                //var step = this.getScope().IbeApi.state.stepNr;
                return true;
            }
        },
        getVariant: function () {
            if(isMobile()){
                return 'eil-mobile';
            }else if(getUrlParams('utm_source') && getUrlParams('utm_source') == 'social'){
                return this.getRandomElement([
                    'eil-n1-social'
                ]);
            }else{
                return this.getRandomElement([
                    'eil-n1',
                ]);
            }
        },
        getRandomElement: function (arr) {
            return arr[Math.floor(Math.random() * arr.length)];
        },
        getTripData: function () {
            return this.decodeFilterData();
        },
        getTrackingLabel: function (tripData, variant) {
            var destId = null,
              destName = tripData.destination;

            switch (destName) {
                case 'Kapverdische Inseln':
                case 'Kap Verde - Sal':
                case 'Kap Verde - Boavista':
                case 'Kap Verde Boavista':
                case 'Kap Verde':
                    destId = 'kap';
                    break;
                case 'Malediven':
                    destId = 'mal';
                    break;
                case 'Seychellen':
                    destId = 'sey';
                    break;
                case 'Mauritius & Reunion':
                case 'Mauritius':
                case 'La Réunion':
                case 'Reunion':
                    destId = 'mau';
                    break;
                case 'Mexiko':
                case 'Mexiko: Yucatan / Cancun':
                case 'Mexiko: Pazifikküste':
                    destId = 'mex';
                    break;
                case 'Portugal':
                case 'Algarve':
                    destId = 'alg';
                    break;
                case 'Abu Dhabi':
                case 'Ras Al-Khaimah':
                case 'Fujairah':
                case 'Ajman':
                case 'Umm Al Quwain':
                case 'Oman':
                case 'Dubai':
                    destId = 'dub';
                    break;
                case 'Dominikanische Republik':
                case 'Dom. Republik - Osten (Punta Cana)':
                case 'Dom. Republik - Norden (Puerto Plata & Samana)':
                case 'Dom. Republik - Süden (Santo Domingo)':
                    destId = 'dom';
                    break;
                case 'Insel Phuket':
                case 'Bangkok & Umgebung':
                case 'Insel Ko Samui':
                case 'Westthailand (Hua Hin, Cha Am, River Kwai)':
                case 'Südostthailand (Pattaya, Jomtien)':
                case 'Krabi & Umgebung':
                case 'Khao Lak & Umgebung':
                case 'Nordthailand (Chiang Mai, Chiang Rai, Sukhothai)':
                case 'Inseln im Golf von Thailand (Koh Chang, Koh Phangan)':
                case 'Inseln in der Andaman See (Koh Pee Pee, Koh Lanta)':
                case 'Nordostthailand (Issan)':
                    destId = 'tha';
                    break;
                case 'USA':
                case 'usa':
                case 'Usa':
                case 'Kalifornien':
                case 'New York':
                case 'Florida Ostküste':
                case 'Arizona':
                case 'Florida Orlando':
                case 'Illinois':
                case 'New England':
                case 'Texas':
                case 'Nevada':
                case 'Ohio':
                case 'Utah':
                case 'Louisiana & Mississippi':
                case 'Georgia':
                case 'Colorado':
                case 'Hawaii - Insel Oahu':
                case 'Florida Westküste':
                case 'Missouri':
                case 'North Carolina':
                case 'Washington':
                case 'Hawaii - Insel Maui':
                case 'Washington D.C. & Maryland':
                case 'Minnesota':
                case 'Oregon':
                case 'Hawaii - Insel Big Island':
                case 'South Carolina':
                case 'Hawaii - Insel Kauai':
                case 'Florida Südspitze':
                case 'Montana':
                case 'New Mexico':
                case 'Wyoming':
                case 'New Jersey':
                case 'Alaska':
                case 'Idaho':
                case 'Virginia':
                case 'Pennsylvania':
                case 'South Dakota':
                case 'Alabama':
                case 'Indiana & Kentucky':
                case 'Massachusetts':
                case 'Tennessee':
                case 'Michigan':
                case 'Kansas & Nebraska':
                case 'Oklahoma':
                case 'Arkansas':
                case 'Hawaii - Insel Molokai':
                case 'North Dakota':
                case 'Hawaii - Insel Lanai':
                    destId = 'usa';
                    break;
                case 'Kuba':
                case 'Kuba - Varadero & Havanna':
                case 'Kuba (Holguin)':
                    destId = 'kub';
                    break;
                case 'Sri Lanka':
                    destId = 'sri';
                    break;
                case 'Jamaika':
                    destId = 'jam';
                    break;
                case 'Curacao & Aruba & Bonaire':
                    destId = 'cur';
                    break;
                case 'Barbados':
                    destId = 'bar';
                    break;
                case 'Bahamas':
                    destId = 'bah';
                    break;
                case 'St.Lucia':
                    destId = 'stl';
                    break;
                case 'Antigua & Barbuda':
                    destId = 'ant';
                    break;
                case 'Tobago':
                    destId = 'tob';
                    break;
                case 'Turks & Caicos Inseln':
                    destId = 'tur';
                    break;
                case 'Grenada':
                    destId = 'gre';
                    break;
                case 'Puerto Rico':
                    destId = 'pue';
                    break;
                case 'Guadeloupe':
                    destId = 'gua';
                    break;
                case 'Martinique':
                    destId = 'mar';
                    break;
                case 'St. Marteen (nl.) & St.Eustatius & Saba':
                    destId = 'stmnl';
                    break;
                case 'St. Martin (frz.)':
                    destId = 'stmfr';
                    break;
                case 'Virgin Islands & Anguilla':
                    destId = 'vir';
                    break;
                case 'Anguilla':
                    destId = 'ang';
                    break;
                case 'St.Kitts & Nevis':
                    destId = 'stk';
                    break;
                case 'Bermuda':
                    destId = 'ber';
                    break;
                case 'Cayman Inseln':
                    destId = 'cay';
                    break;
                case 'Harbour Island':
                    destId = 'har';
                    break;
                case 'Indonesien':
                case 'Indonesien: Bali':
                case 'Indonesien: Java':
                case 'Indonesien: Sunda-Inseln':
                case 'Indonesien: Nordosten':
                case 'Indonesien: Sumatra':
                case 'Indonesien: Insel Bintan':
                    destId = 'ind';
                    break;
                case 'Kapstadt & Umgebung':
                case 'Johannesburg & Umgebung':
                case 'Eastern Cape':
                case 'Krüger Park':
                case 'Durban & Umgebung':
                    destId = 'saf';
                    break;
                case 'Namibia':
                    destId = 'nam';
                    break;
                case 'Tansania - Sansibar':
                case 'Tansania':
                case 'Zanzibar':
                    destId = 'tan';
                    break;
                case 'Kenia - Nairobi':
                case 'Kenia - Südküste':
                case 'Kenia - Nordküste':
                    destId = 'ken';
                    break;
                case 'Nordwesten':
                    destId = 'nor';
                    break;
                case 'Simbabwe':
                    destId = 'sim';
                    break;
                case 'Mozambique':
                    destId = 'moz';
                    break;
                case 'Sambia':
                    destId = 'sam';
                    break;
                case 'Botswana':
                    destId = 'not';
                    break;
                case 'Swasiland':
                    destId = 'swa';
                    break;
                case 'Afrika':
                    destId = 'afr';
                    break;
            }

            if (destId) {
                return variant + '-' + destId;
            }

            return variant;
        }
    });



    var KwizzmeFakeTripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        name: 'Master WL',
        matchesUrl: '',
        filterFormSelector: 'body',
        dictionaries: {
            'catering': {
                'AI': 'all-inclusive',
                'AP': 'all-inclusive',
                'FB': 'Vollpension',
                'FP': 'Vollpension',
                'HB': 'Halbpension',
                'HP': 'Halbpension',
                'BB': 'Frühstück',
                'AO': 'ohne Verpflegung',
                'XX': null
            },
            'cateringWeight': {
                'AI': 5,
                'AP': 5,
                'FB': 4,
                'FP': 4,
                'HB': 3,
                'HP': 3,
                'BB': 2,
                'AO': 1,
                'XX': null
            },
            'allowedDestinations': {
                1340: 'Seychellen',
                1196: 'Malediven',
                1333: 'Kapverdische Inseln'
            }
        },
        filterDataDecoders: {
            'catering': function (form, formData) {
                var catering = getUrlParams('catering') ? getUrlParams('catering') : '';
                return catering;
            },
            'hotel_category': function (form, formData) {
                var category = getUrlParams('category') ? getUrlParams('category') : '';
                return category;
            },
            'destination': function (form, formData) {
                var destination = getUrlParams('destination') ? getUrlParams('destination') : '';
                return destination;
            },
            'pax': function (form, formData) {
                var pax = getUrlParams('pax') ? getUrlParams('pax') : '';
                return pax;
            },
            'budget': function (form, formData) {
                var budget = getUrlParams('budget') ? getUrlParams('budget') : '';
                return budget;
            },
            'children': function (form, formData) {
                var kids = getUrlParams('kids') ? getUrlParams('kids') : '';
                return kids;
            },
            'age_1': function (form, formData) {
                var age1 = getUrlParams('age1') ? getUrlParams('age1') : '';
                return age1;
            },
            'age_2': function (form, formData) {
                var age2 = getUrlParams('age2') ? getUrlParams('age2') : '';
                return age2;
            },
            'age_3': function (form, formData) {
                var age3 = getUrlParams('age3') ? getUrlParams('age3') : '';
                return age3;
            },
            'earliest_start': function (form, formData) {
                var dateFrom = getUrlParams('from') ? getUrlParams('from') : '';
                return dateFrom;
            },
            'latest_return': function (form, formData) {
                var dateTo = getUrlParams('to') ? getUrlParams('to') : '';
                return dateTo;
            },
            'duration': function (form, formData) {
                var duration = getUrlParams('duration') ? getUrlParams('duration') : '';
                return duration;
            },
            'airport': function (form, formData) {
                var airport = getUrlParams('airport') ? getUrlParams('airport') : '';
                return airport;
            },
            'is_popup_allowed': function (form, formData) {
                //var step = this.getScope().IbeApi.state.stepNr;
                return true;
            }
        },
        getTripData: function () {
            var form = null,
              formData = null;

            return this.decodeFilterData(form, formData);
        },
        formatDate: function (d) {
            if (!d) {
                return null;
            }

            function pad(val, len) {
                val = String(val);
                len = len || 2;
                while (val.length < len) val = "0" + val;
                return val;
            }

            return pad(d.getDate(), 2) + '.' + pad(d.getMonth() + 1) + '.' + d.getFullYear();
        },
        getScope: function () {
            return null;
        },
        getRandomElement: function (arr) {
            return arr[Math.floor(Math.random() * arr.length)];
        },
        getVariant: function () {
            if(isMobile()){
                return 'eil-mobile';
            }else if(getUrlParams('utm_source') && getUrlParams('utm_source') == 'social'){
                return this.getRandomElement([
                    'eil-n1-social'
                ]);
            }else{
                return this.getRandomElement([
                    'eil-n1',
                    'eil-n1',
                    'eil-n2',
                    'eil-n5'
                ]);
            }
        }
    });
    //dt.decoders.push(MasterIBETripDataDecoder);
    //dt.decoders.push(MasterIBETripDataDecoderMobile);
    dt.decoders.push(KwizzmeFakeTripDataDecoder);

    //dt.decoders.push($.extend({}, MasterIBETripDataDecoder, {
    //    name: 'TUI Landingpages',
    //    matchesUrl: 'master.com/pauschalreisen',
    //    filterFormSelector: '.simpleSearch'
    //}));

    dt.initCallbacks = dt.initCallbacks || [];
    dt.initCallbacks.push(function (popup) {
        exitIntent.init();
        document.addEventListener('exit-intent', function (e) {
            if(!exitIntent.checkCookie()) {
                popup.show();

                // set cookies
                exitIntent.cookieManager.create("exit_intent", "true", exitIntent.cookieExp, exitIntent.sessionOnly);
                var exitIntentNumber = exitIntent.cookieManager.get("exit_intent_number") ? Number(exitIntent.cookieManager.get("exit_intent_number")) + 1 : 1;
                exitIntent.cookieManager.create("exit_intent_number", exitIntentNumber, exitIntent.cookieExp, exitIntent.sessionOnly);
            }
        }, false);
    });


    dt.PopupManager.closePopup = function(event) {
        event.preventDefault();

        var formSent = $('.kwp-content').hasClass('kwp-completed-master');

        this.modal.addClass('tmp-hidden');
        if(!formSent) {
            this.trigger =
                $('<span/>', {'class': 'trigger-modal'});
            $('body').prepend(this.trigger);
            this.trigger.fadeIn();
            this.trigger.css({
                'background-color': brandColor,
            });
        }

        this.shown = false;
        $("body").removeClass('mobile-layer');
        $("body, html").css({'overflow':'auto'});

        //dt.Tracking.event('close', this.trackingLabel);

    };

    dt.scrollUpDetect = function (e) {
        dt.PopupManager.layerShown = false;
        $('body').swipe( { swipeStatus:function(event, phase, direction, distance){
            if(parseInt(distance) > 50 && !dt.PopupManager.layerShown){
                dt.showTeaser(event);
                dt.PopupManager.layerShown = true;
            }
        }, allowPageScroll:"vertical"} );
    };

    dt.triggerButton = function(e){
        $("body").on('click tap','.trigger-modal',function () {
            $("body").addClass('mobile-layer');
            if(dt.PopupManager.teaserSwiped){
                dt.showMobileLayer();
            }else{
                dt.PopupManager.shown = true;
            }
            dt.PopupManager.modal.removeClass('tmp-hidden');
            $(this).remove();
            ga('dt.send', 'event', 'Mobile Layer', 'Trigger button tap', 'Tablet');
        });
    };

    dt.showMobileLayer = function (e) {
        $(".dt-modal").removeClass('teaser-on').find('.teaser').remove();
        $( ".dt-modal" ).addClass('m-open');
        dt.PopupManager.show();
        $("body, html").css({'overflow':'hidden'});
        //$.cookie(dt.PopupManager.mobileCookieId,'true',dt.PopupManager.cookieOptions);
        ga('dt.send', 'event', 'Mobile Layer', 'Teaser shown', 'Mobile');
    };

    dt.showTeaser = function (e) {
        $("body").addClass('mobile-layer');
        $(".dt-modal").addClass('teaser-on').show().find('.teaser').addClass('active').swipe( {
            tap:function(event, target) {
                dt.showMobileLayer(event);
            },
            swipeLeft:function(event, distance, duration, fingerCount, fingerData, currentDirection) {
                $(this).addClass('inactive-left');
                removeLayer(event);
            },
            swipeRight:function(event, distance, duration, fingerCount, fingerData, currentDirection) {
                $(this).addClass('inactive-right');
                removeLayer(event);
            }
        });
    };

    dt.hideTeaser = function (e) {
        $("body").removeClass('mobile-layer');
        $(".dt-modal").remove();
    };

    $(document).ready(function (e) {
        var $event = e;
        if(isMobile()) {
            dt.PopupManager.teaser = true;
            dt.PopupManager.teaserText = "Dürfen wir Sie beraten?";
            $(".dt-modal .kwp-close").on('touchend',function () {
                dt.PopupManager.closePopup(e);
            });
        }
        dt.PopupManager.init();
        dt.Tracking.init('bentour_exitwindow','UA-105970361-14');
        dt.triggerButton($event);
        if(isMobile() && dt.PopupManager.decoder){
            dt.scrollUpDetect();
            dt.PopupManager.isMobile = true;
            $(".dt-modal").css({'top':(document.documentElement.clientHeight - 100)+"px"});
            textareaAutosize();
            $(".dt-modal .teaser").find('i').on('click touchend',function () {
                dt.hideTeaser($event);
            });
            if(getUrlParams('autoShow')){
                dt.showMobileLayer();
                shown = true;
                $(this).addClass('m-open');
                $("body, html").css({'overflow':'hidden'});
            }
        }
        if(getUrlParams('autoShow') && !isMobile()){
            dt.PopupManager.show();
        }
    });

    $( window ).on( "orientationchange", function( event ) {
        $(".dt-modal").css({'top':(document.documentElement.clientHeight - 85)+"px"});
    });

    dt.childrenAges = function () {
            (function ($, children, age) {
                function update() {
                    var val = $(children).val();

                    if (val>0) {
                        $('.kwp-col-ages').addClass('kwp-show-ages');
                    } else {
                        $('.kwp-col-ages').removeClass('kwp-show-ages');
                    }

                    var i;

                    for (i = 1; i <= 4; ++i) {

                        if (i <= val) {
                            $(age + i).find('.kwp-custom-select').show();
                        } else {
                            $(age + i +' select').val('').find('.kwp-custom-select').hide();
                            $(age + i).find('.kwp-custom-select').hide();
                        }

                        if(i == val){
                            $(age + i).closest('.kwp-col-3').addClass('last');
                        }else{
                            $(age + i).closest('.kwp-col-3').removeClass('last');
                        }
                    }
                    $( "select[name='ages1']" ).change(function() {
                        $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/' + $("select[name='ages4'] option:selected").text() + '/')
                    });
                    $( "select[name='ages2']" ).change(function() {
                        $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/' + $("select[name='ages4'] option:selected").text() + '/')
                    });
                    $( "select[name='ages3']" ).change(function() {
                        $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/' + $("select[name='ages4'] option:selected").text() + '/')
                    });
                    $( "select[name='ages4']" ).change(function() {
                        $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/' + $("select[name='ages4'] option:selected").text() + '/')
                    });
                }
                $(children).on('change keydown blur', update);
                update();
            })(jQuery, '#kids', '#age_');
        };

    dt.hotelStars = function () {
        function restoreValue() {
            var val = $('#category').val();

            if (!val) {
                val = 0;
            }

            highlight(parseInt(val));
        }

        function setValue(val) {
            $('#category').val(val);
            restoreValue(val);
        }

        function setText(cnt){
            var sonnen = cnt === 1 ? "Sonne" : "Sonnen";
            $('.kwp-star-input').parents('.kwp-form-group').find('.text').text("ab "+cnt+" "+sonnen);
        }

        function highlight(cnt) {
            $('.kwp-star-input .kwp-star').each(function () {
                var val = parseInt($(this).attr('data-val'));

                if (val <= cnt) {
                    $(this).addClass('kwp-star-full');
                } else {
                    $(this).removeClass('kwp-star-full');
                }
            });
            setText(cnt);
        }

        $('.kwp-star-input .kwp-star').hover(function () {
            highlight(parseInt($(this).attr('data-val')));
        }).click(function () {
            setValue(parseInt($(this).attr('data-val')));
            var sonnen = parseInt($(this).attr('data-val')) === 1 ? "Sonne" : "Sonnen";
            $('.kwp-star-input').parents('.kwp-form-group').find('.text').text("ab "+$(this).attr('data-val')+" "+sonnen);
        });

        $('.kwp-star-input').mouseout(function () {
            restoreValue();
        });

        restoreValue();
    };


    dt.darkGreyLayout = function (e) {
        e && e.preventDefault();
        $(".kw-overlay-notActive").click(function () {
            $(this).fadeOut("slow");
            $("#airport").focus();
        });
    };


    function isMobile(){
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            return true;
        } else if( $(window).outerWidth() < 769 ) {
            return true;
        }
        return false;
    }

    function getUrlParams(params){
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        var queryString = null;
        for (var i = 0; i < vars.length; i++) {
            var pair = vars[i].split("=");
            var key = decodeURIComponent(pair[0]);
            var value = decodeURIComponent(pair[1]);

            if (key === params) {
                queryString = decodeURIComponent(value);
                break;
            }
        }

        return queryString;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function setCookie(cname, cvalue) {
        document.cookie = cname + "=" + cvalue + ";path=/";
    }

    function removeLayer(e){
        var $event = e;
        setTimeout(function(){
            dt.triggerButton($event);
            dt.PopupManager.closePopup($event);
            dt.PopupManager.teaserSwiped = true;
        }, 500);
    }



    function textareaAutosize(){
        $(document)
          .one('focus.textarea', '.kwp textarea', function(){
              var savedValue = this.value;
              this.value = '';
              this.baseScrollHeight = this.scrollHeight;
              this.value = savedValue;
          })
          .on('input.textarea', '.kwp textarea', function(){
              var minRows = this.getAttribute('data-min-rows')|0,
                rows;
              this.rows = minRows;
              rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 16);
              this.rows = minRows + rows;
          });
    }

    dt.autocomplete = function(){
        console.log('in autocomplete()');

        $('#destination').tagsinput({
            maxTags: 3,
            maxChars: 20,
            allowDuplicates: false,
            typeahead: {
            autoSelect: false,
            minLength: 3,
            highlight: true,
            source: function(query) {
                return $.get('https://bentour.reise-wunsch.com/get-all-destinations', {query: query});
            }
            }
        });

        $('#airport').tagsinput({
            maxTags: 3,
            maxChars: 20,
            allowDuplicates: false,
            typeahead: {
            autoSelect: false,
            minLength: 3,
            highlight: true,
            source: function(query) {
                return $.get('https://bentour.reise-wunsch.com/get-all-airports', {query: query});
            }
            }
        });

        $("#destination, #airport").on('itemAdded', function(event) {
            setTimeout(function(){
            $("input[type=text]",".bootstrap-tagsinput").val("");
            }, 1);
        });
    }

    dt.applyBrandColor = function () {

        var layerButtons = $('.primary-btn, .kwp .pax-col .kwp-form-group .pax-more .button a');
        layerButtons.css({
            'background': brandColor,
            'border': '1px solid ' + brandColor,
            'color': '#fff',
        });

        var paxMore = $('.kwp .pax-col .kwp-form-group .pax-more .button a');
        paxMore.css({
            'background': brandColor,
        });

        var durationMore = $('.kwp .duration-col .kwp-form-group .duration-more .button a');
        durationMore.css({
            'background': brandColor,
        });

        var checkboxEl = $('.kwp input[type="checkbox"]:checked:after');
        $('<style>.kwp input[type="checkbox"]:checked:after { background-color: ' + brandColor + '; border: 1px solid ' + brandColor + '; }</style>').appendTo('head');

        var layerHeader = $('.kwp-header.kwp-variant-eil-mobile');
        layerHeader.css({
            'background': brandColor,
        });

        var successHref = $('.kwp-completed-master a');
        $("<style>.kwp-completed-master a { color: " + brandColor + "; }</style>")
            .appendTo(document.documentElement);

    }

    dt.adjustResponsive = function(){
        if( $(window).outerWidth() <= 768 ) {
            $("body").addClass('mobile-layer');
            $(".dt-modal").addClass('m-open');

            dt.PopupManager.isMobile = true;
            dt.PopupManager.layerShown = true;

            $(".kwp-header").css('background', brandColor);

            $('.error-input').siblings('i').css('bottom', '30px');

            $('.dt-modal .submit-col').detach().appendTo('.footer-col');
        } else {
            $("body").removeClass('mobile-layer');
            $(".dt-modal").removeClass('m-open');

            $(".kwp-header").removeAttr('style');

            $('.footer-col .submit-col').detach().appendTo('.kwp-content .kwp-row:last-child');
        }
    }

})(jQuery);
