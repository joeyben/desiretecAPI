var dt = window.dt || {};

(function ($) {

    dt.defaultConfig = {
        baseUrl: 'https://lastminute.reise-wunsch.com',
        logoPath: '/whitelabel/lastminute/images/layer/logo.png',
        popupPath: '/show',
        popupStore:'/store',
        cssPath: '/whitelabel/lastminute/css/layer/whitelabel.css'
    };

    dt.popupTemplate = function (variant) {
        var mobileHeader = dt.PopupManager.decoder.getRandomElement([
            'Dürfen wir Sie beraten?',
        ]);

        var texts = {
            'eil-n1': {
                header: 'Traumferienobjektnoch nicht gefunden?  ',
                body: 'Unsere Reiseberater helfen Ihnen gerne, Ihr persönliches Traumferienhaus zu finden. Probieren Sie es einfach aus!'
            },
            'eil-mobile': {
                header: mobileHeader,
                body: 'Unsere Reiseberater helfen Ihnen gerne, Ihr persönliches Traumferienhaus zu finden. Probieren Sie es einfach aus!'
            }
        };

        return '' +
          '<div class="kwp-header kwp-variant-' + variant + '">' +
          '<div class="kwp-close-button kwp-close"></div>' +
          '<div class="kwp-overlay"></div>' +
          '<div class="kwp-logo"></div>'+
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





    var KwizzmeFakeTripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        name: 'Master WL',
        matchesUrl: 'lastminute',
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
                var catering = getUrlParams('board') ? getUrlParams('board') : '';
                return catering;
            },
            'category': function (form, formData) {
                var category = getUrlParams('stars') ? getUrlParams('stars') : '3';

                return category;
            },
            'destination': function (form, formData) {
                var destination = getUrlParams('depap') ? getUrlParams('depap') : '';
                //return destination;
                return $('.tt-input').val();
            },
            'pax': function (form, formData) {
                var pax = getUrlParams('pax') ? getUrlParams('pax') : '';
                return pax;
            },
            'adults': function (form, formData) {
                var adults = getUrlParams('adult') ? getUrlParams('adult') : '';
                return adults;
            },
            'budget': function (form, formData) {
                var budget = '';
                if(getUrlParams('price')){
                    budget = getUrlParams('price').split(',')[1];
                }
                return budget;
            },
            'kids': function (form, formData) {
                var child = '';
                if(getUrlParams('child')){
                    child = getUrlParams('child').split(',').length;
                }

                return child;
                var kids = getUrlParams('child') ? getUrlParams('child') : '';
                return kids;
            },
            'ages1': function (form, formData) {
                var age_1 = '';
                if(getUrlParams('child')){
                    age_1 = getUrlParams('child').split(',')[0];
                }

                return age_1;

                var age1 = getUrlParams('age1') ? getUrlParams('age1') : '';
                return age1;
            },
            'ages2': function (form, formData) {
                var age_2 = '';
                if(getUrlParams('child')){
                    age_2 = getUrlParams('child').split(',')[1];
                }
                return age_2;

                var age2 = getUrlParams('age2') ? getUrlParams('age2') : '';
                return age2;
            },
            'ages3': function (form, formData) {
                var age_3 = '';
                if(getUrlParams('child')){
                    age_3 = getUrlParams('child').split(',')[2];
                }
                return age_3;


                var age3 = getUrlParams('age3') ? getUrlParams('age3') : '';
                return age3;
            },
            'earliest_start': function (form, formData) {
                var dateFrom = '';
                if(getUrlParams('ddate')){
                    var date = getUrlParams('ddate').split('-');
                    dateFrom = date[2]+'.'+date[1]+'.'+date[0]
                }


                //var dateFrom = getUrlParams('ddate') ? getUrlParams('ddate') : '';
                return dateFrom;
            },
            'latest_return': function (form, formData) {
                var dateTo = '';
                if(getUrlParams('rdate')){
                    var date = getUrlParams('rdate').split('-');
                    dateTo = date[2]+'.'+date[1]+'.'+date[0]
                }

                //var dateTo = getUrlParams('rdate') ? getUrlParams('rdate') : '';
                return dateTo;
            },
            'duration': function (form, formData) {
                var duration = $("select[name='ttform_dur'] option:selected").text();

                switch (duration) {
                    case '1 Woche':
                        duration = '7-';
                        break;
                    case '2 Wochen':
                        duration = '14-';
                        break;
                    case '3 Wochen':
                        duration = '21-';
                        break;
                    case '4 Wochen':
                        duration = '28-'
                        break;
                }

                // check if the selected item end with one of the given options
                if($.inArray(duration.split(' ')[1], ['Woche', 'Wochen', 'Tag', 'Tagen'])){
                    duration = duration.split(' ')[0];
                }

                switch (duration) {
                    case '>22':
                        duration = '22-';
                        break;
                    case '22':
                        duration = '21';
                        break;
                    case 'exakt':
                        duration = 'exact';
                        break;
                }

                if($.isNumeric(duration) == true){
                    console.log('duration is a numeric', duration - 1);
                    return duration - 1;
                }else{
                    console.log('duration is NOT a numeric', duration);
                    return duration;
                }
            },
            'airport': function (form, formData) {
                var airport = getUrlParams('depap') ? getUrlParams('depap') : '';
                return airport;
            },
            'direkt_flug': function (form, formData) {
                var direkt_flug = getUrlParams('dfl') ? getUrlParams('dfl') : '';
                return direkt_flug;
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
                    'eil-n1'
                ]);
            }
        }
    });


    var LastminuteTripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        name: 'Lastminute',
        matchesUrl: 'lastminute-ch-staging.traveltainment.de/*',
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
                var catering = getUrlParams('board') ? getUrlParams('board') : '';
                return catering;
            },
            'category': function (form, formData) {
                var category = getUrlParams('stars') ? getUrlParams('stars') : '3';

                return category;
            },
            'destination': function (form, formData) {
                //var destination = getUrlParams('depap') ? getUrlParams('depap') : '';
                //return destination;
                return $('.tt-input').val();
            },
            'pax': function (form, formData) {
                var pax = getUrlParams('pax') ? getUrlParams('pax') : '';
                return pax;
            },
            'adults': function (form, formData) {
                var adults = getUrlParams('adult') ? getUrlParams('adult') : '';
                return adults;
            },
            'budget': function (form, formData) {
                var budget = '';
                if(getUrlParams('price')){
                    budget = getUrlParams('price').split(',')[1];
                }
                return budget;
            },
            'kids': function (form, formData) {
                var child = '';
                if(getUrlParams('child')){
                    child = getUrlParams('child').split(',').length;
                }

                return child;
                var kids = getUrlParams('child') ? getUrlParams('child') : '';
                return kids;
            },
            'ages1': function (form, formData) {
                var age_1 = '';
                if(getUrlParams('child')){
                    age_1 = getUrlParams('child').split(',')[0];
                }

                return age_1;

                var age1 = getUrlParams('age1') ? getUrlParams('age1') : '';
                return age1;
            },
            'ages2': function (form, formData) {
                var age_2 = '';
                if(getUrlParams('child')){
                    age_2 = getUrlParams('child').split(',')[1];
                }
                return age_2;

                var age2 = getUrlParams('age2') ? getUrlParams('age2') : '';
                return age2;
            },
            'ages3': function (form, formData) {
                var age_3 = '';
                if(getUrlParams('child')){
                    age_3 = getUrlParams('child').split(',')[2];
                }
                return age_3;


                var age3 = getUrlParams('age3') ? getUrlParams('age3') : '';
                return age3;
            },
            'earliest_start': function (form, formData) {
                var dateFrom = '';
                if(getUrlParams('ddate')){
                    var date = getUrlParams('ddate').split('-');
                    dateFrom = date[2]+'.'+date[1]+'.'+date[0]
                }


                //var dateFrom = getUrlParams('ddate') ? getUrlParams('ddate') : '';
                return dateFrom;
            },
            'latest_return': function (form, formData) {
                var dateTo = '';
                if(getUrlParams('rdate')){
                    var date = getUrlParams('rdate').split('-');
                    dateTo = date[2]+'.'+date[1]+'.'+date[0]
                }

                //var dateTo = getUrlParams('rdate') ? getUrlParams('rdate') : '';
                return dateTo;
            },
            'duration': function (form, formData) {
                var duration = $("select[name='ttform_dur'] option:selected").text();

                switch (duration) {
                    case '1 Woche':
                        duration = '7-';
                        break;
                    case '2 Wochen':
                        duration = '14-';
                        break;
                    case '3 Wochen':
                        duration = '21-';
                        break;
                    case '4 Wochen':
                        duration = '28-'
                        break;
                }

                // check if the selected item end with one of the given options
                if($.inArray(duration.split(' ')[1], ['Woche', 'Wochen', 'Tag', 'Tagen'])){
                    duration = duration.split(' ')[0];
                }

                switch (duration) {
                    case '>22':
                        duration = '22-';
                        break;
                    case '22':
                        duration = '21';
                        break;
                    case 'exakt':
                        duration = 'exact'
                        break;
                }


                return duration;
            },
            'airport': function (form, formData) {
                var airport = getUrlParams('depap') ? getUrlParams('depap') : '';
                return airport;
            },
            'direkt_flug': function (form, formData) {
                var direkt_flug = getUrlParams('dfl') ? getUrlParams('dfl') : '';
                return direkt_flug;
            },


            'is_popup_allowed': function (form, formData) {
                //var step = this.getScope().IbeApi.state.stepNr;
                return true;
            }
        },
        getTripData: function () {
            var form = null,
              formData = null;

            $.each(window.dataLayer, function (key, value) {
                if (value.event === "searchFilters") {
                    formData = value.searchFilters;
                }else if (value.event === "searchEvent") {
                    form = value;
                }
            });

            return this.decodeFilterData(form, formData);
        },
        formatDate: function (d) {
            if (!d) {
                return null;
            }

            var f_date = d.split('-');

            return f_date[2] + '.' + f_date[1] + '.' + f_date[0];
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
                ]);
            }
        }
    });

    dt.decoders.push(KwizzmeFakeTripDataDecoder);
    dt.decoders.push(LastminuteTripDataDecoder);


    //dt.decoders.push($.extend({}, MasterIBETripDataDecoder, {
    //    name: 'Landingpages',
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
                exitIntent.cookieManager.create("exit_intent", "yes", exitIntent.cookieExp, exitIntent.sessionOnly);
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


    }

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

    dt.showMobileLayer = function (e) {
        $(".dt-modal").removeClass('teaser-on').find('.teaser').remove();
        $( ".dt-modal" ).addClass('m-open');
        dt.PopupManager.show();
        $("body, html").css({'overflow':'hidden'});
        //$.cookie(dt.PopupManager.mobileCookieId,'true',dt.PopupManager.cookieOptions);
        ga('dt.send', 'event', 'Mobile Layer', 'Teaser shown', 'Mobile');
    };

    $(document).ready(function (e) {
        var $event = e;
        if(isMobile()) {
            dt.PopupManager.teaser = true;
            dt.PopupManager.teaserText = "Dürfen wir Sie beraten?";
            dt.defaultConfig.cssPath = dt.defaultConfig.cssPath.replace('whitelabel.css', 'whitelabel_mobile.css');
            $(".dt-modal .kwp-close").on('touchend',function () {
                dt.PopupManager.closePopup(e);
            });
        }
        dt.PopupManager.init();
        dt.Tracking.init('trendtours_exitwindow','UA-105970361-8');
        dt.triggerButton(e);
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

                for (i = 1; i <= 3; ++i) {

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
                    $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/')
                });
                $( "select[name='ages2']" ).change(function() {
                    $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/')
                });
                $( "select[name='ages3']" ).change(function() {
                    $("input[name='ages']").val($("select[name='ages1'] option:selected").text() + '/' + $("select[name='ages2'] option:selected").text() + '/' + $("select[name='ages3'] option:selected").text() + '/')
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
            var sonnen = cnt === 1 ? "Stern" : "Sterne";
            $('.kwp-star-input').parents('.kwp-form-group').find('.text').text("ab "+cnt+" "+sonnen);
        }

        function highlight(cnt) {
            $('.kwp-star-input .fa-star').each(function () {
                var val = parseInt($(this).attr('data-val'));

                if (val <= cnt) {
                    $(this).addClass('fas');
                    $(this).removeClass('fal');
                } else {
                    $(this).removeClass('fas');
                    $(this).addClass('fal');
                }
            });
            setText(cnt);
        }

        $('.kwp-star-input .fa-star').hover(function () {
            highlight(parseInt($(this).attr('data-val')));
        }).click(function () {
            setValue(parseInt($(this).attr('data-val')));
            var sonnen = parseInt($(this).attr('data-val')) === 1 ? "Stern" : "Sterne";
            $('.kwp-star-input').parents('.kwp-form-group').find('.text').text("ab "+$(this).attr('data-val')+" "+sonnen);
        });

        $('.kwp-star-input').mouseout(function () {
            restoreValue();
        });

        restoreValue();
    };


    dt.agbModal = function (e) {
        e && e.preventDefault();

        var element = null;


        function show() {
            if (element) {
                hide();
            }

            element = $('<div class="dt-modal dt-modal-agb" ><div class="kwp"><div class="kwp-close-button kwp-close"></div><div class="kwp-agb-content"></div></div></div>');



            /*$.ajax({
                url: 'http://master-reisewunsch.com/bundles/csmaster/popup/static/agb.html',
                type: 'GET',
                crossDomain: true,
                dataType: 'jsonp',
                success: function(data) { element.find('.kwp-agb-content').append(data); },
                error: function() {  },
            });			*/

            //element.find('.kwp-agb-content').append(data_agb);
            element.find('.kwp-close').click(hide);
            element.click(function (event) {
                if (event && event.target && !$(event.target).is(element)) {
                    return;
                }
                hide();
            });
            element.appendTo($('body'));
        }

        function hide() {
            element.remove();
            element = null;
        }

        show();

        return false;
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
        }
        return false;
    }

    function getUrlParams(params){
        var url_string = window.location.href;
        var url = new URL(url_string);
        return url.searchParams.get(params);
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

    dt.applyBrandColor = function () {

        var layerButtons = $('.kwp button[type=submit], .kwp .pax-col .kwp-form-group .pax-more .button a');
        layerButtons.css(
            btnPrimaryCss
          ).mouseover(function () {
            $(this).css(
              btnPrimaryHoverCss
            );
          }).mouseout(function () {
            $(this).css(
              btnPrimaryCss
            );
          });

        var paxMore = $('.kwp .pax-col .kwp-form-group .pax-more .button a');
        paxMore.css({
            'background': brandColor,
        });

        var durationMore = $('.kwp .duration-col .kwp-form-group .duration-more .button a');
        durationMore.css({
            'background': brandColor,
        });

        var footerLinks = $('.kwp-agb p a');
        footerLinks.css({
            'color': brandColor,
        });

        var checkboxEl = $('.kwp input[type="checkbox"]:checked:after');
        $('<style>.kwp input[type="checkbox"]:checked:after { background-color: ' + brandColor + '; border: 1px solid ' + brandColor + '; }</style>').appendTo('head');

        var datepicker = $('.datepicker-dropdown .day.active, .datepicker-dropdown .day.active.active:hover, .datepicker-dropdown .day.active:hover,.datepicker-dropdown .day.active.active:hover:hover, .datepicker-dropdown .month.active, .datepicker-dropdown .month.active.active:hover, .datepicker-dropdown .month.active:hover, .datepicker-dropdown .month.active.active:hover:hover, .datepicker-dropdown .year.active, .datepicker-dropdown .year.active.active:hover, .datepicker-dropdown .year.active:hover, .datepicker-dropdown .year.active.active:hover:hover');
        datepicker.css({
            'background': brandColor,
        });

        var footerHref = $('.kwp-agb p a');
        footerHref.css({
            'color': brandColor,
        });

        // $("<style>.kwp-spinner { border: 10px solid " + brandColor + "; }</style>")
        //     .appendTo(document.documentElement);

        var layerHeader = $('.mobile-layer .kwp-header');
        layerHeader.css({
            'background': brandColor,
        });
    }

})(jQuery);
