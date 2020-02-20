var dt = window.dt || {};
var exitIntent = window.exitIntent || {};

(function ($) {

    dt.defaultConfig = {
        baseUrl: 'https://reise-rebellen.reisewunschservice.de',
        popupPath: '/show',
        popupStore:'/store',
        cssPath: '/whitelabel/reiserebellen/css/layer/whitelabel.css'
    };

    var fontAwesomeIcons = jQuery("<link>");
    fontAwesomeIcons.attr({
        rel:  "stylesheet",
        type: "text/css",
        href: "https://mvp.desiretec.com/fontawsome/css/all.css"
    });
    $("head").append(fontAwesomeIcons);


    dt.popupTemplate = function (variant) {

        var texts = {
            'eil-n1-social': {
                header: 'Dürfen wir dich beraten?',
                body: 'Teile uns deinen Reisewunsch mit und du erhältst innerhalb weniger Minuten von den besten Reise-Experten passende Angebote - individuell, kostenlos & in Echtzeit!'
            },
            'eil-tablet': {
                header: 'Dürfen wir dich beraten?',
                body: 'Teile uns deinen Reisewunsch mit und du erhältst innerhalb weniger Minuten von den besten Reise-Experten passende Angebote - individuell, kostenlos & in Echtzeit!'
            },
            'eil-desktop': {
                header: 'Dürfen wir dich beraten?',
                body: 'Teile uns deinen Reisewunsch mit und du erhältst innerhalb weniger Minuten von den besten Reise-Experten passende Angebote - individuell, kostenlos & in Echtzeit!'
            },
            'eil-phone': {
                header: 'Dürfen wir dich beraten?',
                body: 'Teile uns deinen Reisewunsch mit und du erhältst innerhalb weniger Minuten von den besten Reise-Experten passende Angebote - individuell, kostenlos & in Echtzeit!'
            },
            'eil-n4': {
                header: 'Dürfen wir dich beraten?',
                body: 'Teile uns deinen Reisewunsch mit und du erhältst innerhalb weniger Minuten von den besten Reise-Experten passende Angebote - individuell, kostenlos & in Echtzeit!'
            },
            'eil-n5': {
                header: 'Dürfen wir dich beraten?',
                body: 'Teile uns deinen Reisewunsch mit und du erhältst innerhalb weniger Minuten von den besten Reise-Experten passende Angebote - individuell, kostenlos & in Echtzeit!'
            },
            'eil-mobile': {
                header: 'Dürfen wir dich beraten?',
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden!'
            }
        };

        return '' +
            '<div class="kwp-header kwp-variant-' + variant + '">' +
            '<div class="kwp-close-button kwp-close"></div>' +
            '<div class="kwp-overlay"></div>' +
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
        matchesUrl: 'reise-rebellen.reisewunschservice.de|www.reise-rebellen.de/*',
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
            return this.getRandomElement([
                'eil-'+deviceDetector.device,
            ]);
        }
    });
    dt.decoders.push(KwizzmeFakeTripDataDecoder);

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

            dt.Tracking.event('close', this.trackingLabel);
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
            if(deviceDetector.device === "phone") {
                dt.PopupManager.teaser = true;
                dt.PopupManager.teaserText = "Dürfen wir Sie beraten?";
                $(".dt-modal .kwp-close").on('touchend',function () {
                    dt.PopupManager.closePopup(e);
                });
            }
            dt.PopupManager.init();
            dt.Tracking.init('desiretec_exitwindow','UA-105970361-17');
            dt.triggerButton($event);
            if(deviceDetector.device === "phone" && dt.PopupManager.decoder){
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


        dt.agbModal = function (e) {
            e && e.preventDefault();

            var element = null;

            function show() {
                if (element) {
                    hide();
                }

                element = $('<div class="dt-modal dt-modal-agb" ><div class="kwp"><div class="kwp-close-button kwp-close"></div><div class="kwp-agb-content"></div></div></div>');

                element.find('.kwp-agb-content').append(data_agb);
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


        dt.applyBrandColor = function () {

            // brandColor is passed through blade
            var brandColorDarker = brandColor;

            var btnPrimaryCss = {
                'background': brandColor,
                'border': '1px solid ' + brandColor,
                'color': '#fff',
            };
            var btnPrimaryHoverCss = {
                'background': brandColorDarker,
                'border': '1px solid ' + brandColorDarker,
                'color': '#fff',
            };
            var btnSecondaryCss = {
                'background': '#fff',
                'border': '1px solid ' + brandColor,
                'color': brandColor,
            };
            var btnSecondaryHoverCss = {
                'background': '#fff',
                'border': '1px solid ' + brandColorDarker,
                'color': brandColorDarker,
            };

            // Apply styles
            var layerButtons = $('.primary-btn, .kwp .pax-col .kwp-form-group .pax-more .button a');
            layerButtons
                .css(btnPrimaryCss)
                .mouseover(function () {
                    $(this).css(btnPrimaryHoverCss);
                }).mouseout(function () {
                    $(this).css(btnPrimaryCss);
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

            var footerHref = $('.kwp-agb p a');
            footerHref.css({
                'color': brandColor,
            });

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
        };

    })(jQuery);
