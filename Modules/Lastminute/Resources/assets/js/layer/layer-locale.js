var timeoutID;

window.exitIntent = {
    delay: 5,
    showOnDelay: false,
    cookieExp: 0,
    sessionOnly: false,
    inactivitySeconds: 5,
    showPerSessionNumber: 1,

    // Object for handling cookies, taken from QuirksMode
    // http://www.quirksmode.org/js/cookies.html
    cookieManager: {
        // Create a cookie
        create: function (name, value, days, sessionOnly) {
            var expires = "";

            if (sessionOnly)
                expires = "; expires=0";
            else if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }

            document.cookie = name + "=" + value + expires + "; path=/";
        },

        // Get the value of a cookie
        get: function (name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(";");

            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == " ") c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }

            return null;
        },

        // Delete a cookie
        erase: function (name) {
            this.create(name, "", -1);
        }
    },

    // Handle exit intent cookie
    checkCookie: function () {
        //&& this.cookieManager.get("exit_intent_number") >= exitIntent.showPerSessionNumber
        return this.cookieManager.get("exitintent") == "yes";
    },

    createEvent: function (type, bubbles, cancelable) {
        // Crete event on the old-fashioned way (which works with IE)
        // Create the event.
        var event = document.createEvent('Event');

        // Define that the event name
        event.initEvent(type, bubbles, cancelable);

        // Dispatch the event.
        document.dispatchEvent(event);
    },

    // Event listener initialisation for all browsers
    addEvent: function (obj, event, callback) {
        if (obj.addEventListener)
            obj.addEventListener(event, callback, false);
        else if (obj.attachEvent)
            obj.attachEvent("on" + event, callback);
    },

    resetTimer: function () {
        //clearTimeout(timeoutID);

        // timeoutID = setTimeout(this.goInactive, this.inactivitySeconds * 1000);
        //exitIntent.startTimer();
    },

    startTimer: function () {
        // wait {inactivitySeconds} seconds before calling goInactive
        //timeoutID = setTimeout(exitIntent.goInactive, exitIntent.inactivitySeconds * 1000);
    },

    goInactive: function () {
        exitIntent.createEvent('exitintent', true, true);
    },


    // Load event listeners for the popup
    loadEvents: function () {
        // Track mouseout event on document
        this.addEvent(document, "mouseout", function (e) {
            e = e ? e : window.event;

            // If this is an autocomplete element.
            if (e.target.tagName.toLowerCase() == "input")
                return;

            // Get the current viewport width.
            var vpWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

            // If the current mouse X position is within 50px of the right edge
            // of the viewport, return.
            if (e.clientX >= (vpWidth - 50))
                return;

            // If the current mouse Y position is not within 50px of the top
            // edge of the viewport, return.
            if (e.clientY >= 50)
                return;

            // Reliable, works on mouse exiting window and
            // user switching active program
            var from = e.relatedTarget || e.toElement;
            if (!from) {
                if (exitIntent.showOnDelay) {
                    setTimeout(function () {
                        this.createEvent('exitintent', true, true);
                    }, exitIntent.delay * 1000);
                } else {
                    this.createEvent('exitintent', true, true);
                }
            }
        }.bind(this));

        // detect user inactivity

        this.addEvent(document, "mousemove", this.resetTimer);
        this.addEvent(document, "mousedown", this.resetTimer);
        this.addEvent(document, "keypress", this.resetTimer);
        this.addEvent(document, "DOMMouseScroll", this.resetTimer);
        this.addEvent(document, "mousewheel", this.resetTimer);
        this.addEvent(document, "touchmove", this.resetTimer);
        this.addEvent(document, "MSPointerMove", this.resetTimer);

        //this.startTimer();

    },

    // Set user defined options for the popup
    setOptions: function (opts) {
        this.delay = (typeof opts.delay === 'undefined') ? this.delay : opts.delay;
        this.showOnDelay = (typeof opts.showOnDelay === 'undefined') ? this.showOnDelay : opts.showOnDelay;
        this.cookieExp = (typeof opts.cookieExp === 'undefined') ? this.cookieExp : opts.cookieExp;
        this.sessionOnly = (typeof opts.cookieExp === 'undefined') ? this.cookieExp : opts.sessionOnly;
        this.inactivitySeconds = (typeof opts.inactivitySeconds === 'undefined') ? this.inactivitySeconds : opts.inactivitySeconds;
        this.showPerSessionNumber = (typeof opts.showPerSessionNumber === 'undefined') ? this.showPerSessionNumber : opts.showPerSessionNumber;
    },

    // Ensure the DOM has loaded
    domReady: function (callback) {
        (document.readyState === "interactive" || document.readyState === "complete") ? callback() : this.addEvent(document, "DOMContentLoaded", callback);
    },

    // Initialize
    init: function (opts) {
        // Handle options
        if (typeof opts !== 'undefined')
            this.setOptions(opts);

        // Once the DOM has fully loaded
        this.domReady(function () {
            // Delete existing cookies
            if (exitIntent.sessionOnly) {
                exitIntent.cookieManager.erase("exitintent");
                exitIntent.cookieManager.erase("exit_intent_number");
            }

            // Handle the cookie
            if (exitIntent.checkCookie()) return;

            exitIntent.loadEvents();
        });
    }
};

/*!
 * JavaScript Cookie v2.2.0
 * https://github.com/js-cookie/js-cookie
 *
 * Copyright 2006, 2015 Klaus Hartl & Fagner Brack
 * Released under the MIT license
 */
;(function (factory) {
	var registeredInModuleLoader = false;
	if (typeof define === 'function' && define.amd) {
		define(factory);
		registeredInModuleLoader = true;
	}
	if (typeof exports === 'object') {
		module.exports = factory();
		registeredInModuleLoader = true;
	}
	if (!registeredInModuleLoader) {
		var OldCookies = window.Cookies;
		var api = window.Cookies = factory();
		api.noConflict = function () {
			window.Cookies = OldCookies;
			return api;
		};
	}
}(function () {
	function extend () {
		var i = 0;
		var result = {};
		for (; i < arguments.length; i++) {
			var attributes = arguments[ i ];
			for (var key in attributes) {
				result[key] = attributes[key];
			}
		}
		return result;
	}

	function init (converter) {
		function api (key, value, attributes) {
			var result;
			if (typeof document === 'undefined') {
				return;
			}

			// Write

			if (arguments.length > 1) {
				attributes = extend({
					path: '/'
				}, api.defaults, attributes);

				if (typeof attributes.expires === 'number') {
					var expires = new Date();
					expires.setMilliseconds(expires.getMilliseconds() + attributes.expires * 864e+5);
					attributes.expires = expires;
				}

				// We're using "expires" because "max-age" is not supported by IE
				attributes.expires = attributes.expires ? attributes.expires.toUTCString() : '';

				try {
					result = JSON.stringify(value);
					if (/^[\{\[]/.test(result)) {
						value = result;
					}
				} catch (e) {}

				if (!converter.write) {
					value = encodeURIComponent(String(value))
						.replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g, decodeURIComponent);
				} else {
					value = converter.write(value, key);
				}

				key = encodeURIComponent(String(key));
				key = key.replace(/%(23|24|26|2B|5E|60|7C)/g, decodeURIComponent);
				key = key.replace(/[\(\)]/g, escape);

				var stringifiedAttributes = '';

				for (var attributeName in attributes) {
					if (!attributes[attributeName]) {
						continue;
					}
					stringifiedAttributes += '; ' + attributeName;
					if (attributes[attributeName] === true) {
						continue;
					}
					stringifiedAttributes += '=' + attributes[attributeName];
				}
				return (document.cookie = key + '=' + value + stringifiedAttributes);
			}

			// Read

			if (!key) {
				result = {};
			}

			// To prevent the for loop in the first place assign an empty array
			// in case there are no cookies at all. Also prevents odd result when
			// calling "get()"
			var cookies = document.cookie ? document.cookie.split('; ') : [];
			var rdecode = /(%[0-9A-Z]{2})+/g;
			var i = 0;

			for (; i < cookies.length; i++) {
				var parts = cookies[i].split('=');
				var cookie = parts.slice(1).join('=');

				if (!this.json && cookie.charAt(0) === '"') {
					cookie = cookie.slice(1, -1);
				}

				try {
					var name = parts[0].replace(rdecode, decodeURIComponent);
					cookie = converter.read ?
						converter.read(cookie, name) : converter(cookie, name) ||
						cookie.replace(rdecode, decodeURIComponent);

					if (this.json) {
						try {
							cookie = JSON.parse(cookie);
						} catch (e) {}
					}

					if (key === name) {
						result = cookie;
						break;
					}

					if (!key) {
						result[name] = cookie;
					}
				} catch (e) {}
			}

			return result;
		}

		api.set = api;
		api.get = function (key) {
			return api.call(api, key);
		};
		api.getJSON = function () {
			return api.apply({
				json: true
			}, [].slice.call(arguments));
		};
		api.defaults = {};

		api.remove = function (key, attributes) {
			api(key, '', extend(attributes, {
				expires: -1
			}));
		};

		api.withConverter = init;

		return api;
	}

	return init(function () {});
}));

var dt = window.dt || {};


(function($) {
    var Debug = {
        enabled: window.dt && window.dt.debug,
        log: function(message, color) {
            if(!this.enabled) {
                return;
            }

            if(typeof color !== undefined) {
                console.log('%cKwizzme Popup: ' + message, 'color: ' + color + '; background: #f5f5f5;');
                return;
            }

            console.log(message);
        },
        error: function(message) {
            this.log(message, '#F42C4C');
        },
        info: function(message) {
            this.log(message, '#30AEEB');
        },
        warning: function(message) {
            this.log(message, '#FFC83C');
        },
        success: function(message) {
            this.log(message, '#0ADF71');
        }
    };

    if (typeof window.dt.PopupManager !== 'undefined') {
        Debug.warning('Popup script is already loaded. Preventing double load.');
        return;
    }

    dt.decoders = [];

    dt.AbstractTripDataDecoder = {
        filterDataDecoders: {},
        filterFormSelector: null,
        name: 'Abstract Decoder',
        matchesUrl: '',
        trim: function(str, pattern) {
            if(typeof pattern === 'undefined') {
                pattern = '\\s';
            }

            var regexp = new RegExp('^(' + pattern + ')+|(' + pattern + ')+$', 'g');

            return str.replace(regexp, '');
        },
        formArrayToObject: function(arr) {
            var obj = {};
            console.log(arr);

            for(var i = 0; i < arr.length; ++i) {
                if (!arr[i]) {
                    /* Sometimes elements are null... Broken jQuery or markup? */
                    continue;
                }

                var name = arr[i].name,
                    value = arr[i].value;

                if(/^.*\[\]$/.test(name)) {
                    name = this.trim(name, '\\s|\\[\\]');

                    if(typeof obj[name] === 'undefined') {
                        obj[name] = [];
                    }

                    obj[name].push(value);
                    continue;
                }

                obj[name] = value;
            }

            return obj;
        },
        decodeFilterData: function(form, formData) {
            var tripData = {};

            for(var prop in this.filterDataDecoders) {
                if(!this.filterDataDecoders.hasOwnProperty(prop)) {
                    continue;
                }

                var val = this.filterDataDecoders[prop].call(this, form, formData);

                if(!val) {
                    continue;
                }

                tripData[prop] = val;
            }

            return tripData;
        },
        getTripData: function() {
            var form = jQuery(this.filterFormSelector),
                formData = this.formArrayToObject(form.serializeArray());

            return this.decodeFilterData(form, formData);
        },
        getSelectText: function(name, value, trimPattern) {
            return this.trim(jQuery(this.filterFormSelector)
                .find('select[name="' + name + '"] option[value="' + value + '"]').text(), trimPattern);
        },
        dictionaryTransformValue: function(dictionary, key, prop) {
            if(!dictionary.hasOwnProperty(key)) {
                return null;
            }

            if(typeof prop !== 'undefined') {
                return dictionary[key][prop];
            }

            return dictionary[key];
        },
        dictionaryTransformArray: function(dictionary, keys, prop) {
            if(typeof keys === 'undefined') {
                return null;
            }

            var result = [];

            for(var i = 0; i < keys.length; ++i) {
                var key = keys[i],
                    value = this.dictionaryTransformValue(dictionary, key, prop);

                if(null === value || jQuery.inArray(value, result) > -1) {
                    continue;
                }

                result.push(value);
            }

            if(result.length == 0) {
                return null;
            }

            return result;
        },
        getTrackingLabel: function(tripData, variant) {
            return variant;
        }
    };

    dt.PopupManager = {
        initialized: false,
        decoder: null,
        popup: null,
        popupBody: null,
        isZeroResult: null,
        variant: null,
        trackingLabel: null,
        back: false,
        next: false,
        blocked: false,
        isMobile: false,
        mobileCookieId: 'm_kiwzzme',
        regionCodes:{},
        testCookieId: 'desiretec',
        shown: false,
        teaser:false,
        teaserText: "Darf ich Sie beraten?",
        isFromPaidTraffic: function() {
            return Cookies.get('utag.data.exclude_lead') == 1;
        },
        init: function() {
            if (this.initialized) {
                Debug.warning('Popup script is already initialized. Preventing double init.');
                return;
            }

            Debug.info('Initializing...');

            this.config = jQuery.extend({}, dt.defaultConfig, window.dt.config);

            this.selectDecoder();

            if (this.decoder) {
                Debug.success('Selected decoder: ' + this.decoder.name);
            }

            this.shown = false;

            this.installStyles();
            this.createPopup();

            if(jQuery.isArray(window.dt.initCallbacks)) {
                for(var i = 0; i < window.dt.initCallbacks.length; ++i) {
                    window.dt.initCallbacks[i](this);
                }
            }

            this.initialized = true;
        },
        setBack: function(event) {
            jQuery('input[name="step"]').val(1);
            this.back = true;
            this.onFormSubmit(event);
        },
        setNext: function(event) {
            this.next = true;
            this.onFormSubmit(event);
        },
        setVariant: function() {
            if (this.decoder && typeof this.decoder.getVariant === 'function') {
                this.variant = this.decoder.getVariant();
            }

            Debug.info('Variant selected: ' + this.variant);
        },
        installStyles: function() {
            jQuery('head').append(
                jQuery('<link rel="stylesheet" type="text/css" media="all" href="' + this.config.baseUrl + this.config.cssPath + '"/>')
            );
        },
        initExitIntent: function () {
            $.exitIntent('enable', { 'sensitivity': 0 });
            $(document).bind('exitintent',
                function() {
                    dt.PopupManager.show();
                });
        },
        //getFieldValue: function(selector) {
        //    field = $(selector);
        //
        //    switch (field.prop('tagName')) {
        //        case 'INPUT':
        //            switch (field.attr('type')) {
        //                case 'file':
        //                    return null;
        //
        //                case 'checkbox':
        //                case 'radio':
        //                    return field.filter(':checked').map(function () {
        //                        return $(this).val();
        //                    }).toArray();
        //
        //                default:
        //                    return field.val();
        //            }
        //
        //        case 'TEXTAREA':
        //            return field.val();
        //
        //        case 'SELECT':
        //            if (field.attr('multiple')) {
        //                return field.find('option:selected').map(function () {
        //                    return $(this).val();
        //                }).toArray();
        //            }
        //
        //            return field.val();
        //
        //        default:
        //            Debug.error('Unknown form field type.');
        //    }
        //},
        selectDecoder: function() {
            for(var i = 0; i < dt.decoders.length; ++i) {
                var decoder = dt.decoders[i],
                    regex = new RegExp(decoder.matchesUrl);

                Debug.info('Trying ' + decoder.name);

                if(regex.test(String(window.location))) {
                    this.decoder = decoder;
                    return;
                }
            }

            Debug.error('No suitable decoder found!');
        },
        fetchPopup: function() {
            var tripData;

            if (this.decoder) {
                tripData = this.decoder.getTripData();

                if (!tripData.is_popup_allowed) {
                    Debug.warning('Popup canceled because popup not allowed here.');
                    return false;
                }

                if(typeof tripData.is_zero_result !== 'undefined') {
                    this.isZeroResult = tripData.is_zero_result;
                }

                this.setVariant();
                this.createPopup();
            } else {
                if (window.dt.force) {
                    tripData = {};
                    this.setVariant();
                    this.createPopup();
                } else {
                    jQuery.error('Popup not allowed.');
                    return false;
                }
            }

            this.trackingLabel = this.decoder.getTrackingLabel(tripData, this.variant);

            this.popupBody.html('<div class="kwp-spinner"></div>');

            tripData.first_fetch = 'yes';
            jQuery.ajax(this.config.baseUrl + this.config.popupPath + this.getQueryPart(), {
                type: 'GET',
                data: tripData,
                dataType: 'html',
                contentType: 'application/x-www-form-urlencoded',
                success: jQuery.proxy(this.onPopupFetched, this),
                xhrFields: {
                    withCredentials: false
                }
            });

            if (typeof window.dt.triggerCallback === 'function') {
                window.dt.triggerCallback();
            }
            if(!this.shown){
                // mixpanel.track(
                //    "Show Layer"
                // );
                dt.Tracking.event('shown', this.trackingLabel);
                this.shown = true;
            }
            this.showPopup();

            var data = this.popup.find('form').serializeArray().reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});

            // mixpanel.identify(data.data_id);

            return true;
        },
        onPopupFetched: function(data, status, jqxhr) {
            var json = $.parseJSON(data);
            this.showContent(json.html);
        },
        show: function() {
            Debug.info('::show:start');

            if(this.isFromPaidTraffic()) {
                Debug.info('::popup-disabled');

                return;
            }

            if(this.shown || this.blocked) {
                return;
            }

            this.shown = this.fetchPopup();

            if (this.shown) {
                if (typeof dt.exitIntent !== 'undefined') {
                    dt.exitIntent.setCookie();
                }
            }

            if (this.shown) {
                Debug.info('::shown');
            }
        },
        changeTexts: function(headline, tagline) {
            this.popup.find('.kwp-header-content h1').html(headline);
            this.popup.find('.kwp-header-content p').html(tagline);
        },
        showContent: function(content) {
            this.popupBody.html(content);
            this.popup.find('#back-button').click($.proxy(this.setBack, this));
            this.popup.find('#submit-button').click($.proxy(this.onFormSubmit, this));
            this.popup.find('#next-button').click($.proxy(this.setNext, this));
            this.popup.find('.kwp-close').click($.proxy(this.closePopup, this));
            if($(".kwp-content").hasClass('kwp-completed-tui') || $(".kwp-content").hasClass('kwp-completed')){
                if( dt.PopupManager.isMobile){
                    $(".kwp-header").hide();
                }
                $(".kwp-header").addClass('success');
                $(".kwp-header-content").addClass('hidden-content');
            }else{
                if(dt.PopupManager.decoder.name == "TUI IBE"){

                }else {

                }
            }

        },
        showPopup: function() {
            var self = this;

            this.modal.css('display', 'block');

            setTimeout(function() {
                self.popup.addClass('dt-modal-visible');
                if(self.variant === "steps"){
                    self.popup.addClass('steps');
                }
            }, 2);
            Debug.info('::showPopup');
        },
        onBackdropClick: function(event) {
            if(event && event.target && !jQuery(event.target).is(this.modal)) {
                return;
            }

            this.closePopup(event)
        },
        closePopup: function(event) {
            event.preventDefault();

            this.modal.css('display', 'none');
            this.shown = false;

            dt.Tracking.event('close', this.trackingLabel);
            // mixpanel.track(
            //     "Close Layer"
            // );
        },
        createPopup: function() {
            if(null === this.popup) {
                this.popup = jQuery('<div/>', {'class': 'kwp'});

                this.modal =
                    jQuery('<div/>', {'class': 'dt-modal'})
                        .hide()
                        .append(this.popup)
                //.click(jQuery.proxy(this.onBackdropClick, this))
                ;
                if(dt.PopupManager.teaser){
                    this.teaser = jQuery('<div/>', {'class': 'teaser'}).append('<h1>'+this.teaserText+'</h1><i class="fal fa-times"></i>');
                    this.modal.append(this.teaser);
                }
                jQuery('body').prepend(this.modal);
            }

            var html = dt.popupTemplate;

            if (typeof html === 'function') {
                if (!this.variant) {
                    Debug.warning('Template is object but no variant set, skipping...');
                    return;
                }

                html = html(this.variant);
            }

            this.popup.html(html);
            this.popupBody = this.popup.find('.kwp-body');
        },
        getQueryPart: function() {
            var part = '';

            if (this.variant) {
                part +=  '?variant=' + this.variant;
            }

            if(this.back) {
                part += '&back=true'
            }

            if(this.next) {
                part += '&next=true'
            }

            return part;
        },
        onFormSubmit: function(event) {
            event.preventDefault();

            if(typeof window.dt.conversionCallback === 'function') {
                window.dt.conversionCallback();
            }

            var formData = this.popup.find('form').serialize();
            var data = this.popup.find('form').serializeArray();

            var dataArray = data.reduce(function(obj, item) {
                obj[item.name] = item.value;
                return obj;
            }, {});
            this.popupBody.html('<div class="kwp-spinner"></div>');

            jQuery.ajax(this.config.baseUrl + this.config.popupStore + this.getQueryPart(), {
                type: 'GET',
                data: formData,
                dataType: 'html',
                crossDomain: true,
                contentType: 'application/x-www-form-urlencoded',
                success: jQuery.proxy(this.onPopupFetched, this),
                xhrFields: {
                    withCredentials: false
                }
            });

            dt.Tracking.event('Submit-Button', this.trackingLabel);
            /*  mixpanel.track(
                  "Layer submitted",
                  {
                      "__email": dataArray.__email,
                      "__name": dataArray.__name,
                      "age_1": dataArray.age_1  ? dataArray.age_1: "",
                      "age_2": dataArray.age_2  ? dataArray.age_2: "",
                      "age_3": dataArray.age_3  ? dataArray.age_3: "",
                      "airport": dataArray.airport,
                      "budget": dataArray.budget,
                      "catering": dataArray.catering,
                      "children": dataArray.children,
                      "description": dataArray.description,
                      "destination": dataArray.destination,
                      "duration": dataArray.duration,
                      "earliest_start": dataArray.earliest_start,
                      "hotel_category": dataArray.hotel_category,
                      "latest_return": dataArray.latest_return,
                      "pax": dataArray.pax
                  }
              );

              mixpanel.people.set({
                  "$name": dataArray.__name,
                  "$email": dataArray.__email
              });*/

            this.back = false;
            this.next = false;
        }
    };

    dt.Tracking = {
        isInitialized: false,
        category: 'exit_window',
        init: function(category, TrackingId) {
            if (typeof window.ga === 'undefined') {
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
                window.ga=window.ga||function(){(ga.q=ga.q||[]).push(arguments)};ga.l=+new Date;
            }



            ga('create', TrackingId, 'auto', {'name': 'DesireTec'});
            ga('DesireTec.set', 'anonymizeIp', true);

            if(window.dt && window.dt.debug) {
                window.ga_debug = {trace: true};
            }

            this.isInitialized = true;

            if(typeof category !== 'undefined') {
                this.category = category;
            }
        },
        initMixpanel: function(siteId){

            /*(function(e,a){if(!a.__SV){var b=window;try{var c,l,i,j=b.location,g=j.hash;c=function(a,b){return(l=a.match(RegExp(b+"=([^&]*)")))?l[1]:null};g&&c(g,"state")&&(i=JSON.parse(decodeURIComponent(c(g,"state"))),"mpeditor"===i.action&&(b.sessionStorage.setItem("_mpcehash",g),history.replaceState(i.desiredHash||"",e.title,j.pathname+j.search)))}catch(m){}var k,h;window.mixpanel=a;a._i=[];a.init=function(b,c,f){function e(b,a){var c=a.split(".");2==c.length&&(b=b[c[0]],a=c[1]);b[a]=function(){b.push([a].concat(Array.prototype.slice.call(arguments,
                0)))}}var d=a;"undefined"!==typeof f?d=a[f]=[]:f="mixpanel";d.people=d.people||[];d.toString=function(b){var a="mixpanel";"mixpanel"!==f&&(a+="."+f);b||(a+=" (stub)");return a};d.people.toString=function(){return d.toString(1)+".people (stub)"};k="disable time_event track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config reset people.set people.set_once people.increment people.append people.union people.track_charge people.clear_charges people.delete_user".split(" ");
                for(h=0;h<k.length;h++)e(d,k[h]);a._i.push([b,c,f])};a.__SV=1.2;b=e.createElement("script");b.type="text/javascript";b.async=!0;b.src="undefined"!==typeof MIXPANEL_CUSTOM_LIB_URL?MIXPANEL_CUSTOM_LIB_URL:"file:"===e.location.protocol&&"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js".match(/^\/\//)?"https://cdn.mxpnl.com/libs/mixpanel-2-latest.min.js":"//cdn.mxpnl.com/libs/mixpanel-2-latest.min.js";c=e.getElementsByTagName("script")[0];c.parentNode.insertBefore(b,c)}})(document,window.mixpanel||[]);
            mixpanel.init("a7f133d26ec0d61821d143437f67f6f3");*/


            /*  mixpanel.people.set({
                  "$siteID": siteId
              });
              jQuery('body').on('blur','.dt-modal input[type=text]',function() {
                  mixpanel.track(
                      jQuery(this).attr('name'),
                      {'value':jQuery(this).val()}
                  )
              });*/
        },
        rawEvent: function (category, action, label) {
            ga('DesireTec.send', 'event', category, action, label);
        },
        event: function(action, label) {
            if(!this.isInitialized) {
                return;
            }

            this.rawEvent(this.category, action, label);
        }
    };

    dt.validateEmail = function(field, hint) {
        var $field = jQuery(field),
            $hint = jQuery(hint),
            typos = {
                'tonline.de': 't-online.de',
                't-onlin.de': 't-online.de',
                't-onlne.de': 't-online.de',
                't-oline.de': 't-online.de',
                'frenet.de': 'freenet.de',
                'gemx.de': 'gmx.de',
                'gemx.net': 'gmx.net',
                'gmai.com': 'gmail.com',
                'gmal.com': 'gmail.com',
                'gmil.com': 'gmail.com'
            },
            lastVal = null,
            corrected = null;

        $hint.click(function() {
            if (corrected) {
                $field.val(corrected);
                $hint.hide();
            }
        });

        $field.on('change keyup', function() {
            var val = $field.val().trim();

            if (val === lastVal) {
                return;
            }

            lastVal = val;

            $hint.hide();

            var groups = /^([^@]+)@(.*)$/.exec(val),
                host;

            if (!groups) {
                return;
            }

            host = groups[2];
            corrected = groups[1] + '@' + typos[host];

            if (typos[host] !== undefined) {
                $hint.html('Meinten Sie <strong>' + corrected + '</strong>?');
                $hint.fadeIn(100);
            }
        });
    };

    if(window.dt && window.dt.debug) {
        jQuery(document).keypress(function (e) {
            if (e.charCode == 103) {
                dt.PopupManager.show();
            }
        });
    }

})(jQuery);


(function($) {

    'use strict';

    // Polyfill Number.isNaN(value)
    // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isNaN
    Number.isNaN = Number.isNaN || function(value) {
        return typeof value === 'number' && value !== value;
    };

    /**
     * Range feature detection
     * @return {Boolean}
     */
    function supportsRange() {
        var input = document.createElement('input');
        input.setAttribute('type', 'range');
        return input.type !== 'text';
    }

    var pluginName = 'rangeslider',
        pluginIdentifier = 0,
        hasInputRangeSupport = supportsRange(),
        defaults = {
            polyfill: true,
            orientation: 'horizontal',
            rangeClass: 'rangeslider',
            disabledClass: 'rangeslider--disabled',
            activeClass: 'rangeslider--active',
            horizontalClass: 'rangeslider--horizontal',
            verticalClass: 'rangeslider--vertical',
            fillClass: 'rangeslider__fill',
            handleClass: 'rangeslider__handle',
            startEvent: ['mousedown', 'touchstart', 'pointerdown'],
            moveEvent: ['mousemove', 'touchmove', 'pointermove'],
            endEvent: ['mouseup', 'touchend', 'pointerup']
        },
        constants = {
            orientation: {
                horizontal: {
                    dimension: 'width',
                    direction: 'left',
                    directionStyle: 'left',
                    coordinate: 'x'
                },
                vertical: {
                    dimension: 'height',
                    direction: 'top',
                    directionStyle: 'bottom',
                    coordinate: 'y'
                }
            }
        };

    /**
     * Delays a function for the given number of milliseconds, and then calls
     * it with the arguments supplied.
     *
     * @param  {Function} fn   [description]
     * @param  {Number}   wait [description]
     * @return {Function}
     */
    function delay(fn, wait) {
        var args = Array.prototype.slice.call(arguments, 2);
        return setTimeout(function(){ return fn.apply(null, args); }, wait);
    }

    /**
     * Returns a debounced function that will make sure the given
     * function is not triggered too much.
     *
     * @param  {Function} fn Function to debounce.
     * @param  {Number}   debounceDuration OPTIONAL. The amount of time in milliseconds for which we will debounce the function. (defaults to 100ms)
     * @return {Function}
     */
    function debounce(fn, debounceDuration) {
        debounceDuration = debounceDuration || 100;
        return function() {
            if (!fn.debouncing) {
                var args = Array.prototype.slice.apply(arguments);
                fn.lastReturnVal = fn.apply(window, args);
                fn.debouncing = true;
            }
            clearTimeout(fn.debounceTimeout);
            fn.debounceTimeout = setTimeout(function(){
                fn.debouncing = false;
            }, debounceDuration);
            return fn.lastReturnVal;
        };
    }

    /**
     * Check if a `element` is visible in the DOM
     *
     * @param  {Element}  element
     * @return {Boolean}
     */
    function isHidden(element) {
        return (
            element && (
                element.offsetWidth === 0 ||
                element.offsetHeight === 0 ||
                // Also Consider native `<details>` elements.
                element.open === false
            )
        );
    }

    /**
     * Get hidden parentNodes of an `element`
     *
     * @param  {Element} element
     * @return {[type]}
     */
    function getHiddenParentNodes(element) {
        var parents = [],
            node    = element.parentNode;

        while (isHidden(node)) {
            parents.push(node);
            node = node.parentNode;
        }
        return parents;
    }

    /**
     * Returns dimensions for an element even if it is not visible in the DOM.
     *
     * @param  {Element} element
     * @param  {String}  key     (e.g. offsetWidth …)
     * @return {Number}
     */
    function getDimension(element, key) {
        var hiddenParentNodes       = getHiddenParentNodes(element),
            hiddenParentNodesLength = hiddenParentNodes.length,
            inlineStyle             = [],
            dimension               = element[key];

        // Used for native `<details>` elements
        function toggleOpenProperty(element) {
            if (typeof element.open !== 'undefined') {
                element.open = (element.open) ? false : true;
            }
        }

        if (hiddenParentNodesLength) {
            for (var i = 0; i < hiddenParentNodesLength; i++) {

                // Cache style attribute to restore it later.
                inlineStyle[i] = hiddenParentNodes[i].style.cssText;

                // visually hide
                if (hiddenParentNodes[i].style.setProperty) {
                    hiddenParentNodes[i].style.setProperty('display', 'block', 'important');
                } else {
                    hiddenParentNodes[i].style.cssText += ';display: block !important';
                }
                hiddenParentNodes[i].style.height = '0';
                hiddenParentNodes[i].style.overflow = 'hidden';
                hiddenParentNodes[i].style.visibility = 'hidden';
                toggleOpenProperty(hiddenParentNodes[i]);
            }

            // Update dimension
            dimension = element[key];

            for (var j = 0; j < hiddenParentNodesLength; j++) {

                // Restore the style attribute
                hiddenParentNodes[j].style.cssText = inlineStyle[j];
                toggleOpenProperty(hiddenParentNodes[j]);
            }
        }
        return dimension;
    }

    /**
     * Returns the parsed float or the default if it failed.
     *
     * @param  {String}  str
     * @param  {Number}  defaultValue
     * @return {Number}
     */
    function tryParseFloat(str, defaultValue) {
        var value = parseFloat(str);
        return Number.isNaN(value) ? defaultValue : value;
    }

    /**
     * Capitalize the first letter of string
     *
     * @param  {String} str
     * @return {String}
     */
    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.substr(1);
    }

    /**
     * Plugin
     * @param {String} element
     * @param {Object} options
     */
    function Plugin(element, options) {
        this.$window            = $(window);
        this.$document          = $(document);
        this.$element           = $(element);
        this.options            = $.extend( {}, defaults, options );
        this.polyfill           = this.options.polyfill;
        this.orientation        = this.$element[0].getAttribute('data-orientation') || this.options.orientation;
        this.onInit             = this.options.onInit;
        this.onSlide            = this.options.onSlide;
        this.onSlideEnd         = this.options.onSlideEnd;
        this.DIMENSION          = constants.orientation[this.orientation].dimension;
        this.DIRECTION          = constants.orientation[this.orientation].direction;
        this.DIRECTION_STYLE    = constants.orientation[this.orientation].directionStyle;
        this.COORDINATE         = constants.orientation[this.orientation].coordinate;

        // Plugin should only be used as a polyfill
        if (this.polyfill) {
            // Input range support?
            if (hasInputRangeSupport) { return false; }
        }

        this.identifier = 'js-' + pluginName + '-' +(pluginIdentifier++);
        this.startEvent = this.options.startEvent.join('.' + this.identifier + ' ') + '.' + this.identifier;
        this.moveEvent  = this.options.moveEvent.join('.' + this.identifier + ' ') + '.' + this.identifier;
        this.endEvent   = this.options.endEvent.join('.' + this.identifier + ' ') + '.' + this.identifier;
        this.toFixed    = (this.step + '').replace('.', '').length - 1;
        this.$fill      = $('<div class="' + this.options.fillClass + '" />');
        this.$handle    = $('<div class="' + this.options.handleClass + '" />');
        this.$range     = $('<div class="' + this.options.rangeClass + ' ' + this.options[this.orientation + 'Class'] + '" id="' + this.identifier + '" />').insertAfter(this.$element).prepend(this.$fill, this.$handle);

        // visually hide the input
        this.$element.css({
            'position': 'absolute',
            'width': '1px',
            'height': '1px',
            'overflow': 'hidden',
            'opacity': '0'
        });

        // Store context
        this.handleDown = $.proxy(this.handleDown, this);
        this.handleMove = $.proxy(this.handleMove, this);
        this.handleEnd  = $.proxy(this.handleEnd, this);

        this.init();

        // Attach Events
        var _this = this;
        this.$window.on('resize.' + this.identifier, debounce(function() {
            // Simulate resizeEnd event.
            delay(function() { _this.update(false, false); }, 300);
        }, 20));

        this.$document.on(this.startEvent, '#' + this.identifier + ':not(.' + this.options.disabledClass + ')', this.handleDown);

        // Listen to programmatic value changes
        this.$element.on('change.' + this.identifier, function(e, data) {
            if (data && data.origin === _this.identifier) {
                return;
            }

            var value = e.target.value,
                pos = _this.getPositionFromValue(value);
            _this.setPosition(pos);
        });
    }

    Plugin.prototype.init = function() {
        this.update(true, false);

        if (this.onInit && typeof this.onInit === 'function') {
            this.onInit();
        }
    };

    Plugin.prototype.update = function(updateAttributes, triggerSlide) {
        updateAttributes = updateAttributes || false;

        if (updateAttributes) {
            this.min    = tryParseFloat(this.$element[0].getAttribute('min'), 0);
            this.max    = tryParseFloat(this.$element[0].getAttribute('max'), 100);
            this.value  = tryParseFloat(this.$element[0].value, Math.round(this.min + (this.max-this.min)/2));
            this.step   = tryParseFloat(this.$element[0].getAttribute('step'), 1);
        }

        this.handleDimension    = getDimension(this.$handle[0], 'offset' + ucfirst(this.DIMENSION));
        this.rangeDimension     = getDimension(this.$range[0], 'offset' + ucfirst(this.DIMENSION));
        this.maxHandlePos       = this.rangeDimension - this.handleDimension;
        this.grabPos            = this.handleDimension / 2;
        this.position           = this.getPositionFromValue(this.value);

        // Consider disabled state
        if (this.$element[0].disabled) {
            this.$range.addClass(this.options.disabledClass);
        } else {
            this.$range.removeClass(this.options.disabledClass);
        }

        this.setPosition(this.position, triggerSlide);
    };

    Plugin.prototype.handleDown = function(e) {
        e.preventDefault();

        // Only respond to mouse main button clicks (usually the left button)
        if (e.button && e.button !== 0) { return; }

        this.$document.on(this.moveEvent, this.handleMove);
        this.$document.on(this.endEvent, this.handleEnd);

        // add active class because Firefox is ignoring
        // the handle:active pseudo selector because of `e.preventDefault();`
        this.$range.addClass(this.options.activeClass);

        // If we click on the handle don't set the new position
        if ((' ' + e.target.className + ' ').replace(/[\n\t]/g, ' ').indexOf(this.options.handleClass) > -1) {
            return;
        }

        var pos         = this.getRelativePosition(e),
            rangePos    = this.$range[0].getBoundingClientRect()[this.DIRECTION],
            handlePos   = this.getPositionFromNode(this.$handle[0]) - rangePos,
            setPos      = (this.orientation === 'vertical') ? (this.maxHandlePos - (pos - this.grabPos)) : (pos - this.grabPos);

        this.setPosition(setPos);

        if (pos >= handlePos && pos < handlePos + this.handleDimension) {
            this.grabPos = pos - handlePos;
        }
    };

    Plugin.prototype.handleMove = function(e) {
        e.preventDefault();
        var pos = this.getRelativePosition(e);
        var setPos = (this.orientation === 'vertical') ? (this.maxHandlePos - (pos - this.grabPos)) : (pos - this.grabPos);
        this.setPosition(setPos);
    };

    Plugin.prototype.handleEnd = function(e) {
        e.preventDefault();
        this.$document.off(this.moveEvent, this.handleMove);
        this.$document.off(this.endEvent, this.handleEnd);

        this.$range.removeClass(this.options.activeClass);

        // Ok we're done fire the change event
        this.$element.trigger('change', { origin: this.identifier });

        if (this.onSlideEnd && typeof this.onSlideEnd === 'function') {
            this.onSlideEnd(this.position, this.value);
        }
    };

    Plugin.prototype.cap = function(pos, min, max) {
        if (pos < min) { return min; }
        if (pos > max) { return max; }
        return pos;
    };

    Plugin.prototype.setPosition = function(pos, triggerSlide) {
        var value, newPos;

        if (triggerSlide === undefined) {
            triggerSlide = true;
        }

        // Snapping steps
        value = this.getValueFromPosition(this.cap(pos, 0, this.maxHandlePos));
        newPos = this.getPositionFromValue(value);

        // Update ui
        this.$fill[0].style[this.DIMENSION] = (newPos + this.grabPos) + 'px';
        this.$handle[0].style[this.DIRECTION_STYLE] = newPos + 'px';
        this.setValue(value);

        // Update globals
        this.position = newPos;
        this.value = value;

        if (triggerSlide && this.onSlide && typeof this.onSlide === 'function') {
            this.onSlide(newPos, value);
        }
    };

    // Returns element position relative to the parent
    Plugin.prototype.getPositionFromNode = function(node) {
        var i = 0;
        while (node !== null) {
            i += node.offsetLeft;
            node = node.offsetParent;
        }
        return i;
    };

    Plugin.prototype.getRelativePosition = function(e) {
        // Get the offset DIRECTION relative to the viewport
        var ucCoordinate = ucfirst(this.COORDINATE),
            rangePos = this.$range[0].getBoundingClientRect()[this.DIRECTION],
            pageCoordinate = 0;

        if (typeof e.originalEvent['client' + ucCoordinate] !== 'undefined') {
            pageCoordinate = e.originalEvent['client' + ucCoordinate];
        }
        else if (
            e.originalEvent.touches &&
            e.originalEvent.touches[0] &&
            typeof e.originalEvent.touches[0]['client' + ucCoordinate] !== 'undefined'
        ) {
            pageCoordinate = e.originalEvent.touches[0]['client' + ucCoordinate];
        }
        else if(e.currentPoint && typeof e.currentPoint[this.COORDINATE] !== 'undefined') {
            pageCoordinate = e.currentPoint[this.COORDINATE];
        }

        return pageCoordinate - rangePos;
    };

    Plugin.prototype.getPositionFromValue = function(value) {
        var percentage, pos;
        percentage = (value - this.min)/(this.max - this.min);
        pos = (!Number.isNaN(percentage)) ? percentage * this.maxHandlePos : 0;
        return pos;
    };

    Plugin.prototype.getValueFromPosition = function(pos) {
        var percentage, value;
        percentage = ((pos) / (this.maxHandlePos || 1));
        value = this.step * Math.round(percentage * (this.max - this.min) / this.step) + this.min;
        return Number((value).toFixed(this.toFixed));
    };

    Plugin.prototype.setValue = function(value) {
        if (value === this.value && this.$element[0].value !== '') {
            return;
        }

        // Set the new value and fire the `input` event
        this.$element
            .val(value)
            .trigger('input', { origin: this.identifier });
    };

    Plugin.prototype.destroy = function() {
        this.$document.off('.' + this.identifier);
        this.$window.off('.' + this.identifier);

        this.$element
            .off('.' + this.identifier)
            .removeAttr('style')
            .removeData('plugin_' + pluginName);

        // Remove the generated markup
        if (this.$range && this.$range.length) {
            this.$range[0].parentNode.removeChild(this.$range[0]);
        }
    };

    // A really lightweight plugin wrapper around the constructor,
    // preventing against multiple instantiations
    $.fn[pluginName] = function(options) {
        var args = Array.prototype.slice.call(arguments, 1);

        return this.each(function() {
            var $this = $(this),
                data  = $this.data('plugin_' + pluginName);

            // Create a new instance.
            if (!data) {
                $this.data('plugin_' + pluginName, (data = new Plugin(this, options)));
            }

            // Make it possible to access methods from public.
            // e.g `$element.rangeslider('method');`
            if (typeof options === 'string') {
                data[options].apply(data, args);
            }
        });
    };

    return 'rangeslider.js is available in jQuery context e.g $(selector).rangeslider(options);';

})(jQuery);
var dt = window.dt || {};
var exitIntent = window.exitIntent || {};

(function ($) {

    dt.defaultConfig = {
        baseUrl: 'http://lastminute.com',
        logoPath: '/whitelabel/lastminute/images/layer/logo.png',
        popupPath: '/show',
        popupStore:'/store',
        cssPath: '/whitelabel/lastminute/css/layer/whitelabel.css'
    };

    dt.popupTemplate = function (variant) {

        var mobileHeader = dt.PopupManager.decoder.getRandomElement([
            'Jetzt Ihre Reise wünschen und Angebot erhalten!',
            'Dürfen wir Sie beraten?',
            'Hier klicken und persönliches Angebot erhalten',
            'Nicht das Passende gefunden?'
        ]);

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
                header: mobileHeader,
                body: 'Unsere besten Reiseberater helfen Ihnen gerne, Ihre persönliche Traumreise zu finden!'
            }
        };

        return '' +
            '<div class="kwp-header kwp-variant-' + variant + '">' +
            '<div class="kwp-close-button kwp-close"></div>' +
            '<div class="kwp-overlay"></div>' +
            '<div class="kwp-logo"></div>' +
            '<div class="kwp-header-content">' +
            '<!--h1>' +
            texts[variant].header + ' <br/>' +
            '</h1-->' +
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
        name: 'TUI Rundreisen Mobile',
        matchesUrl: 'm.lastminute.com/(buchen)',
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
                var pax = $(".search-criteria-list li:eq( 4 ) strong").attr('title').split(',');
                return parseInt(pax[0].replace(' Erwachsene',''));
            },
            'budget': function (form, formData) {
                return '';
            },
            'children': function (form, formData) {
                var pax = $(".search-criteria-list li:eq( 4 ) strong").attr('title').split(',')
                return parseInt(pax[1].replace(' Kinder',''));
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
                var duration = $(".search-criteria-list li:eq( 2 ) strong").attr('title');
                duration = duration.replace(' Wochen', '-');
                duration = duration.replace(' Tage', '');
                return duration;
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
            return 'eil-mobile';
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

    var MasterIBETripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        decodeDate: function (raw) {
            var r = /\w+\.\s+(\d+\.\d+.\d+)/.exec(raw);

            if (r === null || r.length !== 2) {
                return null;
            }

            return r[1];
        },
        name: 'TUI IBE',
        matchesUrl: 'www.lastminute.com/(hotel|pauschalreisen|last-minute)(/[a-z-]+)*/suchen|airtours.de',
        filterFormSelector: '#ibeContainer',
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
                var lowestBoardWeigth = 100,
                    lowestBoard = null,
                    boardTypes = formData.boardTypes
                ;

                if (!boardTypes || !boardTypes.length) {
                    return null;
                }

                for (var i = 0; i < boardTypes.length; ++i) {
                    var board = boardTypes[i],
                        weight = this.dictionaries.cateringWeight[board]
                    ;

                    if (!weight) {
                        continue;
                    }

                    if (weight < lowestBoardWeigth) {
                        lowestBoard = board;
                        lowestBoardWeigth = weight;
                    }
                }
                return this.dictionaryTransformValue(this.dictionaries.catering, lowestBoard);
            },
            'hotel_category': function (form, formData) {
                return formData.category;
            },
            'destination': function (form, formData) {
                var dest = null;

                if (utag_data.destination_country_searched && this.getScope().IbeApi.state.stepNr == 4) {
                    dest = utag_data.destination_country_searched;

                    if (dest === 'Vereinigte Arabische Emirate') {
                        dest = decodeURIComponent(utag_data.destination_city_searched);
                    }

                    if(dest === 'Thailand') {
                        dest = decodeURIComponent(utag_data.search_destination);

                        if(dest == 'undefined') {
                            dest = 'Thailand';
                        }
                    }

                } else if (formData.destination) {
                    dest = formData.destination.name;
                }

                if (dest && dest.trim() == 'Portugal') {
                    return 'Algarve';
                }

                return dest;
            },
            'pax': function (form, formData) {
                var adults = 0;
                $.each(formData.travellers,function(key,value){
                    adults += parseInt(value.adults);
                });
                return adults;
            },
            'budget': function (form, formData) {
                return formData.maxPrice;
            },
            'children': function (form, formData) {
                var childs = 0;
                $.each(formData.travellers,function(key,value){
                    childs += parseInt(value.children.length);
                });
                childs = childs > 3 ? 3 : childs;
                return childs;
            },
            'age_1': function (form, formData) {
                var ages = [];
                $.each(angular.element('#ibeContainer').scope().filters.state.travellers,function(key,value){

                    $.each(value.children,function(key_,children){
                        ages.push(children);
                    });

                });
                return ages.length > 0 ? ages[0] : 0;
            },
            'age_2': function (form, formData) {
                var ages = [];
                $.each(angular.element('#ibeContainer').scope().filters.state.travellers,function(key,value){

                    $.each(value.children,function(key_,children){
                        ages.push(children);
                    });

                });
                return ages.length > 1 ? ages[1] : 0;
            },
            'age_3': function (form, formData) {
                var ages = [];
                $.each(angular.element('#ibeContainer').scope().filters.state.travellers,function(key,value){

                    $.each(value.children,function(key_,children){
                        ages.push(children);
                    });

                });
                return ages.length > 2 ? ages[2] : 0;
            },
            'earliest_start': function (form, formData) {
                return this.formatDate(formData.startDate);
            },
            'latest_return': function (form, formData) {
                return this.formatDate(formData.endDate);
            },
            'duration': function (form, formData) {
                if (formData.duration.trim() === 'default') {
                    return null;
                }

                return formData.duration;
            },
            'extra': function (form, formData) {
                return formData.environmentAttributes.concat(formData.familyAttributes).concat(formData.sportAttributes).join(',');
            },
            'room_type': function (form, formData) {
                return formData.roomTypes.join(',');
            },
            'cities': function (form, formData) {
                return formData.cities.join(',');
            },
            'airport': function (form, formData) {
                var self = this;
                return formData.departureAirports.map(function (airport) {
                    return self.getAirportName(airport);
                }).join(', ');
            },
            'is_popup_allowed': function (form, formData) {
                //var step = this.getScope().IbeApi.state.stepNr;
                return true;
            }
        },
        getCountryId: function () {
            var destination = this.getScope().filters.state.destination,
                countryId;

            if (!destination) {
                return null;
            }

            if (destination.regionId) {
                countryId = this.getCountryIdFromRegionId(destination.regionId);
            } else {
                countryId = destination.countryId || this.getScope().IbeApi.state.data.country.countryId;
            }

            return countryId;
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
            if (!this.scope) {
                this.scope = angular.element(this.filterFormSelector).scope();
            }

            return this.scope;
        },
        getAirportName: function (code) {
            if (!this.airports) {
                this.airports = {};

                var data = this.getScope().IbeApi.state.referenceData.airports.slice();

                data = data.concat([
                    {code: 'WEST', name: 'Deutschland West'},
                    {code: 'EAST', name: 'Deutschland Ost'},
                    {code: 'NORTH', name: 'Deutschland Nord'},
                    {code: 'SOUTH', name: 'Deutschland Süd'}
                ]);

                for (var i = 0; i < data.length; ++i) {
                    this.airports[data[i].code] = data[i].name;
                }
            }
            return this.airports[code];
        },
        getCountryIdFromRegionId: function (code) {
            if (!this.regions) {
                this.regions = {};

                var data = this.getScope().IbeApi.state.referenceData.destinations;

                for (var i = 0; i < data.length; ++i) {
                    this.regions[data[i].regionId || data[i].countryId] = data[i].countryId;
                }
            }

            return this.regions[code];
        },
        getTripData: function () {
            var form = $(this.filterFormSelector),
                formData = this.getScope().filters.state;

            return this.decodeFilterData(form, formData);
        },
        getRandomElement: function (arr) {
            return arr[Math.floor(Math.random() * arr.length)];
        },
        getVariant: function () {
            var regex = new RegExp("airtours.de");
            if(regex.test(String(window.location))) {
                return 'eil-at';
            }else if(isMobile()){
                return 'eil-mobile';
            }else{
                return this.getRandomElement([
                    'eil-n1',
                    'eil-n1',
                    'eil-n2',
                    'eil-n5'
                ]);
            }
        },
        getTrackingLabel: function (tripData, variant) {
            var destId = null,
                destName = tripData.destination;

            switch (destName) {
                case 'Kapverdische Inseln':
                case 'Kap Verde - Sal':
                case 'Kap Verde - Boavista':
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
                case 'New York (Manhattan)':
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
                var catering = getUrlParams('board') ? getUrlParams('board') : '';
                return catering;
            },
            'category': function (form, formData) {
                var category = getUrlParams('stars') ? getUrlParams('stars') : '3';

                return category;
            },
            'destination': function (form, formData) {
                var destination = getUrlParams('destination') ? getUrlParams('destination') : '';
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
                console.log('duration', duration);

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

                console.log('duration after', duration);

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


    var LastminuteTripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        name: 'Lastminute',
        matchesUrl: 'www.lastminute.ch/*',
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
                // var destination = getUrlParams('destination') ? getUrlParams('destination') : '';
                var destination = $('.tt-input').val();
                return destination;
            },
            'pax': function (form, formData) {
                var pax = getUrlParams('pax') ? getUrlParams('pax') : '';
                return pax;
            },
            /*'budget': function (form, formData) {
                var budget = getUrlParams('budget') ? getUrlParams('budget') : '';
                return budget;
            },*/
            'budget': function (form, formData) {
                var budget = '';
                if(getUrlParams('price')){
                    budget = getUrlParams('price').split(',')[1];
                }

                //var price = getUrlParams('price'). ? getUrlParams('price') : '';
                return budget;
            },
            'children': function (form, formData) {
                var kids = getUrlParams('child') ? getUrlParams('child') : '';
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
                var dateFrom = getUrlParams('ddate') ? getUrlParams('ddate') : '';
                return dateFrom;
            },
            'latest_return': function (form, formData) {
                var dateTo = getUrlParams('rdate') ? getUrlParams('rdate') : '';
                return dateTo;
            },
            'duration': function (form, formData) {
                var duration = getUrlParams('duration') ? getUrlParams('duration') : '';
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


    //dt.decoders.push(MasterIBETripDataDecoder);
    //dt.decoders.push(MasterIBETripDataDecoderMobile);
    dt.decoders.push(KwizzmeFakeTripDataDecoder);
    //dt.decoders.push(LastminuteTripDataDecoder);

    //dt.decoders.push($.extend({}, MasterIBETripDataDecoder, {
    //    name: 'TUI Landingpages',
    //    matchesUrl: 'lastminute.com/pauschalreisen',
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

        if(isMobile()){
            var formSent = $('.kwp-content').hasClass('kwp-completed-master');

            this.modal.addClass('tmp-hidden');
            if(!formSent) {
                this.trigger =
                    $('<span/>', {'class': 'trigger-modal'});
                $('body').prepend(this.trigger.fadeIn());
            }
        }else{
            this.modal.css('display', 'none');
        }

        this.shown = false;
        $("body").removeClass('mobile-layer');
        $("body, html").css({'overflow':'auto'});

        dt.Tracking.event('close', this.trackingLabel);

    };


    dt.scrollUpDetect = function () {
        var shown = false;
        $('body').swipe( { swipeStatus:function(event, phase, direction, distance){
            if(direction === 'down' && parseInt(distance) > 50 && !shown){
                dt.showMobileLayer();
                shown = true;
            }else if (direction === 'down' || direction === 'up' && shown && ($("body .hl-sticky").hasClass('is-sticky'))) {
                $(".dt-modal").css({'top': (document.documentElement.clientHeight - 85) + "px"});
            } else if(direction === 'down' || direction === 'up' && shown) {
                $(".dt-modal").css({'top': (document.documentElement.clientHeight - 100) + "px"});
            }
        }, allowPageScroll:"vertical"} );


        $( ".dt-modal" ).swipe( {
            tap:function(e, target) {
                $(this).addClass('m-open');
                $("body, html").css({'overflow':'hidden'});
                ga('dt.send', 'event', 'Mobile Layer', 'Layer shown', 'Tablet');
            },
            swipe:function(e, direction, distance, duration, fingerCount, fingerData) {
                var $event = e;
                if(direction === "left"){
                    if($(this).hasClass('m-open'))
                        return false;
                    $(this).addClass('swipe-left');
                    setTimeout(function(e) {
                        dt.PopupManager.closePopup($event);
                    },1000);
                    return false;
                }else if(direction === "right"){
                    if($(this).hasClass('m-open'))
                        return false;
                    $(this).addClass('swipe-right');
                    setTimeout(function(e) {
                        dt.PopupManager.closePopup($event);
                    },1000);
                    return false;
                }
            },
        });


    };

    dt.triggerButton = function(e){
        e && e.preventDefault();
        $("body").on('click tap','.trigger-modal',function () {
            $("body").addClass('mobile-layer');
            $("body, html").css({'overflow':'hidden'});
            dt.PopupManager.shown = true;
            dt.PopupManager.modal.removeClass('tmp-hidden').removeClass('swipe-right').removeClass('swipe-left');
            $(this).remove();
            ga('dt.send', 'event', 'Mobile Layer', 'Trigger button tap', 'Tablet');
        });

        $( ".kwp-header" ).swipe( {
            tap:function(e, target) {
                var $event = e;
                if($( ".dt-modal" ).hasClass('m-open')){
                    dt.PopupManager.closePopup($event);
                }
            }
        });
    }

    dt.showMobileLayer = function (e) {
        dt.PopupManager.show();
        $("body").addClass('mobile-layer');
        //$.cookie(dt.PopupManager.mobileCookieId,'true',dt.PopupManager.cookieOptions);
        ga('dt.send', 'event', 'Mobile Layer', 'Teaser shown', 'Tablet');
    };

    $(document).ready(function (e) {
        if(isMobile()) {
            dt.defaultConfig.cssPath = dt.defaultConfig.cssPath.replace('popup.css', 'popup_mobile.css');
        }
        dt.PopupManager.init();
        dt.Tracking.init('lastminute_exitwindow','UA-105970361-1');

        if(isMobile() && dt.PopupManager.decoder){
            dt.scrollUpDetect();
            dt.PopupManager.isMobile = true;
            $(".dt-modal").css({'top':(document.documentElement.clientHeight - 100)+"px"});
            textareaAutosize();
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


        var data_agb = '<section id="c45306" class="csc-default csc-content-text"> <header> <h2 class="csc-header">Bedingungen für die Nutzung des TUI Reisewunschportals</h2></header> <h3>1. Funktion des TUI Reisewunschportals, Nutzungsbedingungen</h3> <p><b>1.1.</b> Die TUI Deutschland GmbH (im Folgenden „TUI“) bietet über das Online-Tool „TUI Reisewunschportal“ (im Folgenden „System") unentgeltlich die technische Möglichkeit, Suchanzeigen nach Reiseangeboten („Reisewünsche“) aufzugeben und so persönlichen Kontakt zu Reiseberatern in teilnehmenden Reisebüros (Filialen und Partneragenturen [andere Legal Entity] der TUI Deutschland GmbH) zum Zwecke einer individuellen Kommunikation herzustellen. </p><p><b>1.2</b>. Für die Nutzung des Systems gelten diese Nutzungsbedingungen, die nach Maßgabe von Ziff. 9.1 geändert werden können. </p><h3>2. Anmeldung</h3> <p><b>2.1. </b> Das System ist über ein entsprechendes Dialogfeld auf der Website www.TUI.com sowie über www.TUI-reisewunsch.com zu erreichen. Die Nutzung des Systems setzt die Anmeldung als Nutzer voraus. </p><p><b>2.2. </b> Die Anmeldung ist nur volljährigen und unbeschränkt geschäftsfähigen Personen gestattet.</p><p><b>2.3. &nbsp;&nbsp;</b>Die Anmeldung erfolgt durch Einsendung der E-Mailadresse sowie des Reisewunsches und ggf. weiterer Suchkriterien (alles zusammenfassend: „Nutzerdaten“) sowie Akzeptanz dieser Nutzungsbedingungen über das Dialogfeld. Sie wird durch Zusendung einer Bestätigungsmail mit einem individuellen Zugangslink durch TUI Deutschland an die angegebene E-Mail-Adresse abgeschlossen. Es besteht kein Anspruch des Nutzers auf Einstellen von Inhalten.</p><p><b>2.4</b>. Über den Zugangslink kann der Nutzer seine Anfrage, einschließlich der Nutzerdaten, im System jederzeit einsehen, anpassen oder durch Betätigung einer entsprechenden Schaltfläche deaktivieren. Passt der Nutzer den Reisewunsch an oder deaktiviert ihn, verschickt das System eine entsprechende Info-Mail an ihn.</p><p><b>2.6</b>. TUI Deutschland überprüft grundsätzlich nicht die Richtigkeit der Nutzerdaten</p><p><b>2.7.</b> TUI behält sich das Recht vor, nach alleinigem Ermessen und ohne Ankündigung den Zugang von Nutzern zum System oder dessen Teilen zu verweigern und/oder den Betrieb des Systems einzustellen.</p><h3>&nbsp;</h3> <h3>3. Reisewünsche, Bearbeitung</h3> <p><b>3.1.</b> Ein Reisewunsch stellt grundsätzlich nur eine unverbindliche Anfrage und kein rechtlich bindendes Angebot dar. </p><p><b>3.2. </b> Die in das System eingegebenen Reisewünsche der Nutzer werden durch das System an ein teilnehmendes, mit TUI Deutschland kooperierendes Reisebüro weitergeleitet, das sich vorher im TUI Reisewunschportal registriert hat und nach eigener Angabe über besondere Kompetenz für das betreffende Zielgebiet verfügt. Die Verteilung erfolgt automatisiert nach den Kriterien: 1. Standort des Nutzers, 2. Expertise eines Reisebüros für das jeweilige Zielgebiet.</p><p><b>3.3.</b> Die Reisewünsche werden nicht veröffentlicht.</p><p><b>3.4.</b> Reisebüros können auf einen Reisewunsch mit einem Angebotsvorschlag gegenüber dem Nutzer reagieren. Auch dieser Vorschlag ist grundsätzlich rechtlich unverbindlich, soweit darin nichts anderes bestimmt ist </p><p><b>3.5.</b> Nachdem ein Reisebüro eine Anfrage bearbeitet und das Ergebnis (Nachfrage bzw. Angebot) in das System eingestellt hat, bekommt der Nutzer eine E-Mail, in der erneut ein Link zu der Anfrage und dem Feedback/ Angebot enthalten ist </p><p><b>3.6.</b> Der Nutzer, welcher den Reisewunsch eingestellt hat, kann auf den Vorschlag hin das Reisebüro kontaktieren. Er ist jedoch nicht verpflichtet, auf einen Vorschlag zu reagieren.</p><p><b>3.7.</b> Der Nutzer kann wählen, über welchen Weg (E-Mail, Telefon, persönlich vor Ort) er weiter mit dem Reisebüro kommunizieren möchte. Solange der Nutzer dem Reisebüro keine Kontaktdaten für einen Direktkontakt mitteilt, erfolgt die beschriebene Kommunikation zwischen Nutzer und Reisebüro ausschließlich über das System als Absender von Nachrichten in beide Richtungen. </p><h3>&nbsp;</h3> <h3>4. Rechtbeziehungen</h3> <p><b>4.1.</b> Die Leistung von TUI Deutschland im Rahmen des Systems ist allein die Übermittlung der Nachrichten zwischen den Nutzern und den Reisebüros. Für die Systembereitstellung können Erfüllungsgehilfen eingesetzt werden. </p><p><b>4.2.</b> Sofern infolge der Nutzung des Systems ein Kontakt zwischen dem Nutzer und einem Reisebüro zustande kommt, bestehen etwaige daraus resultierende Rechtsbeziehungen ausschließlich zwischen diesen Parteien. TUI Deutschland ist hieran nicht beteiligt. Daher ist TUI Deutschland auch nicht für die Erfüllung von Verträgen, die zwischen den Nutzern und den Reisebüros und/oder von diesen vermittelten Leistungsträgern geschlossen wurden, verantwortlich. </p><h3>&nbsp;</h3> <h3>5. Pflichten des Nutzers, Verantwortung für Inhalte</h3> <p><b>5.1.</b> Der Nutzer ist verpflichtet, den Zugangslink geheim zu halten.</p><p><b>5.2.</b> Der Nutzer ist grundsätzlich für alle über seinen Zugangslink vorgenommenen Aktivitäten verantwortlich. Die Regelungen dieses Absatzes gelten nicht, wenn der Nutzer einen etwaigen Missbrauch seines Zugangslinks nicht zu vertreten hat, weil keine Sorgfaltspflichtverletzung des Nutzers vorliegt. Der Nutzer ist verpflichtet, TUI Deutschland umgehend zu informieren, wenn er Anhaltspunkte für einen Missbrauch seines Zugangslinks durch Dritte hat.</p><p><b>5.3.</b> Der Nutzer ist verpflichtet, bei Einstellung von Reisewünschen und sonstigen Inhalten sämtliche geltenden Rechtsvorschriften, Rechte Dritter und diese Nutzungsbedingungen zu beachten. Er ist für die Rechtmäßigkeit, Richtigkeit und Vollständigkeit aller von ihm eingestellten Inhalte verantwortlich und haftet für die Verletzung von Rechtsvorschriften oder von Rechten Dritter durch von ihm eingestellte Inhalte</p><p><b>5.4.</b> TUI Deutschland überprüft die in das System eingestellten Inhalte der Nutzer grundsätzlich nicht und übernimmt für diese keinerlei Haftung. TUI Deutschland behält sich aber das Recht vor, die Inhalte zu überprüfen, auch wenn dafür eine gesetzliche Verpflichtung nicht besteht.</p><p><b>5.5. </b>Der Nutzer erhält etwaige Informationen über die von ihm im System hinterlegte E-Mail-Adresse. Es obliegt ihm, sicherzustellen, dass er unter dieser E-Mail-Adresse erreichbar ist.</p><h3>&nbsp;</h3> <h3>6. Unzulässige Nutzungshandlungen, Maßnahmen bei Verstößen, Freistellung</h3> <p><b>6.1. </b>Die folgenden Nutzungshandlungen sind unzulässig:</p><ul> <li>&nbsp;das Einstellen von anderen Inhalten als Reisewünschen</li></ul> <ul> <li>das Einstellen von unzulässigen Inhalten; unzulässig sind Inhalte, die gegen diese Nutzungsbedingungen oder gegen gesetzliche Verbote oder die guten Sitten verstoßen (z.B. pornografische, volksverhetzende, rassistische oder verfassungswidrige Inhalte, Gewaltdarstellungen, Drohungen, Nötigungen, Ehrverletzungen oder sonst verwerfliche Inhalte) oder Rechte Dritter (insbesondere Persönlichkeits-, Namensrechte oder Rechte zum Schutze geistigen Eigentums wie z.B. Marken- oder Urheberrechte) verletzen; </li></ul> <ul> <li>die Offenlegung und Weitergabe des Zugangslinks zum System;</li></ul> <ul> <li>das automatische Auslesen der auf dem System befindlichen Daten sowie der Aufbau eigener Suchsysteme, Dienste und Verzeichnisse unter Zuhilfenahme der im System abrufbaren Inhalte sowie das vielfache Erstellen inhaltsgleicher Inhalte; </li></ul> <ul> <li>die Verwendung oder das Aufspielen von Dateien, die Viren, beschädigte Dateien, Software oder sonstige Mechanismen oder Inhalte enthalten, welche das System oder dessen Nutzer, deren Rechner, die Server von TUI Deutschland oder die auf den Rechnern der Nutzer oder von TUI Deutschland verwendete Software ausspionieren, attackieren oder in sonstiger Weise beeinträchtigen könnten. </li></ul> <p><b>6.2.</b> TUI Deutschland kann folgende Maßnahmen ergreifen, wenn konkrete Anhaltspunkte dafür bestehen, dass ein Nutzer gesetzliche Vorschriften, Rechte Dritter, diese Bedingungen verletzt, oder wenn TUI Deutschland ein sonstiges berechtigtes Interesse hat: Löschen von Reisewünschen oder sonstigen Inhalten, Verwarnung des Nutzers, Beschränkung der Nutzungsmöglichkeit des Systems durch den Nutzer, so dass u.a. keine Inhalte mehr eingestellt werden können, Löschung des Nutzerkontos.</p><p><b>6.3.</b> Der Nutzer stellt TUI Deutschland von allen Ansprüchen frei, die von Dritten gegen TUI Deutschland aufgrund einer Verletzung ihrer Rechte geltend gemacht werden, soweit der Nutzer diese Rechtsverletzung zu vertreten hat. Die Freistellung umfasst die Übernahme sämtlicher Gerichtskosten und angemessener Anwaltskosten.</p><p><b>6.4.</b> Der Nutzer wird TUI Deutschland bei der Verteidigung gegen die Inanspruchnahme unterstützen und insbesondere unverzüglich alle Informationen zur Verfügung stellen, die für die Prüfung und Abwehr der Ansprüche von Bedeutung sein können</p><p><b>6.5. </b>TUI Deutschland ist im Fall der berechtigten Geltendmachung von Rechten durch einen Dritten berechtigt, dem Dritten den Namen und die E-Mail-Adresse des Nutzers mitzuteilen</p><p><b>6.6. </b>TUI Deutschland ist zur Geltendmachung weiterer gesetzlicher Rechte im Fall von unzulässigen Nutzungshandlungen berechtigt. </p><h3>&nbsp;</h3> <h3>7. Haftungsbeschränkung</h3> <p><b>7.1.</b> TUI Deutschland übernimmt keine Garantie oder Gewähr für die Verfügbarkeit und Funktion des Systems oder der eingestellten Inhalte. TUI Deutschland behält sich vor, das TUI Reisewunschportal (auch ohne vorherige Ankündigung) ganz oder teilweise einzustellen oder den Zugang hierzu ganz oder teilweise einzuschränken, ohne dass hieraus Ansprüche der Nutzer gegenüber TUI Deutschland entstehen. </p><p><b>7.2.</b> . Für eine Haftung von TUI Deutschland auf Schadensersatz gelten unbeschadet der sonstigen gesetzlichen Anspruchsvoraussetzungen folgende Haftungsausschlüsse und Haftungsbegrenzungen: </p><p><b>7.2.1.</b> TUI Deutschland haftet unbeschränkt, soweit die Schadensursache auf Vorsatz oder grober Fahrlässigkeit beruht. Ferner haftet TUI für die leicht fahrlässige Verletzung von wesentlichen Pflichten, deren Verletzung die Erreichung des Vertragszwecks gefährdet, und für die Verletzung von Pflichten auf deren Einhaltung Vertragspartner regelmäßig vertrauen. In diesem Fall haftet TUI jedoch nur für den vorhersehbaren, vertragstypischen Schaden. TUI Deutschland haftet nicht für die leicht fahrlässige Verletzung anderer als der in den vorstehenden Sätzen genannten Pflichten. </p><p><b>7.2.2.</b> Die vorstehenden Haftungsbeschränkungen gelten nicht bei Verletzung von Leben, Körper und Gesundheit, für einen Mangel nach Übernahme von Beschaffenheitsgarantien für die Beschaffenheit eines Produktes und bei arglistig verschwiegenen Mängeln. Die Haftung nach dem Produkthaftungsgesetz bleibt unberührt. Soweit die Haftung von TUI Deutschland ausgeschlossen oder beschränkt ist, gilt dies auch für die persönliche Haftung ihrer Arbeitnehmer, Vertreter und Erfüllungsgehilfen.</p><h3>&nbsp;</h3> <h3> 8. Nutzung Ihrer Daten innerhalb des Reisewunschportals</h3> <p>Für die TUI ist der Schutz Ihrer Privatsphäre und persönlicher Daten von großer Wichtigkeit. Personenbezogene Daten werden im TUI Reisewunschportal nur dann erhoben, verarbeitet und genutzt, sofern dies gesetzlich erlaubt ist oder Sie uns hierzu Ihre Einwilligung erteilt haben. Die Einwilligung erfolgt durch die Bestätigung der Teilnahmebedingungen und dem Klick auf das Feld „Reisewunsch abschicken“. Die nachfolgenden Punkte geben Ihnen einen Überblick darüber, anwelchen Stellen und zu welchem Zweck die TUI die Daten der Interessenten erhebt, verarbeitet und nutzt.</p><p><b>8.1.</b> Informationen zur Datenverarbeitung und zum Datenschutz ergeben sich aus unserer Datenschutzerklärung. Diese finden Sie hier: <a target="_blank" href="https://www.lastminute.com/datenschutz/" target="_top"><span style="font-family:&quot;TUIType&quot;,&quot;sans-serif&quot;">http://www.TUI.com/datenschutz/</span></a><span style="font-family:&quot;TUIType&quot;,&quot;sans-serif&quot;">. </span></p><p><b>8.2.</b> Einsatz von Cookies im Reisewunschportal: Tealium IQ ist ein Tag Management System mit dem Messpixel („Tags“) von Drittanbietern auf den Seiten der TUI Deutschland geladen werden. Beispiele für Drittanbieter sind Google Analytics und DesireTec Conversion Intelligence. Zur Optimierung des Ladens der Messpixel erfasst Tealium über ein Cookie einige personenbezogene (E-Mail-Adresse und IP Adresse) und nicht personenbezogene Daten (Reisewunschdaten). Dieses Cookie verliert nach 12 Monaten seine Gültigkeit.</span></a> </p><p>Die folgenden Informationen werden im Tealium Cookie gespeichert:</p><ul> <li>Zeitstempel des Webseitenbesuchs</li><li>ID für den Seitenaufruf</li><li>ID für den Besucher</li><li>ID für die Reisewunsch Session</li><li>IP Adresse zur regionalen Zusteuerung zum Reisebüro</li><li>Flag (0 oder 1) zur Kennzeichnung des Sessionstarts</li></ul> <p>Wenn Sie sie sich von Tealium und den Messungen der nachfolgenden Drittanbieter ausschließen wollen klicken Sie auf den Link. (<a href="http://www.TUI.com/datenschutz/tracking-einstellungen">http://www.TUI.com/datenschutz/tracking-einstellungen</a>)</p><p><b>8.3.</b> Einsatz von Mauszeiger-Tracking der Firma DesireTec (DesireTec Conversion Intelligence)</p><p>DesireTec Conversion Intelligence ist ein Tracking System, das die Bewegung der Maus (Richtung, Geschwindigkeit, Beschleunigung) misst, um bei der Erfüllung festgelegter Kriterien ein Formular auszuspielen, dass Sie bei Ihrer Suche nach einer Reise unterstützen soll. Über das Tracking findet keine Speicherung personenbezogener Daten statt und es ist keine Wiedererkennung möglich.</p><p>Sollte das Formular ausgespielt werden, wird ein Cookie gespeichert, um ein mehrfaches Auslösen zu verhindern. Dieses speichert ausschließlich die Information, dass das Formular bereits ausgespielt wurde.</p><p><b>8.4.</b> Sofern keine gesetzlichen Speicherpflichten bestehen, können Sie zu jederzeit eine Löschung der von Ihnen zur Verfügung gestellten personenbezogenen Daten durch uns vornehmen lassen. Für Fragen, Wünsche oder Kommentare zum Thema Datenschutz wenden Sie sich bitte per E-Mail an den Datenschutzbeauftragten der TUI Deutschland GmbH: datenschutz@lastminute.de.</p><h3>&nbsp;</h3> <h3>9. Schlussbestimmungen</h3> <p><b>9.1.</b> TUI Deutschland ist berechtigt, Änderungen oder Ergänzungen an diesen Nutzungsbedingungen vorzunehmen, sofern dies dem billigen Ermessen von TUI Deutschland entspricht und für den Nutzer zumutbar ist. Diese werden erst wirksam, nachdem TUI Deutschland dem registrierten Nutzer die Änderung der Nutzungsbedingungen in Textform mitgeteilt hat und der Nutzer dieser Neufassung nicht innerhalb von 6 Wochen ab Zugang mindestens in Textform widerspricht. Der Nutzer wird bei Mitteilung der Änderung auf die Bedeutung seines Schweigens besonders hingewiesen. </p><p><b>9.2.</b> Sofern einzelne oder mehrere Bestimmungen in diesen Nutzungsbedingungen ganz oder teilweise unwirksam oder ungültig sind oder werden, bleibt die Wirksamkeit der übrigen Regelungen und Bestimmungen hiervon unberührt. Die unwirksame oder ungültige Regelung gilt durch eine Regelung ersetzt, die dem Sinn und Zweck der unwirksamen oder ungültigen Regelung in rechtwirksamer Weise wirtschaftlich am nächsten kommt. Gleiches gilt für eventuelle Regelungslücken. </p><p><b>9.3.</b> Streitigkeiten, die im Zusammenhang mit diesen Nutzungsbedingungen oder aufgrund der Nutzung des TUI Reisewunschportals geführt werden unterliegen ausschließlich dem Recht der Bundesrepublik Deutschland. </p><p> <br/> <br/>Mai 2018</p></section><style type="text/css"> .csc-frame-tx-xsocial{display: none;}</style>';

        function show() {
            if (element) {
                hide();
            }

            element = $('<div class="dt-modal dt-modal-agb" ><div class="kwp"><div class="kwp-close-button kwp-close"></div><div class="kwp-agb-content"></div></div></div>');



            /*$.ajax({
                url: 'http://lastminute-reisewunsch.com/bundles/cslastminute/popup/static/agb.html',
                type: 'GET',
                crossDomain: true,
                dataType: 'jsonp',
                success: function(data) { element.find('.kwp-agb-content').append(data); },
                error: function() {  },
            });			*/

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
})(jQuery);
