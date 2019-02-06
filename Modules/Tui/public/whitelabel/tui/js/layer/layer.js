(function ($) {
    'use strict';

    var timer;

    function trackLeave(ev) {
        if (ev.clientY > 0) {
            return;
        }

        if (timer) {
            clearTimeout(timer);
        }

        if ($.exitIntent.settings.sensitivity <= 0) {
            $.event.trigger('exitintent');
            return;
        }

        timer = setTimeout(
            function() {
                timer = null;
                $.event.trigger('exitintent');
            }, $.exitIntent.settings.sensitivity);
    }

    function trackEnter() {
        if (timer) {
            clearTimeout(timer);
            timer = null;
        }
    }

    $.exitIntent = function(enable, options) {
        $.exitIntent.settings = $.extend($.exitIntent.settings, options);

        if (enable == 'enable') {
            $(window).mouseleave(trackLeave);
            $(window).mouseenter(trackEnter);
        } else if (enable == 'disable') {
            trackEnter(); // Turn off any outstanding timer
            $(window).unbind('mouseleave', trackLeave);
            $(window).unbind('mouseenter', trackEnter);
        } else {
            throw "Invalid parameter to jQuery.exitIntent -- should be 'enable'/'disable'";
        }
    }

    $.exitIntent.settings = {
        'sensitivity': 300
    };

})(jQuery);
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
        isFromPaidTraffic: function() {
            return Cookies.get('utag.data.exclude_lead') == 1;
        },
        init: function() {
            this.initExitIntent();
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
                    withCredentials: true
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
                    withCredentials: true
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


/*! =========================================================
 * bootstrap-slider.js
 *
 * Maintainers:
 *		Kyle Kemp
 *			- Twitter: @seiyria
 *			- Github:  seiyria
 *		Rohit Kalkur
 *			- Twitter: @Rovolutionary
 *			- Github:  rovolution
 *
 * =========================================================
 *
 * bootstrap-slider is released under the MIT License
 * Copyright (c) 2019 Kyle Kemp, Rohit Kalkur, and contributors
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 *
 * ========================================================= */


/**
 * Bridget makes jQuery widgets
 * v1.0.1
 * MIT license
 */
const windowIsDefined = (typeof window === "object");


(function(factory) {
	if(typeof define === "function" && define.amd) {
		define(["jquery"], factory);
	}
	else if(typeof module === "object" && module.exports) {
		var jQuery;
		try {
			jQuery = require("jquery");
		}
		catch (err) {
			jQuery = null;
		}
		module.exports = factory(jQuery);
	}
	else if(window) {
		window.Slider = factory(window.jQuery);
	}
}(function($) {
	// Constants
	const NAMESPACE_MAIN = 'slider';
	const NAMESPACE_ALTERNATE = 'bootstrapSlider';

	// Polyfill console methods
	if (windowIsDefined && !window.console) {
		window.console = {};
	}
	if (windowIsDefined && !window.console.log) {
		window.console.log = function () { };
	}
	if (windowIsDefined && !window.console.warn) {
		window.console.warn = function () { };
	}

	// Reference to Slider constructor
	var Slider;


	(function( $ ) {

		'use strict';

		// -------------------------- utils -------------------------- //

		var slice = Array.prototype.slice;

		function noop() {}

		// -------------------------- definition -------------------------- //

		function defineBridget( $ ) {

			// bail if no jQuery
			if ( !$ ) {
				return;
			}

			// -------------------------- addOptionMethod -------------------------- //

			/**
			 * adds option method -> $().plugin('option', {...})
			 * @param {Function} PluginClass - constructor class
			 */
			function addOptionMethod( PluginClass ) {
				// don't overwrite original option method
				if ( PluginClass.prototype.option ) {
					return;
				}

			  // option setter
			  PluginClass.prototype.option = function( opts ) {
			    // bail out if not an object
			    if ( !$.isPlainObject( opts ) ){
			      return;
			    }
			    this.options = $.extend( true, this.options, opts );
			  };
			}


			// -------------------------- plugin bridge -------------------------- //

			// helper function for logging errors
			// $.error breaks jQuery chaining
			var logError = typeof console === 'undefined' ? noop :
			  function( message ) {
			    console.error( message );
			  };

			/**
			 * jQuery plugin bridge, access methods like $elem.plugin('method')
			 * @param {String} namespace - plugin name
			 * @param {Function} PluginClass - constructor class
			 */
			function bridge( namespace, PluginClass ) {
			  // add to jQuery fn namespace
			  $.fn[ namespace ] = function( options ) {
			    if ( typeof options === 'string' ) {
			      // call plugin method when first argument is a string
			      // get arguments for method
			      var args = slice.call( arguments, 1 );

			      for ( var i=0, len = this.length; i < len; i++ ) {
			        var elem = this[i];
			        var instance = $.data( elem, namespace );
			        if ( !instance ) {
			          logError( "cannot call methods on " + namespace + " prior to initialization; " +
			            "attempted to call '" + options + "'" );
			          continue;
			        }
			        if ( !$.isFunction( instance[options] ) || options.charAt(0) === '_' ) {
			          logError( "no such method '" + options + "' for " + namespace + " instance" );
			          continue;
			        }

			        // trigger method with arguments
			        var returnValue = instance[ options ].apply( instance, args);

			        // break look and return first value if provided
			        if ( returnValue !== undefined && returnValue !== instance) {
			          return returnValue;
			        }
			      }
			      // return this if no return value
			      return this;
			    } else {
			      var objects = this.map( function() {
			        var instance = $.data( this, namespace );
			        if ( instance ) {
			          // apply options & init
			          instance.option( options );
			          instance._init();
			        } else {
			          // initialize new instance
			          instance = new PluginClass( this, options );
			          $.data( this, namespace, instance );
			        }
			        return $(this);
			      });

			      if(!objects || objects.length > 1) {
			      	return objects;
			      } else {
			      	return objects[0];
			      }
			    }
			  };

			}

			// -------------------------- bridget -------------------------- //

			/**
			 * converts a Prototypical class into a proper jQuery plugin
			 *   the class must have a ._init method
			 * @param {String} namespace - plugin name, used in $().pluginName
			 * @param {Function} PluginClass - constructor class
			 */
			$.bridget = function( namespace, PluginClass ) {
			  addOptionMethod( PluginClass );
			  bridge( namespace, PluginClass );
			};

			return $.bridget;

		}

	  	// get jquery from browser global
	  	defineBridget( $ );

	})( $ );


	/*************************************************

			BOOTSTRAP-SLIDER SOURCE CODE

	**************************************************/

	(function($) {
		let autoRegisterNamespace;

		var ErrorMsgs = {
			formatInvalidInputErrorMsg : function(input) {
				return "Invalid input value '" + input + "' passed in";
			},
			callingContextNotSliderInstance : "Calling context element does not have instance of Slider bound to it. Check your code to make sure the JQuery object returned from the call to the slider() initializer is calling the method"
		};

		var SliderScale = {
			linear: {
				getValue: function(value, options) {
					if (value < options.min) {
						return options.min;
					} else if (value > options.max) {
						return options.max;
					} else {
						return value;
					}
				},
				toValue: function(percentage) {
					var rawValue = percentage/100 * (this.options.max - this.options.min);
					var shouldAdjustWithBase = true;
					if (this.options.ticks_positions.length > 0) {
						var minv, maxv, minp, maxp = 0;
						for (var i = 1; i < this.options.ticks_positions.length; i++) {
							if (percentage <= this.options.ticks_positions[i]) {
								minv = this.options.ticks[i-1];
								minp = this.options.ticks_positions[i-1];
								maxv = this.options.ticks[i];
								maxp = this.options.ticks_positions[i];

								break;
							}
						}
						var partialPercentage = (percentage - minp) / (maxp - minp);
						rawValue = minv + partialPercentage * (maxv - minv);
						shouldAdjustWithBase = false;
					}

					var adjustment = shouldAdjustWithBase ? this.options.min : 0;
					var value = adjustment + Math.round(rawValue / this.options.step) * this.options.step;
					return SliderScale.linear.getValue(value, this.options);
				},
				toPercentage: function(value) {
					if (this.options.max === this.options.min) {
						return 0;
					}

					if (this.options.ticks_positions.length > 0) {
						var minv, maxv, minp, maxp = 0;
						for (var i = 0; i < this.options.ticks.length; i++) {
							if (value  <= this.options.ticks[i]) {
								minv = (i > 0) ? this.options.ticks[i-1] : 0;
								minp = (i > 0) ? this.options.ticks_positions[i-1] : 0;
								maxv = this.options.ticks[i];
								maxp = this.options.ticks_positions[i];

								break;
							}
						}
						if (i > 0) {
							var partialPercentage = (value - minv) / (maxv - minv);
							return minp + partialPercentage * (maxp - minp);
						}
					}

					return 100 * (value - this.options.min) / (this.options.max - this.options.min);
				}
			},

			logarithmic: {
				/* Based on http://stackoverflow.com/questions/846221/logarithmic-slider */
				toValue: function(percentage) {
					var offset = 1 - this.options.min;
					var min = Math.log(this.options.min + offset);
					var max = Math.log(this.options.max + offset);
					var value = Math.exp(min + (max - min) * percentage / 100) - offset;
					if(Math.round(value) === max) {
						return max;
					}
					value = this.options.min + Math.round((value - this.options.min) / this.options.step) * this.options.step;
					/* Rounding to the nearest step could exceed the min or
					 * max, so clip to those values. */
					return SliderScale.linear.getValue(value, this.options);
				},
				toPercentage: function(value) {
					if (this.options.max === this.options.min) {
						return 0;
					} else {
						var offset = 1 - this.options.min;
						var max = Math.log(this.options.max + offset);
						var min = Math.log(this.options.min + offset);
						var v = Math.log(value + offset);
						return 100 * (v - min) / (max - min);
					}
				}
			}
		};


		/*************************************************

							CONSTRUCTOR

		**************************************************/
		Slider = function(element, options) {
			createNewSlider.call(this, element, options);
			return this;
		};

		function createNewSlider(element, options) {

			/*
				The internal state object is used to store data about the current 'state' of slider.
				This includes values such as the `value`, `enabled`, etc...
			*/
			this._state = {
				value: null,
				enabled: null,
				offset: null,
				size: null,
				percentage: null,
				inDrag: false,
				over: false,
				tickIndex: null
			};

			// The objects used to store the reference to the tick methods if ticks_tooltip is on
			this.ticksCallbackMap = {};
			this.handleCallbackMap = {};

			if(typeof element === "string") {
				this.element = document.querySelector(element);
			} else if(element instanceof HTMLElement) {
				this.element = element;
			}

			/*************************************************

							Process Options

			**************************************************/
			options = options ? options : {};
			var optionTypes = Object.keys(this.defaultOptions);

			const isMinSet = options.hasOwnProperty('min');
			const isMaxSet = options.hasOwnProperty('max');

			for(var i = 0; i < optionTypes.length; i++) {
				var optName = optionTypes[i];

				// First check if an option was passed in via the constructor
				var val = options[optName];
				// If no data attrib, then check data atrributes
				val = (typeof val !== 'undefined') ? val : getDataAttrib(this.element, optName);
				// Finally, if nothing was specified, use the defaults
				val = (val !== null) ? val : this.defaultOptions[optName];

				// Set all options on the instance of the Slider
				if(!this.options) {
					this.options = {};
				}
				this.options[optName] = val;
			}

			this.ticksAreValid = Array.isArray(this.options.ticks) && this.options.ticks.length > 0;

			// Lock to ticks only when ticks[] is defined and set
			if (!this.ticksAreValid) {
				this.options.lock_to_ticks = false;
			}

			// Check options.rtl
			if(this.options.rtl==='auto'){
				var computedStyle = window.getComputedStyle(this.element);
				if (computedStyle != null) {
					this.options.rtl = computedStyle.direction === 'rtl';
				} else {
					// Fix for Firefox bug in versions less than 62:
					// https://bugzilla.mozilla.org/show_bug.cgi?id=548397
					// https://bugzilla.mozilla.org/show_bug.cgi?id=1467722
					this.options.rtl = this.element.style.direction === 'rtl';
				}
			}

			/*
				Validate `tooltip_position` against 'orientation`
				- if `tooltip_position` is incompatible with orientation, swith it to a default compatible with specified `orientation`
					-- default for "vertical" -> "right", "left" if rtl
					-- default for "horizontal" -> "top"
			*/
			if(this.options.orientation === "vertical" && (this.options.tooltip_position === "top" || this.options.tooltip_position === "bottom")) {
				if(this.options.rtl) {
					this.options.tooltip_position = "left";
				}else{
					this.options.tooltip_position = "right";
				}
			}
			else if(this.options.orientation === "horizontal" && (this.options.tooltip_position === "left" || this.options.tooltip_position === "right")) {

				this.options.tooltip_position	= "top";

			}

			function getDataAttrib(element, optName) {
				var dataName = "data-slider-" + optName.replace(/_/g, '-');
				var dataValString = element.getAttribute(dataName);

				try {
					return JSON.parse(dataValString);
				}
				catch(err) {
					return dataValString;
				}
			}

			/*************************************************

							Create Markup

			**************************************************/

			var origWidth = this.element.style.width;
			var updateSlider = false;
			var parent = this.element.parentNode;
			var sliderTrackSelection;
			var sliderTrackLow, sliderTrackHigh;
			var sliderMinHandle;
			var sliderMaxHandle;

			if (this.sliderElem) {
				updateSlider = true;
			} else {
				/* Create elements needed for slider */
				this.sliderElem = document.createElement("div");
				this.sliderElem.className = "slider";

				/* Create slider track elements */
				var sliderTrack = document.createElement("div");
				sliderTrack.className = "slider-track";

				sliderTrackLow = document.createElement("div");
				sliderTrackLow.className = "slider-track-low";

				sliderTrackSelection = document.createElement("div");
				sliderTrackSelection.className = "slider-selection";

				sliderTrackHigh = document.createElement("div");
				sliderTrackHigh.className = "slider-track-high";

				sliderMinHandle = document.createElement("div");
				sliderMinHandle.className = "slider-handle min-slider-handle";
				sliderMinHandle.setAttribute('role', 'slider');
				sliderMinHandle.setAttribute('aria-valuemin', this.options.min);
				sliderMinHandle.setAttribute('aria-valuemax', this.options.max);

				sliderMaxHandle = document.createElement("div");
				sliderMaxHandle.className = "slider-handle max-slider-handle";
				sliderMaxHandle.setAttribute('role', 'slider');
				sliderMaxHandle.setAttribute('aria-valuemin', this.options.min);
				sliderMaxHandle.setAttribute('aria-valuemax', this.options.max);

				sliderTrack.appendChild(sliderTrackLow);
				sliderTrack.appendChild(sliderTrackSelection);
				sliderTrack.appendChild(sliderTrackHigh);

				/* Create highlight range elements */
				this.rangeHighlightElements = [];
				const rangeHighlightsOpts = this.options.rangeHighlights;
				if (Array.isArray(rangeHighlightsOpts) && rangeHighlightsOpts.length > 0) {
					for (let j = 0; j < rangeHighlightsOpts.length; j++) {
						var rangeHighlightElement = document.createElement("div");
						const customClassString = rangeHighlightsOpts[j].class || "";
						rangeHighlightElement.className = `slider-rangeHighlight slider-selection ${customClassString}`;
						this.rangeHighlightElements.push(rangeHighlightElement);
						sliderTrack.appendChild(rangeHighlightElement);
					}
				}

				/* Add aria-labelledby to handle's */
				var isLabelledbyArray = Array.isArray(this.options.labelledby);
				if (isLabelledbyArray && this.options.labelledby[0]) {
					sliderMinHandle.setAttribute('aria-labelledby', this.options.labelledby[0]);
				}
				if (isLabelledbyArray && this.options.labelledby[1]) {
					sliderMaxHandle.setAttribute('aria-labelledby', this.options.labelledby[1]);
				}
				if (!isLabelledbyArray && this.options.labelledby) {
					sliderMinHandle.setAttribute('aria-labelledby', this.options.labelledby);
					sliderMaxHandle.setAttribute('aria-labelledby', this.options.labelledby);
				}

				/* Create ticks */
				this.ticks = [];
				if (Array.isArray(this.options.ticks) && this.options.ticks.length > 0) {
					this.ticksContainer = document.createElement('div');
					this.ticksContainer.className = 'slider-tick-container';

					for (i = 0; i < this.options.ticks.length; i++) {
						var tick = document.createElement('div');
						tick.className = 'slider-tick';
						if (this.options.ticks_tooltip) {
							var tickListenerReference = this._addTickListener();
							var enterCallback = tickListenerReference.addMouseEnter(this, tick, i);
							var leaveCallback = tickListenerReference.addMouseLeave(this, tick);

							this.ticksCallbackMap[i] = {
								mouseEnter: enterCallback,
								mouseLeave: leaveCallback
							};
						}
						this.ticks.push(tick);
						this.ticksContainer.appendChild(tick);
					}

					sliderTrackSelection.className += " tick-slider-selection";
				}

				this.tickLabels = [];
				if (Array.isArray(this.options.ticks_labels) && this.options.ticks_labels.length > 0) {
					this.tickLabelContainer = document.createElement('div');
					this.tickLabelContainer.className = 'slider-tick-label-container';

					for (i = 0; i < this.options.ticks_labels.length; i++) {
						var label = document.createElement('div');
						var noTickPositionsSpecified = this.options.ticks_positions.length === 0;
						var tickLabelsIndex = (this.options.reversed && noTickPositionsSpecified) ? (this.options.ticks_labels.length - (i + 1)) : i;
						label.className = 'slider-tick-label';
						label.innerHTML = this.options.ticks_labels[tickLabelsIndex];

						this.tickLabels.push(label);
						this.tickLabelContainer.appendChild(label);
					}
				}

				const createAndAppendTooltipSubElements = function(tooltipElem) {
					var arrow = document.createElement("div");
					arrow.className = "tooltip-arrow";

					var inner = document.createElement("div");
					inner.className = "tooltip-inner";

					tooltipElem.appendChild(arrow);
					tooltipElem.appendChild(inner);
				};

				/* Create tooltip elements */
				const sliderTooltip = document.createElement("div");
				sliderTooltip.className = "tooltip tooltip-main";
				sliderTooltip.setAttribute('role', 'presentation');
				createAndAppendTooltipSubElements(sliderTooltip);

				const sliderTooltipMin = document.createElement("div");
				sliderTooltipMin.className = "tooltip tooltip-min";
				sliderTooltipMin.setAttribute('role', 'presentation');
				createAndAppendTooltipSubElements(sliderTooltipMin);

				const sliderTooltipMax = document.createElement("div");
				sliderTooltipMax.className = "tooltip tooltip-max";
				sliderTooltipMax.setAttribute('role', 'presentation');
				createAndAppendTooltipSubElements(sliderTooltipMax);

				/* Append components to sliderElem */
				this.sliderElem.appendChild(sliderTrack);
				this.sliderElem.appendChild(sliderTooltip);
				this.sliderElem.appendChild(sliderTooltipMin);
				this.sliderElem.appendChild(sliderTooltipMax);

				if (this.tickLabelContainer) {
					this.sliderElem.appendChild(this.tickLabelContainer);
				}
				if (this.ticksContainer) {
					this.sliderElem.appendChild(this.ticksContainer);
				}

				this.sliderElem.appendChild(sliderMinHandle);
				this.sliderElem.appendChild(sliderMaxHandle);

				/* Append slider element to parent container, right before the original <input> element */
				parent.insertBefore(this.sliderElem, this.element);

				/* Hide original <input> element */
				this.element.style.display = "none";
			}
			/* If JQuery exists, cache JQ references */
			if($) {
				this.$element = $(this.element);
				this.$sliderElem = $(this.sliderElem);
			}

			/*************************************************

								Setup

			**************************************************/
			this.eventToCallbackMap = {};
			this.sliderElem.id = this.options.id;

			this.touchCapable = 'ontouchstart' in window || (window.DocumentTouch && document instanceof window.DocumentTouch);

			this.touchX = 0;
			this.touchY = 0;

			this.tooltip = this.sliderElem.querySelector('.tooltip-main');
			this.tooltipInner = this.tooltip.querySelector('.tooltip-inner');

			this.tooltip_min = this.sliderElem.querySelector('.tooltip-min');
			this.tooltipInner_min = this.tooltip_min.querySelector('.tooltip-inner');

			this.tooltip_max = this.sliderElem.querySelector('.tooltip-max');
			this.tooltipInner_max= this.tooltip_max.querySelector('.tooltip-inner');

			if (SliderScale[this.options.scale]) {
				this.options.scale = SliderScale[this.options.scale];
			}

			if (updateSlider === true) {
				// Reset classes
				this._removeClass(this.sliderElem, 'slider-horizontal');
				this._removeClass(this.sliderElem, 'slider-vertical');
				this._removeClass(this.sliderElem, 'slider-rtl');
				this._removeClass(this.tooltip, 'hide');
				this._removeClass(this.tooltip_min, 'hide');
				this._removeClass(this.tooltip_max, 'hide');

				// Undo existing inline styles for track
				["left", "right", "top", "width", "height"].forEach(function(prop) {
					this._removeProperty(this.trackLow, prop);
					this._removeProperty(this.trackSelection, prop);
					this._removeProperty(this.trackHigh, prop);
				}, this);

				// Undo inline styles on handles
				[this.handle1, this.handle2].forEach(function(handle) {
					this._removeProperty(handle, 'left');
					this._removeProperty(handle, 'right');
					this._removeProperty(handle, 'top');
				}, this);

				// Undo inline styles and classes on tooltips
				[this.tooltip, this.tooltip_min, this.tooltip_max].forEach(function(tooltip) {
					this._removeProperty(tooltip, 'left');
					this._removeProperty(tooltip, 'right');
					this._removeProperty(tooltip, 'top');

					this._removeClass(tooltip, 'right');
					this._removeClass(tooltip, 'left');
					this._removeClass(tooltip, 'top');
				}, this);
			}

			if(this.options.orientation === 'vertical') {
				this._addClass(this.sliderElem,'slider-vertical');
				this.stylePos = 'top';
				this.mousePos = 'pageY';
				this.sizePos = 'offsetHeight';
			} else {
				this._addClass(this.sliderElem, 'slider-horizontal');
				this.sliderElem.style.width = origWidth;
				this.options.orientation = 'horizontal';
				if(this.options.rtl) {
					this.stylePos = 'right';
				} else {
					this.stylePos = 'left';
				}
				this.mousePos = 'clientX';
				this.sizePos = 'offsetWidth';
			}
			// specific rtl class
			if (this.options.rtl) {
				this._addClass(this.sliderElem, 'slider-rtl');
			}
			this._setTooltipPosition();
			/* In case ticks are specified, overwrite the min and max bounds */
			if (Array.isArray(this.options.ticks) && this.options.ticks.length > 0) {
				if (!isMaxSet) {
					this.options.max = Math.max.apply(Math, this.options.ticks);
				}
				if (!isMinSet) {
					this.options.min = Math.min.apply(Math, this.options.ticks);
				}
			}

			if (Array.isArray(this.options.value)) {
				this.options.range = true;
				this._state.value = this.options.value;
			}
			else if (this.options.range) {
				// User wants a range, but value is not an array
				this._state.value = [this.options.value, this.options.max];
			}
			else {
				this._state.value = this.options.value;
			}

			this.trackLow = sliderTrackLow || this.trackLow;
			this.trackSelection = sliderTrackSelection || this.trackSelection;
			this.trackHigh = sliderTrackHigh || this.trackHigh;

			if (this.options.selection === 'none') {
				this._addClass(this.trackLow, 'hide');
				this._addClass(this.trackSelection, 'hide');
				this._addClass(this.trackHigh, 'hide');
			}

			else if (this.options.selection === 'after' || this.options.selection === 'before') {
				this._removeClass(this.trackLow, 'hide');
				this._removeClass(this.trackSelection, 'hide');
				this._removeClass(this.trackHigh, 'hide');
			}

			this.handle1 = sliderMinHandle || this.handle1;
			this.handle2 = sliderMaxHandle || this.handle2;

			if (updateSlider === true) {
				// Reset classes
				this._removeClass(this.handle1, 'round triangle');
				this._removeClass(this.handle2, 'round triangle hide');

				for (i = 0; i < this.ticks.length; i++) {
					this._removeClass(this.ticks[i], 'round triangle hide');
				}
			}

			var availableHandleModifiers = ['round', 'triangle', 'custom'];
			var isValidHandleType = availableHandleModifiers.indexOf(this.options.handle) !== -1;
			if (isValidHandleType) {
				this._addClass(this.handle1, this.options.handle);
				this._addClass(this.handle2, this.options.handle);

				for (i = 0; i < this.ticks.length; i++) {
					this._addClass(this.ticks[i], this.options.handle);
				}
			}

			this._state.offset = this._offset(this.sliderElem);
			this._state.size = this.sliderElem[this.sizePos];
			this.setValue(this._state.value);

			/******************************************

						Bind Event Listeners

			******************************************/

			// Bind keyboard handlers
			this.handle1Keydown = this._keydown.bind(this, 0);
			this.handle1.addEventListener("keydown", this.handle1Keydown, false);

			this.handle2Keydown = this._keydown.bind(this, 1);
			this.handle2.addEventListener("keydown", this.handle2Keydown, false);

			this.mousedown = this._mousedown.bind(this);
			this.touchstart = this._touchstart.bind(this);
			this.touchmove = this._touchmove.bind(this);

			if (this.touchCapable) {
				// Test for passive event support
				let supportsPassive = false;
				try {
					let opts = Object.defineProperty({}, 'passive', {
						get: function() {
							supportsPassive = true;
						}
					});
					window.addEventListener("test", null, opts);
				} catch (e) {}
				// Use our detect's results. passive applied if supported, capture will be false either way.
				let eventOptions = supportsPassive ? { passive: true } : false;
				// Bind touch handlers
				this.sliderElem.addEventListener("touchstart", this.touchstart, eventOptions);
				this.sliderElem.addEventListener("touchmove", this.touchmove, eventOptions);
			}
			this.sliderElem.addEventListener("mousedown", this.mousedown, false);

			// Bind window handlers
			this.resize = this._resize.bind(this);
			window.addEventListener("resize", this.resize, false);


			// Bind tooltip-related handlers
			if(this.options.tooltip === 'hide') {
				this._addClass(this.tooltip, 'hide');
				this._addClass(this.tooltip_min, 'hide');
				this._addClass(this.tooltip_max, 'hide');
			}
			else if(this.options.tooltip === 'always') {
				this._showTooltip();
				this._alwaysShowTooltip = true;
			}
			else {
				this.showTooltip = this._showTooltip.bind(this);
				this.hideTooltip = this._hideTooltip.bind(this);

				if (this.options.ticks_tooltip) {
					var callbackHandle = this._addTickListener();
					//create handle1 listeners and store references in map
					var mouseEnter = callbackHandle.addMouseEnter(this, this.handle1);
					var mouseLeave = callbackHandle.addMouseLeave(this, this.handle1);
					this.handleCallbackMap.handle1 = {
						mouseEnter: mouseEnter,
						mouseLeave: mouseLeave
					};
					//create handle2 listeners and store references in map
					mouseEnter = callbackHandle.addMouseEnter(this, this.handle2);
					mouseLeave = callbackHandle.addMouseLeave(this, this.handle2);
					this.handleCallbackMap.handle2 = {
						mouseEnter: mouseEnter,
						mouseLeave: mouseLeave
					};
				} else {
					this.sliderElem.addEventListener("mouseenter", this.showTooltip, false);
					this.sliderElem.addEventListener("mouseleave", this.hideTooltip, false);
				}

				this.handle1.addEventListener("focus", this.showTooltip, false);
				this.handle1.addEventListener("blur", this.hideTooltip, false);

				this.handle2.addEventListener("focus", this.showTooltip, false);
				this.handle2.addEventListener("blur", this.hideTooltip, false);
			}

			if(this.options.enabled) {
				this.enable();
			} else {
				this.disable();
			}

		}

		/*************************************************

					INSTANCE PROPERTIES/METHODS

		- Any methods bound to the prototype are considered
		part of the plugin's `public` interface

		**************************************************/
		Slider.prototype = {
			_init: function() {}, // NOTE: Must exist to support bridget

			constructor: Slider,

			defaultOptions: {
				id: "",
				min: 0,
				max: 10,
				step: 1,
				precision: 0,
				orientation: 'horizontal',
				value: 5,
				range: false,
				selection: 'before',
				tooltip: 'show',
				tooltip_split: false,
				lock_to_ticks: false,
				handle: 'round',
				reversed: false,
				rtl: 'auto',
				enabled: true,
				formatter: function(val) {
					if (Array.isArray(val)) {
						return val[0] + " : " + val[1];
					} else {
						return val;
					}
				},
				natural_arrow_keys: false,
				ticks: [],
				ticks_positions: [],
				ticks_labels: [],
				ticks_snap_bounds: 0,
				ticks_tooltip: false,
				scale: 'linear',
				focus: false,
				tooltip_position: null,
				labelledby: null,
				rangeHighlights: []
			},

			getElement: function() {
				return this.sliderElem;
			},

			getValue: function() {
				if (this.options.range) {
					return this._state.value;
				}
				else {
					return this._state.value[0];
				}
			},

			setValue: function(val, triggerSlideEvent, triggerChangeEvent) {
				if (!val) {
					val = 0;
				}
				var oldValue = this.getValue();
				this._state.value = this._validateInputValue(val);
				var applyPrecision = this._applyPrecision.bind(this);

				if (this.options.range) {
					this._state.value[0] = applyPrecision(this._state.value[0]);
					this._state.value[1] = applyPrecision(this._state.value[1]);

					if (this.ticksAreValid && this.options.lock_to_ticks) {
						this._state.value[0] = this.options.ticks[this._getClosestTickIndex(this._state.value[0])];
						this._state.value[1] = this.options.ticks[this._getClosestTickIndex(this._state.value[1])];
					}

					this._state.value[0] = Math.max(this.options.min, Math.min(this.options.max, this._state.value[0]));
					this._state.value[1] = Math.max(this.options.min, Math.min(this.options.max, this._state.value[1]));
				}
				else {
					this._state.value = applyPrecision(this._state.value);

					if (this.ticksAreValid && this.options.lock_to_ticks) {
						this._state.value = this.options.ticks[this._getClosestTickIndex(this._state.value)];
					}

					this._state.value = [ Math.max(this.options.min, Math.min(this.options.max, this._state.value))];
					this._addClass(this.handle2, 'hide');
					if (this.options.selection === 'after') {
						this._state.value[1] = this.options.max;
					} else {
						this._state.value[1] = this.options.min;
					}
				}

				// Determine which ticks the handle(s) are set at (if applicable)
				this._setTickIndex();

				if (this.options.max > this.options.min) {
					this._state.percentage = [
						this._toPercentage(this._state.value[0]),
						this._toPercentage(this._state.value[1]),
						this.options.step * 100 / (this.options.max - this.options.min)
					];
				} else {
					this._state.percentage = [0, 0, 100];
				}

				this._layout();
				var newValue = this.options.range ? this._state.value : this._state.value[0];

				this._setDataVal(newValue);
				if(triggerSlideEvent === true) {
					this._trigger('slide', newValue);
				}

				var hasChanged = false;
				if (Array.isArray(newValue)) {
					hasChanged = oldValue[0] !== newValue[0] || oldValue[1] !== newValue[1];
				}
				else {
					hasChanged = oldValue !== newValue;
				}

				if( hasChanged && (triggerChangeEvent === true) ) {
					this._trigger('change', {
						oldValue: oldValue,
						newValue: newValue
					});
				}

				return this;
			},

			destroy: function(){
				// Remove event handlers on slider elements
				this._removeSliderEventHandlers();

				// Remove the slider from the DOM
				this.sliderElem.parentNode.removeChild(this.sliderElem);
				/* Show original <input> element */
				this.element.style.display = "";

				// Clear out custom event bindings
				this._cleanUpEventCallbacksMap();

				// Remove data values
				this.element.removeAttribute("data");

				// Remove JQuery handlers/data
				if($) {
					this._unbindJQueryEventHandlers();
					if (autoRegisterNamespace === NAMESPACE_MAIN) {
						this.$element.removeData(autoRegisterNamespace);
					}
					this.$element.removeData(NAMESPACE_ALTERNATE);
				}
			},

			disable: function() {
				this._state.enabled = false;
				this.handle1.removeAttribute("tabindex");
				this.handle2.removeAttribute("tabindex");
				this._addClass(this.sliderElem, 'slider-disabled');
				this._trigger('slideDisabled');

				return this;
			},

			enable: function() {
				this._state.enabled = true;
				this.handle1.setAttribute("tabindex", 0);
				this.handle2.setAttribute("tabindex", 0);
				this._removeClass(this.sliderElem, 'slider-disabled');
				this._trigger('slideEnabled');

				return this;
			},

			toggle: function() {
				if(this._state.enabled) {
					this.disable();
				} else {
					this.enable();
				}
				return this;
			},

			isEnabled: function() {
				return this._state.enabled;
			},

			on: function(evt, callback) {
				this._bindNonQueryEventHandler(evt, callback);
				return this;
			},

			off: function(evt, callback) {
				if($) {
					this.$element.off(evt, callback);
					this.$sliderElem.off(evt, callback);
				} else {
					this._unbindNonQueryEventHandler(evt, callback);
				}
			},

			getAttribute: function(attribute) {
				if(attribute) {
					return this.options[attribute];
				} else {
					return this.options;
				}
			},

			setAttribute: function(attribute, value) {
				this.options[attribute] = value;
				return this;
			},

			refresh: function(options) {
				const currentValue = this.getValue();
				this._removeSliderEventHandlers();
				createNewSlider.call(this, this.element, this.options);
				// Don't reset slider's value on refresh if `useCurrentValue` is true
				if (options && options.useCurrentValue === true) {
					this.setValue(currentValue);
				}
				if($) {
					// Bind new instance of slider to the element
					if (autoRegisterNamespace === NAMESPACE_MAIN) {
						$.data(this.element, NAMESPACE_MAIN, this);
						$.data(this.element, NAMESPACE_ALTERNATE, this);
					}
					else {
						$.data(this.element, NAMESPACE_ALTERNATE, this);
					}
				}
				return this;
			},

			relayout: function() {
				this._resize();
				return this;
			},

			/******************************+

						HELPERS

			- Any method that is not part of the public interface.
			- Place it underneath this comment block and write its signature like so:

				_fnName : function() {...}

			********************************/
			_removeTooltipListener: function(event) {
				this.handle1.removeEventListener(event, this.showTooltip, false);
				this.handle2.removeEventListener(event, this.showTooltip, false);
			},
			_removeSliderEventHandlers: function() {
				// Remove keydown event listeners
				this.handle1.removeEventListener("keydown", this.handle1Keydown, false);
				this.handle2.removeEventListener("keydown", this.handle2Keydown, false);

				//remove the listeners from the ticks and handles if they had their own listeners
				if (this.options.ticks_tooltip) {
					var ticks = this.ticksContainer.getElementsByClassName('slider-tick');
					for(var i = 0; i < ticks.length; i++ ){
						ticks[i].removeEventListener('mouseenter', this.ticksCallbackMap[i].mouseEnter, false);
						ticks[i].removeEventListener('mouseleave', this.ticksCallbackMap[i].mouseLeave, false);
					}
					if (this.handleCallbackMap.handle1 && this.handleCallbackMap.handle2) {
						this.handle1.removeEventListener('mouseenter', this.handleCallbackMap.handle1.mouseEnter, false);
						this.handle2.removeEventListener('mouseenter', this.handleCallbackMap.handle2.mouseEnter, false);
						this.handle1.removeEventListener('mouseleave', this.handleCallbackMap.handle1.mouseLeave, false);
						this.handle2.removeEventListener('mouseleave', this.handleCallbackMap.handle2.mouseLeave, false);
					}
				}

				this.handleCallbackMap = null;
				this.ticksCallbackMap = null;

				if (this.showTooltip) {
					this._removeTooltipListener("focus");
				}
				if (this.hideTooltip) {
					this._removeTooltipListener("blur");
				}

				// Remove event listeners from sliderElem
				if (this.showTooltip) {
					this.sliderElem.removeEventListener("mouseenter", this.showTooltip, false);
				}
				if (this.hideTooltip) {
					this.sliderElem.removeEventListener("mouseleave", this.hideTooltip, false);
				}
				this.sliderElem.removeEventListener("touchstart", this.touchstart, false);
				this.sliderElem.removeEventListener("touchmove", this.touchmove, false);
				this.sliderElem.removeEventListener("mousedown", this.mousedown, false);

				// Remove window event listener
				window.removeEventListener("resize", this.resize, false);
			},
			_bindNonQueryEventHandler: function(evt, callback) {
				if(this.eventToCallbackMap[evt] === undefined) {
					this.eventToCallbackMap[evt] = [];
				}
				this.eventToCallbackMap[evt].push(callback);
			},
			_unbindNonQueryEventHandler: function(evt, callback) {
				var callbacks = this.eventToCallbackMap[evt];
				if(callbacks !== undefined) {
					for (var i = 0; i < callbacks.length; i++) {
						if (callbacks[i] === callback) {
							callbacks.splice(i, 1);
							break;
						}
					}
				}
			},
			_cleanUpEventCallbacksMap: function() {
				var eventNames = Object.keys(this.eventToCallbackMap);
				for(var i = 0; i < eventNames.length; i++) {
					var eventName = eventNames[i];
					delete this.eventToCallbackMap[eventName];
				}
			},
			_showTooltip: function() {
				if (this.options.tooltip_split === false ){
					this._addClass(this.tooltip, 'in');
					this.tooltip_min.style.display = 'none';
					this.tooltip_max.style.display = 'none';
			    } else {
					this._addClass(this.tooltip_min, 'in');
					this._addClass(this.tooltip_max, 'in');
					this.tooltip.style.display = 'none';
				}
				this._state.over = true;
			},
			_hideTooltip: function() {
				if (this._state.inDrag === false && this._alwaysShowTooltip !== true) {
					this._removeClass(this.tooltip, 'in');
					this._removeClass(this.tooltip_min, 'in');
					this._removeClass(this.tooltip_max, 'in');
				}
				this._state.over = false;
			},
			_setToolTipOnMouseOver: function _setToolTipOnMouseOver(tempState){
				let self = this;
				var formattedTooltipVal = this.options.formatter(!tempState ? this._state.value[0]: tempState.value[0]);
				var positionPercentages = !tempState ? getPositionPercentages(this._state, this.options.reversed) : getPositionPercentages(tempState, this.options.reversed);
				this._setText(this.tooltipInner, formattedTooltipVal);

				this.tooltip.style[this.stylePos] = `${positionPercentages[0]}%`;

				function getPositionPercentages(state, reversed){
					if (reversed) {
						return [100 - state.percentage[0], self.options.range ? 100 - state.percentage[1] : state.percentage[1]];
					}
					return [state.percentage[0], state.percentage[1]];
				}
			},
			_copyState: function() {
				return {
					value: [ this._state.value[0], this._state.value[1] ],
					enabled: this._state.enabled,
					offset: this._state.offset,
					size: this._state.size,
					percentage: [ this._state.percentage[0], this._state.percentage[1], this._state.percentage[2] ],
					inDrag: this._state.inDrag,
					over: this._state.over,
					// deleted or null'd keys
					dragged: this._state.dragged,
					keyCtrl: this._state.keyCtrl
				};
			},
			_addTickListener: function _addTickListener() {
				return {
					addMouseEnter: function(reference, element, index){
						var enter = function(){
							let tempState = reference._copyState();
							// Which handle is being hovered over?
							let val = element === reference.handle1 ? tempState.value[0] : tempState.value[1];
							let per;

							// Setup value and percentage for tick's 'mouseenter'
							if (index !== undefined) {
								val = reference.options.ticks[index];
								per = (reference.options.ticks_positions.length > 0 && reference.options.ticks_positions[index]) ||
									reference._toPercentage(reference.options.ticks[index]);
							}
							else {
								per = reference._toPercentage(val);
							}

							tempState.value[0] = val;
							tempState.percentage[0] = per;
							reference._setToolTipOnMouseOver(tempState);
							reference._showTooltip();
						};
						element.addEventListener("mouseenter", enter, false);
						return enter;
					},
					addMouseLeave: function(reference, element){
						var leave = function(){
							reference._hideTooltip();
						};
						element.addEventListener("mouseleave", leave, false);
						return leave;
					}
				};
			},
			_layout: function() {
				var positionPercentages;
				var formattedValue;

				if(this.options.reversed) {
					positionPercentages = [ 100 - this._state.percentage[0], this.options.range ? 100 - this._state.percentage[1] : this._state.percentage[1]];
				}
				else {
					positionPercentages = [ this._state.percentage[0], this._state.percentage[1] ];
				}

				this.handle1.style[this.stylePos] = `${positionPercentages[0]}%`;
				this.handle1.setAttribute('aria-valuenow', this._state.value[0]);
				formattedValue = this.options.formatter(this._state.value[0]);
				if (isNaN(formattedValue)) {
					this.handle1.setAttribute('aria-valuetext', formattedValue);
				}
				else {
					this.handle1.removeAttribute('aria-valuetext');
				}

				this.handle2.style[this.stylePos] =`${positionPercentages[1]}%`;
				this.handle2.setAttribute('aria-valuenow', this._state.value[1]);
				formattedValue = this.options.formatter(this._state.value[1]);
				if (isNaN(formattedValue)) {
					this.handle2.setAttribute('aria-valuetext', formattedValue);
				}
				else {
					this.handle2.removeAttribute('aria-valuetext');
				}

				/* Position highlight range elements */
				if (this.rangeHighlightElements.length > 0 && Array.isArray(this.options.rangeHighlights) && this.options.rangeHighlights.length > 0) {
					for (let i = 0; i < this.options.rangeHighlights.length; i++) {
						var startPercent = this._toPercentage(this.options.rangeHighlights[i].start);
						var endPercent = this._toPercentage(this.options.rangeHighlights[i].end);

						if (this.options.reversed) {
							var sp = 100-endPercent;
							endPercent = 100-startPercent;
							startPercent = sp;
						}

						var currentRange = this._createHighlightRange(startPercent, endPercent);

						if (currentRange) {
							if (this.options.orientation === 'vertical') {
								this.rangeHighlightElements[i].style.top = `${currentRange.start}%`;
								this.rangeHighlightElements[i].style.height = `${currentRange.size}%`;
							} else {
								if(this.options.rtl){
									this.rangeHighlightElements[i].style.right = `${currentRange.start}%`;
								} else {
									this.rangeHighlightElements[i].style.left = `${currentRange.start}%`;
								}
								this.rangeHighlightElements[i].style.width = `${currentRange.size}%`;
							}
						} else {
							this.rangeHighlightElements[i].style.display = "none";
						}
					}
				}

				/* Position ticks and labels */
				if (Array.isArray(this.options.ticks) && this.options.ticks.length > 0) {

					var styleSize = this.options.orientation === 'vertical' ? 'height' : 'width';
					var styleMargin;
					if( this.options.orientation === 'vertical' ){
						styleMargin='marginTop';
					}else {
						if( this.options.rtl ){
							styleMargin='marginRight';
						} else {
							styleMargin='marginLeft';
						}
					}
					var labelSize = this._state.size / (this.options.ticks.length - 1);

					if (this.tickLabelContainer) {
						var extraMargin = 0;
						if (this.options.ticks_positions.length === 0) {
							if (this.options.orientation !== 'vertical') {
								this.tickLabelContainer.style[styleMargin] = `${ -labelSize/2 }px`;
							}

							extraMargin = this.tickLabelContainer.offsetHeight;
						} else {
							/* Chidren are position absolute, calculate height by finding the max offsetHeight of a child */
							for (i = 0 ; i < this.tickLabelContainer.childNodes.length; i++) {
								if (this.tickLabelContainer.childNodes[i].offsetHeight > extraMargin) {
									extraMargin = this.tickLabelContainer.childNodes[i].offsetHeight;
								}
							}
						}
						if (this.options.orientation === 'horizontal') {
							this.sliderElem.style.marginBottom = `${ extraMargin }px`;
						}
					}
					for (var i = 0; i < this.options.ticks.length; i++) {

						var percentage = this.options.ticks_positions[i] || this._toPercentage(this.options.ticks[i]);

						if (this.options.reversed) {
							percentage = 100 - percentage;
						}

						this.ticks[i].style[this.stylePos] = `${ percentage }%`;

						/* Set class labels to denote whether ticks are in the selection */
						this._removeClass(this.ticks[i], 'in-selection');
						if (!this.options.range) {
							if (this.options.selection === 'after' && percentage >= positionPercentages[0]){
								this._addClass(this.ticks[i], 'in-selection');
							} else if (this.options.selection === 'before' && percentage <= positionPercentages[0]) {
								this._addClass(this.ticks[i], 'in-selection');
							}
						} else if (percentage >= positionPercentages[0] && percentage <= positionPercentages[1]) {
							this._addClass(this.ticks[i], 'in-selection');
						}

						if (this.tickLabels[i]) {
							this.tickLabels[i].style[styleSize] = `${labelSize}px`;

							if (this.options.orientation !== 'vertical' && this.options.ticks_positions[i] !== undefined) {
								this.tickLabels[i].style.position = 'absolute';
								this.tickLabels[i].style[this.stylePos] = `${percentage}%`;
								this.tickLabels[i].style[styleMargin] = -labelSize/2 + 'px';
							} else if (this.options.orientation === 'vertical') {
								if(this.options.rtl){
									this.tickLabels[i].style['marginRight'] = `${this.sliderElem.offsetWidth }px`;
								}else{
									this.tickLabels[i].style['marginLeft'] = `${this.sliderElem.offsetWidth }px`;
								}
								this.tickLabelContainer.style[styleMargin] = this.sliderElem.offsetWidth / 2 * -1 + 'px';
							}

							/* Set class labels to indicate tick labels are in the selection or selected */
							this._removeClass(this.tickLabels[i], 'label-in-selection label-is-selection');
							if (!this.options.range) {
								if (this.options.selection === 'after' && percentage >= positionPercentages[0]) {
									this._addClass(this.tickLabels[i], 'label-in-selection');
								} else if (this.options.selection === 'before' && percentage <= positionPercentages[0]) {
									this._addClass(this.tickLabels[i], 'label-in-selection');
								}
								if (percentage === positionPercentages[0]) {
									this._addClass(this.tickLabels[i], 'label-is-selection');
								}
							} else if (percentage >= positionPercentages[0] && percentage <= positionPercentages[1]) {
								this._addClass(this.tickLabels[i], 'label-in-selection');
								if (percentage === positionPercentages[0] || positionPercentages[1]) {
									this._addClass(this.tickLabels[i], 'label-is-selection');
								}
							}
						}
					}
				}

				var formattedTooltipVal;

				if (this.options.range) {
					formattedTooltipVal = this.options.formatter(this._state.value);
					this._setText(this.tooltipInner, formattedTooltipVal);
					this.tooltip.style[this.stylePos] = `${ (positionPercentages[1] + positionPercentages[0])/2 }%`;

					var innerTooltipMinText = this.options.formatter(this._state.value[0]);
					this._setText(this.tooltipInner_min, innerTooltipMinText);

					var innerTooltipMaxText = this.options.formatter(this._state.value[1]);
					this._setText(this.tooltipInner_max, innerTooltipMaxText);

					this.tooltip_min.style[this.stylePos] = `${ positionPercentages[0] }%`;

					this.tooltip_max.style[this.stylePos] = `${ positionPercentages[1] }%`;

				} else {
					formattedTooltipVal = this.options.formatter(this._state.value[0]);
					this._setText(this.tooltipInner, formattedTooltipVal);

					this.tooltip.style[this.stylePos] = `${ positionPercentages[0] }%`;
				}

				if (this.options.orientation === 'vertical') {
					this.trackLow.style.top = '0';
					this.trackLow.style.height = Math.min(positionPercentages[0], positionPercentages[1]) +'%';

					this.trackSelection.style.top = Math.min(positionPercentages[0], positionPercentages[1]) +'%';
					this.trackSelection.style.height = Math.abs(positionPercentages[0] - positionPercentages[1]) +'%';

					this.trackHigh.style.bottom = '0';
					this.trackHigh.style.height = (100 - Math.min(positionPercentages[0], positionPercentages[1]) - Math.abs(positionPercentages[0] - positionPercentages[1])) +'%';
				}
				else {
					if(this.stylePos==='right') {
						this.trackLow.style.right = '0';
					} else {
						this.trackLow.style.left = '0';
					}
					this.trackLow.style.width = Math.min(positionPercentages[0], positionPercentages[1]) +'%';

					if(this.stylePos==='right') {
						this.trackSelection.style.right = Math.min(positionPercentages[0], positionPercentages[1]) + '%';
					} else {
						this.trackSelection.style.left = Math.min(positionPercentages[0], positionPercentages[1]) + '%';
					}
					this.trackSelection.style.width = Math.abs(positionPercentages[0] - positionPercentages[1]) +'%';

					if(this.stylePos==='right') {
						this.trackHigh.style.left = '0';
					} else {
						this.trackHigh.style.right = '0';
					}
					this.trackHigh.style.width = (100 - Math.min(positionPercentages[0], positionPercentages[1]) - Math.abs(positionPercentages[0] - positionPercentages[1])) +'%';

					var offset_min = this.tooltip_min.getBoundingClientRect();
					var offset_max = this.tooltip_max.getBoundingClientRect();

					if (this.options.tooltip_position === 'bottom') {
						if (offset_min.right > offset_max.left) {
							this._removeClass(this.tooltip_max, 'bottom');
							this._addClass(this.tooltip_max, 'top');
							this.tooltip_max.style.top = '';
							this.tooltip_max.style.bottom = 22 + 'px';
						} else {
							this._removeClass(this.tooltip_max, 'top');
							this._addClass(this.tooltip_max, 'bottom');
							this.tooltip_max.style.top = this.tooltip_min.style.top;
							this.tooltip_max.style.bottom = '';
						}
					} else {
						if (offset_min.right > offset_max.left) {
							this._removeClass(this.tooltip_max, 'top');
							this._addClass(this.tooltip_max, 'bottom');
							this.tooltip_max.style.top = 18 + 'px';
						} else {
							this._removeClass(this.tooltip_max, 'bottom');
							this._addClass(this.tooltip_max, 'top');
							this.tooltip_max.style.top = this.tooltip_min.style.top;
						}
					}
				}
			},
			_createHighlightRange: function (start, end) {
				if (this._isHighlightRange(start, end)) {
					if (start > end) {
						return {'start': end, 'size': start - end};
					}
					return {'start': start, 'size': end - start};
				}
				return null;
			},
			_isHighlightRange: function (start, end) {
				if (0 <= start && start <= 100 && 0 <= end && end <= 100) {
					return true;
				}
				else {
					return false;
				}
			},
			_resize: function (ev) {
				/*jshint unused:false*/
				this._state.offset = this._offset(this.sliderElem);
				this._state.size = this.sliderElem[this.sizePos];
				this._layout();
			},
			_removeProperty: function(element, prop) {
				if (element.style.removeProperty) {
				    element.style.removeProperty(prop);
				} else {
				    element.style.removeAttribute(prop);
				}
			},
			_mousedown: function(ev) {
				if(!this._state.enabled) {
					return false;
				}

				if (ev.preventDefault){
					ev.preventDefault();
				}

				this._state.offset = this._offset(this.sliderElem);
				this._state.size = this.sliderElem[this.sizePos];

				var percentage = this._getPercentage(ev);

				if (this.options.range) {
					var diff1 = Math.abs(this._state.percentage[0] - percentage);
					var diff2 = Math.abs(this._state.percentage[1] - percentage);
					this._state.dragged = (diff1 < diff2) ? 0 : 1;
					this._adjustPercentageForRangeSliders(percentage);
				} else {
					this._state.dragged = 0;
				}

				this._state.percentage[this._state.dragged] = percentage;

				if (this.touchCapable) {
					document.removeEventListener("touchmove", this.mousemove, false);
					document.removeEventListener("touchend", this.mouseup, false);
				}

				if(this.mousemove){
					document.removeEventListener("mousemove", this.mousemove, false);
				}
				if(this.mouseup){
					document.removeEventListener("mouseup", this.mouseup, false);
				}

				this.mousemove = this._mousemove.bind(this);
				this.mouseup = this._mouseup.bind(this);

				if (this.touchCapable) {
					// Touch: Bind touch events:
					document.addEventListener("touchmove", this.mousemove, false);
					document.addEventListener("touchend", this.mouseup, false);
				}
				// Bind mouse events:
				document.addEventListener("mousemove", this.mousemove, false);
				document.addEventListener("mouseup", this.mouseup, false);

				this._state.inDrag = true;
				var newValue = this._calculateValue();

				this._trigger('slideStart', newValue);

				this.setValue(newValue, false, true);

				ev.returnValue = false;

				if (this.options.focus) {
					this._triggerFocusOnHandle(this._state.dragged);
				}

				return true;
			},
			_touchstart: function(ev) {
				if (ev.changedTouches === undefined) {
					this._mousedown(ev);
					return;
				}

				var touch = ev.changedTouches[0];
				this.touchX = touch.pageX;
				this.touchY = touch.pageY;
			},
			_triggerFocusOnHandle: function(handleIdx) {
				if(handleIdx === 0) {
					this.handle1.focus();
				}
				if(handleIdx === 1) {
					this.handle2.focus();
				}
			},
			_keydown: function(handleIdx, ev) {
				if(!this._state.enabled) {
					return false;
				}

				var dir;
				switch (ev.keyCode) {
					case 37: // left
					case 40: // down
						dir = -1;
						break;
					case 39: // right
					case 38: // up
						dir = 1;
						break;
				}
				if (!dir) {
					return;
				}

				// use natural arrow keys instead of from min to max
				if (this.options.natural_arrow_keys) {
					const isHorizontal = this.options.orientation === 'horizontal';
					const isVertical = this.options.orientation === 'vertical';
					const isRTL = this.options.rtl;
					const isReversed = this.options.reversed;

					if (isHorizontal) {
						if (isRTL) {
							if (!isReversed) {
								dir = -dir;
							}
						}
						else {
							if (isReversed) {
								dir = -dir;
							}
						}
					}
					else if (isVertical) {
						if (!isReversed) {
							dir = -dir;
						}
					}
				}

				var val;
				if (this.ticksAreValid && this.options.lock_to_ticks) {
					let index;
					// Find tick index that handle 1/2 is currently on
					index = this.options.ticks.indexOf(this._state.value[handleIdx]);
					if (index === -1) {
						// Set default to first tick
						index = 0;
						window.console.warn('(lock_to_ticks) _keydown: index should not be -1');
					}
					index += dir;
					index = Math.max(0, Math.min(this.options.ticks.length-1, index));
					val = this.options.ticks[index];
				}
				else {
					val = this._state.value[handleIdx] + dir * this.options.step;
				}
				const percentage = this._toPercentage(val);
				this._state.keyCtrl = handleIdx;
				if (this.options.range) {
					this._adjustPercentageForRangeSliders(percentage);
					const val1 = (!this._state.keyCtrl) ? val : this._state.value[0];
					const val2 = (this._state.keyCtrl) ? val : this._state.value[1];
					// Restrict values within limits
					val = [ Math.max(this.options.min, Math.min(this.options.max, val1)),
						Math.max(this.options.min, Math.min(this.options.max, val2)) ];
				}
				else {
					val = Math.max(this.options.min, Math.min(this.options.max, val));
				}

				this._trigger('slideStart', val);

				this.setValue(val, true, true);

				this._trigger('slideStop', val);

				this._pauseEvent(ev);
				delete this._state.keyCtrl;

				return false;
			},
			_pauseEvent: function(ev) {
				if(ev.stopPropagation) {
					ev.stopPropagation();
				}
				if(ev.preventDefault) {
					ev.preventDefault();
				}
				ev.cancelBubble=true;
				ev.returnValue=false;
			},
			_mousemove: function(ev) {
				if(!this._state.enabled) {
					return false;
				}

				var percentage = this._getPercentage(ev);
				this._adjustPercentageForRangeSliders(percentage);
				this._state.percentage[this._state.dragged] = percentage;

				var val = this._calculateValue(true);
				this.setValue(val, true, true);

				return false;
			},
			_touchmove: function(ev) {
				if (ev.changedTouches === undefined) {
					return;
				}

				var touch = ev.changedTouches[0];

				var xDiff = touch.pageX - this.touchX;
				var yDiff = touch.pageY - this.touchY;

				if (!this._state.inDrag) {
					// Vertical Slider
					if (this.options.orientation === 'vertical' && (xDiff <= 5 && xDiff >= -5) && (yDiff >=15 || yDiff <= -15)) {
						this._mousedown(ev);
					}
					// Horizontal slider.
					else if ((yDiff <= 5 && yDiff >= -5) && (xDiff >= 15 || xDiff <= -15)) {
						this._mousedown(ev);
					}
				}
			},
			_adjustPercentageForRangeSliders: function(percentage) {
				if (this.options.range) {
					var precision = this._getNumDigitsAfterDecimalPlace(percentage);
					precision = precision ? precision - 1 : 0;
					var percentageWithAdjustedPrecision = this._applyToFixedAndParseFloat(percentage, precision);
					if (this._state.dragged === 0 && this._applyToFixedAndParseFloat(this._state.percentage[1], precision) < percentageWithAdjustedPrecision) {
						this._state.percentage[0] = this._state.percentage[1];
						this._state.dragged = 1;
					} else if (this._state.dragged === 1 && this._applyToFixedAndParseFloat(this._state.percentage[0], precision) > percentageWithAdjustedPrecision) {
						this._state.percentage[1] = this._state.percentage[0];
						this._state.dragged = 0;
					}
					else if (this._state.keyCtrl === 0 && (this._toPercentage(this._state.value[1]) < percentage)) {
						this._state.percentage[0] = this._state.percentage[1];
						this._state.keyCtrl = 1;
						this.handle2.focus();
					}
					else if (this._state.keyCtrl === 1 && (this._toPercentage(this._state.value[0]) > percentage)) {
						this._state.percentage[1] = this._state.percentage[0];
						this._state.keyCtrl = 0;
						this.handle1.focus();
					}
				}
			},
			_mouseup: function(ev) {
				if(!this._state.enabled) {
					return false;
				}

				var percentage = this._getPercentage(ev);
				this._adjustPercentageForRangeSliders(percentage);
				this._state.percentage[this._state.dragged] = percentage;

				if (this.touchCapable) {
					// Touch: Unbind touch event handlers:
					document.removeEventListener("touchmove", this.mousemove, false);
					document.removeEventListener("touchend", this.mouseup, false);
				}
				// Unbind mouse event handlers:
				document.removeEventListener("mousemove", this.mousemove, false);
				document.removeEventListener("mouseup", this.mouseup, false);

				this._state.inDrag = false;
				if (this._state.over === false) {
					this._hideTooltip();
				}
				var val = this._calculateValue(true);

				this.setValue(val, false, true);
				this._trigger('slideStop', val);

				// No longer need 'dragged' after mouse up
				this._state.dragged = null;

				return false;
			},
			_setValues: function(index, val) {
				const comp = (0 === index) ? 0 : 100;
				if (this._state.percentage[index] !== comp) {
					val.data[index] = this._toValue(this._state.percentage[index]);
					val.data[index] = this._applyPrecision(val.data[index]);
				}
			},
			_calculateValue: function(snapToClosestTick) {
				let val = {};
				if (this.options.range) {
					val.data = [this.options.min, this.options.max];
					this._setValues(0, val);
					this._setValues(1, val);
					if (snapToClosestTick) {
						val.data[0] = this._snapToClosestTick(val.data[0]);
						val.data[1] = this._snapToClosestTick(val.data[1]);
					}
				} else {
					val.data = this._toValue(this._state.percentage[0]);
					val.data = parseFloat(val.data);
					val.data = this._applyPrecision(val.data);
					if (snapToClosestTick) {
						val.data = this._snapToClosestTick(val.data);
					}
				}

				return val.data;
			},
			_snapToClosestTick(val){
				var min = [val, Infinity];
				for (var i = 0; i < this.options.ticks.length; i++) {
					var diff = Math.abs(this.options.ticks[i] - val);
					if (diff <= min[1]) {
						min = [this.options.ticks[i], diff];
					}
				}
				if (min[1] <= this.options.ticks_snap_bounds) {
					return min[0];
				}
				return val;
			},
			_applyPrecision: function(val) {
				var precision = this.options.precision || this._getNumDigitsAfterDecimalPlace(this.options.step);
				return this._applyToFixedAndParseFloat(val, precision);
			},
			_getNumDigitsAfterDecimalPlace: function(num) {
				var match = (''+num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
				if (!match) { return 0; }
				return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
			},
			_applyToFixedAndParseFloat: function(num, toFixedInput) {
				var truncatedNum = num.toFixed(toFixedInput);
				return parseFloat(truncatedNum);
			},
			/*
				Credits to Mike Samuel for the following method!
				Source: http://stackoverflow.com/questions/10454518/javascript-how-to-retrieve-the-number-of-decimals-of-a-string-number
			*/
			_getPercentage: function(ev) {
				if (this.touchCapable && (ev.type === 'touchstart' || ev.type === 'touchmove')) {
					ev = ev.touches[0];
				}

				var eventPosition = ev[this.mousePos];
				var sliderOffset = this._state.offset[this.stylePos];
				var distanceToSlide = eventPosition - sliderOffset;
				if(this.stylePos==='right') {
					distanceToSlide = -distanceToSlide;
				}
				// Calculate what percent of the length the slider handle has slid
				var percentage = (distanceToSlide / this._state.size) * 100;
				percentage = Math.round(percentage / this._state.percentage[2]) * this._state.percentage[2];
				if (this.options.reversed) {
					percentage = 100 - percentage;
				}

				// Make sure the percent is within the bounds of the slider.
				// 0% corresponds to the 'min' value of the slide
				// 100% corresponds to the 'max' value of the slide
				return Math.max(0, Math.min(100, percentage));
			},
			_validateInputValue: function(val) {
				if (!isNaN(+val)) {
					return +val;
				} else if (Array.isArray(val)) {
					this._validateArray(val);
					return val;
				} else {
					throw new Error(ErrorMsgs.formatInvalidInputErrorMsg(val));
				}
			},
			_validateArray: function(val) {
				for(var i = 0; i < val.length; i++) {
					var input =  val[i];
					if (typeof input !== 'number') { throw new Error( ErrorMsgs.formatInvalidInputErrorMsg(input) ); }
				}
			},
			_setDataVal: function(val) {
				this.element.setAttribute('data-value', val);
				this.element.setAttribute('value', val);
				this.element.value = val;
			},
			_trigger: function(evt, val) {
				val = (val || val === 0) ? val : undefined;

				var callbackFnArray = this.eventToCallbackMap[evt];
				if(callbackFnArray && callbackFnArray.length) {
					for(var i = 0; i < callbackFnArray.length; i++) {
						var callbackFn = callbackFnArray[i];
						callbackFn(val);
					}
				}

				/* If JQuery exists, trigger JQuery events */
				if($) {
					this._triggerJQueryEvent(evt, val);
				}
			},
			_triggerJQueryEvent: function(evt, val) {
				var eventData = {
					type: evt,
					value: val
				};
				this.$element.trigger(eventData);
				this.$sliderElem.trigger(eventData);
			},
			_unbindJQueryEventHandlers: function() {
				this.$element.off();
				this.$sliderElem.off();
			},
			_setText: function(element, text) {
				if(typeof element.textContent !== "undefined") {
					element.textContent = text;
				} else if(typeof element.innerText !== "undefined") {
					element.innerText = text;
				}
			},
			_removeClass: function(element, classString) {
				var classes = classString.split(" ");
				var newClasses = element.className;

				for(var i = 0; i < classes.length; i++) {
					var classTag = classes[i];
					var regex = new RegExp("(?:\\s|^)" + classTag + "(?:\\s|$)");
					newClasses = newClasses.replace(regex, " ");
				}

				element.className = newClasses.trim();
			},
			_addClass: function(element, classString) {
				var classes = classString.split(" ");
				var newClasses = element.className;

				for(var i = 0; i < classes.length; i++) {
					var classTag = classes[i];
					var regex = new RegExp("(?:\\s|^)" + classTag + "(?:\\s|$)");
					var ifClassExists = regex.test(newClasses);

					if(!ifClassExists) {
						newClasses += " " + classTag;
					}
				}

				element.className = newClasses.trim();
			},
			_offsetLeft: function(obj){
				return obj.getBoundingClientRect().left;
			},
			_offsetRight: function(obj){
				return obj.getBoundingClientRect().right;
			},
			_offsetTop: function(obj){
				var offsetTop = obj.offsetTop;
				while((obj = obj.offsetParent) && !isNaN(obj.offsetTop)){
					offsetTop += obj.offsetTop;
					if( obj.tagName !== 'BODY') {
						offsetTop -= obj.scrollTop;
					}
				}
				return offsetTop;
			},
			_offset: function (obj) {
				return {
					left: this._offsetLeft(obj),
					right: this._offsetRight(obj),
					top: this._offsetTop(obj)
				};
		    },
			_css: function(elementRef, styleName, value) {
				if ($) {
					$.style(elementRef, styleName, value);
				} else {
					var style = styleName.replace(/^-ms-/, "ms-").replace(/-([\da-z])/gi, function (all, letter) {
						return letter.toUpperCase();
					});
					elementRef.style[style] = value;
				}
			},
			_toValue: function(percentage) {
				return this.options.scale.toValue.apply(this, [percentage]);
			},
			_toPercentage: function(value) {
				return this.options.scale.toPercentage.apply(this, [value]);
			},
			_setTooltipPosition: function(){
				var tooltips = [this.tooltip, this.tooltip_min, this.tooltip_max];
				if (this.options.orientation === 'vertical'){
					var tooltipPos;
					if(this.options.tooltip_position) {
						tooltipPos = this.options.tooltip_position;
					} else {
						if(this.options.rtl) {
							tooltipPos = 'left';
						} else {
							tooltipPos = 'right';
						}
					}
					var oppositeSide = (tooltipPos === 'left') ? 'right' : 'left';
					tooltips.forEach(function(tooltip){
						this._addClass(tooltip, tooltipPos);
						tooltip.style[oppositeSide] = '100%';
					}.bind(this));
				} else if(this.options.tooltip_position === 'bottom') {
					tooltips.forEach(function(tooltip){
						this._addClass(tooltip, 'bottom');
						tooltip.style.top = 22 + 'px';
					}.bind(this));
				} else {
					tooltips.forEach(function(tooltip){
						this._addClass(tooltip, 'top');
						tooltip.style.top = -this.tooltip.outerHeight - 14 + 'px';
					}.bind(this));
				}
			},
			_getClosestTickIndex: function(val) {
				let difference = Math.abs(val - this.options.ticks[0]);
				let index = 0;
				for (let i = 0; i < this.options.ticks.length; ++i) {
					let d = Math.abs(val - this.options.ticks[i]);
					if (d < difference) {
						difference = d;
						index = i;
					}
				}
				return index;
			},
			/**
			 * Attempts to find the index in `ticks[]` the slider values are set at.
			 * The indexes can be -1 to indicate the slider value is not set at a value in `ticks[]`.
			 */
			_setTickIndex: function() {
				if (this.ticksAreValid) {
					this._state.tickIndex = [
						this.options.ticks.indexOf(this._state.value[0]),
						this.options.ticks.indexOf(this._state.value[1])
					];
				}
			},
		};

		/*********************************

			Attach to global namespace

		*********************************/
		if($ && $.fn) {
			if (!$.fn.slider) {
				$.bridget(NAMESPACE_MAIN, Slider);
				autoRegisterNamespace = NAMESPACE_MAIN;
			}
			else {
				if (windowIsDefined) {
					window.console.warn("bootstrap-slider.js - WARNING: $.fn.slider namespace is already bound. Use the $.fn.bootstrapSlider namespace instead.");
				}
				autoRegisterNamespace = NAMESPACE_ALTERNATE;
			}
			$.bridget(NAMESPACE_ALTERNATE, Slider);

			// Auto-Register data-provide="slider" Elements
			$(function() {
				$("input[data-provide=slider]")[autoRegisterNamespace]();
			});
		}

	})( $ );

	return Slider;
}));

/*!
 * Pikaday
 *
 * Copyright © 2014 David Bushell | BSD & MIT license | https://github.com/Pikaday/Pikaday
 */

(function (root, factory)
{
    'use strict';

    var moment;
    if (typeof exports === 'object') {
        // CommonJS module
        // Load moment.js as an optional dependency
        try { moment = require('moment'); } catch (e) {}
        module.exports = factory(moment);
    } else if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(function (req)
        {
            // Load moment.js as an optional dependency
            var id = 'moment';
            try { moment = req(id); } catch (e) {}
            return factory(moment);
        });
    } else {
        root.Pikaday = factory(root.moment);
    }
}(this, function (moment)
{
    'use strict';

    /**
     * feature detection and helper functions
     */
    var hasMoment = typeof moment === 'function',

        hasEventListeners = !!window.addEventListener,

        document = window.document,

        sto = window.setTimeout,

        addEvent = function(el, e, callback, capture)
        {
            if (hasEventListeners) {
                el.addEventListener(e, callback, !!capture);
            } else {
                el.attachEvent('on' + e, callback);
            }
        },

        removeEvent = function(el, e, callback, capture)
        {
            if (hasEventListeners) {
                el.removeEventListener(e, callback, !!capture);
            } else {
                el.detachEvent('on' + e, callback);
            }
        },

        trim = function(str)
        {
            return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g,'');
        },

        hasClass = function(el, cn)
        {
            return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
        },

        addClass = function(el, cn)
        {
            if (!hasClass(el, cn)) {
                el.className = (el.className === '') ? cn : el.className + ' ' + cn;
            }
        },

        removeClass = function(el, cn)
        {
            el.className = trim((' ' + el.className + ' ').replace(' ' + cn + ' ', ' '));
        },

        isArray = function(obj)
        {
            return (/Array/).test(Object.prototype.toString.call(obj));
        },

        isDate = function(obj)
        {
            return (/Date/).test(Object.prototype.toString.call(obj)) && !isNaN(obj.getTime());
        },

        isWeekend = function(date)
        {
            var day = date.getDay();
            return day === 0 || day === 6;
        },

        isLeapYear = function(year)
        {
            // solution lifted from date.js (MIT license): https://github.com/datejs/Datejs
            return ((year % 4 === 0 && year % 100 !== 0) || year % 400 === 0);
        },

        getDaysInMonth = function(year, month)
        {
            return [31, isLeapYear(year) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
        },

        setToStartOfDay = function(date)
        {
            if (isDate(date)) date.setHours(0,0,0,0);
        },

        compareDates = function(a,b)
        {
            // weak date comparison (use setToStartOfDay(date) to ensure correct result)
            return a.getTime() === b.getTime();
        },

        extend = function(to, from, overwrite)
        {
            var prop, hasProp;
            for (prop in from) {
                hasProp = to[prop] !== undefined;
                if (hasProp && typeof from[prop] === 'object' && from[prop] !== null && from[prop].nodeName === undefined) {
                    if (isDate(from[prop])) {
                        if (overwrite) {
                            to[prop] = new Date(from[prop].getTime());
                        }
                    }
                    else if (isArray(from[prop])) {
                        if (overwrite) {
                            to[prop] = from[prop].slice(0);
                        }
                    } else {
                        to[prop] = extend({}, from[prop], overwrite);
                    }
                } else if (overwrite || !hasProp) {
                    to[prop] = from[prop];
                }
            }
            return to;
        },

        fireEvent = function(el, eventName, data)
        {
            var ev;

            if (document.createEvent) {
                ev = document.createEvent('HTMLEvents');
                ev.initEvent(eventName, true, false);
                ev = extend(ev, data);
                el.dispatchEvent(ev);
            } else if (document.createEventObject) {
                ev = document.createEventObject();
                ev = extend(ev, data);
                el.fireEvent('on' + eventName, ev);
            }
        },

        adjustCalendar = function(calendar) {
            if (calendar.month < 0) {
                calendar.year -= Math.ceil(Math.abs(calendar.month)/12);
                calendar.month += 12;
            }
            if (calendar.month > 11) {
                calendar.year += Math.floor(Math.abs(calendar.month)/12);
                calendar.month -= 12;
            }
            return calendar;
        },

        /**
         * defaults and localisation
         */
        defaults = {

            // bind the picker to a form field
            field: null,

            // automatically show/hide the picker on `field` focus (default `true` if `field` is set)
            bound: undefined,

            // data-attribute on the input field with an aria assistance tekst (only applied when `bound` is set)
            ariaLabel: 'Use the arrow keys to pick a date',

            // position of the datepicker, relative to the field (default to bottom & left)
            // ('bottom' & 'left' keywords are not used, 'top' & 'right' are modifier on the bottom/left position)
            position: 'bottom left',

            // automatically fit in the viewport even if it means repositioning from the position option
            reposition: true,

            // the default output format for `.toString()` and `field` value
            format: 'YYYY-MM-DD',

            // the toString function which gets passed a current date object and format
            // and returns a string
            toString: null,

            // used to create date object from current input string
            parse: null,

            // the initial date to view when first opened
            defaultDate: null,

            // make the `defaultDate` the initial selected value
            setDefaultDate: false,

            // first day of week (0: Sunday, 1: Monday etc)
            firstDay: 0,

            // the default flag for moment's strict date parsing
            formatStrict: false,

            // the minimum/earliest date that can be selected
            minDate: null,
            // the maximum/latest date that can be selected
            maxDate: null,

            // number of years either side, or array of upper/lower range
            yearRange: 10,

            // show week numbers at head of row
            showWeekNumber: false,

            // Week picker mode
            pickWholeWeek: false,

            // used internally (don't config outside)
            minYear: 0,
            maxYear: 9999,
            minMonth: undefined,
            maxMonth: undefined,

            startRange: null,
            endRange: null,

            isRTL: false,

            // Additional text to append to the year in the calendar title
            yearSuffix: '',

            // Render the month after year in the calendar title
            showMonthAfterYear: false,

            // Render days of the calendar grid that fall in the next or previous month
            showDaysInNextAndPreviousMonths: false,

            // Allows user to select days that fall in the next or previous month
            enableSelectionDaysInNextAndPreviousMonths: false,

            // how many months are visible
            numberOfMonths: 1,

            // when numberOfMonths is used, this will help you to choose where the main calendar will be (default `left`, can be set to `right`)
            // only used for the first display or when a selected date is not visible
            mainCalendar: 'left',

            // Specify a DOM element to render the calendar in
            container: undefined,

            // Blur field when date is selected
            blurFieldOnSelect : true,

            // internationalization
            i18n: {
                previousMonth : 'Previous Month',
                nextMonth     : 'Next Month',
                months        : ['January','February','March','April','May','June','July','August','September','October','November','December'],
                weekdays      : ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
                weekdaysShort : ['Sun','Mon','Tue','Wed','Thu','Fri','Sat']
            },

            // Theme Classname
            theme: null,

            // events array
            events: [],

            // callback function
            onSelect: null,
            onOpen: null,
            onClose: null,
            onDraw: null,

            // Enable keyboard input
            keyboardInput: true
        },


        /**
         * templating functions to abstract HTML rendering
         */
        renderDayName = function(opts, day, abbr)
        {
            day += opts.firstDay;
            while (day >= 7) {
                day -= 7;
            }
            return abbr ? opts.i18n.weekdaysShort[day] : opts.i18n.weekdays[day];
        },

        renderDay = function(opts)
        {
            var arr = [];
            var ariaSelected = 'false';
            if (opts.isEmpty) {
                if (opts.showDaysInNextAndPreviousMonths) {
                    arr.push('is-outside-current-month');

                    if(!opts.enableSelectionDaysInNextAndPreviousMonths) {
                        arr.push('is-selection-disabled');
                    }

                } else {
                    return '<td class="is-empty"></td>';
                }
            }
            if (opts.isDisabled) {
                arr.push('is-disabled');
            }
            if (opts.isToday) {
                arr.push('is-today');
            }
            if (opts.isSelected) {
                arr.push('is-selected');
                ariaSelected = 'true';
            }
            if (opts.hasEvent) {
                arr.push('has-event');
            }
            if (opts.isInRange) {
                arr.push('is-inrange');
            }
            if (opts.isStartRange) {
                arr.push('is-startrange');
            }
            if (opts.isEndRange) {
                arr.push('is-endrange');
            }
            return '<td data-day="' + opts.day + '" class="' + arr.join(' ') + '" aria-selected="' + ariaSelected + '">' +
                '<button class="pika-button pika-day" type="button" ' +
                'data-pika-year="' + opts.year + '" data-pika-month="' + opts.month + '" data-pika-day="' + opts.day + '">' +
                opts.day +
                '</button>' +
                '</td>';
        },

        isoWeek = function(date) {
            // Ensure we're at the start of the day.
            date.setHours(0, 0, 0, 0);

            // Thursday in current week decides the year because January 4th
            // is always in the first week according to ISO8601.

            var yearDay        = date.getDate()
                , weekDay        = date.getDay()
                , dayInFirstWeek = 4 // January 4th
                , dayShift       = dayInFirstWeek - 1 // counting starts at 0
                , daysPerWeek    = 7
                , prevWeekDay    = function(day) { return (day + daysPerWeek - 1) % daysPerWeek; }
            ;

            // Adjust to Thursday in week 1 and count number of weeks from date to week 1.

            date.setDate(yearDay + dayShift - prevWeekDay(weekDay));

            var jan4th      = new Date(date.getFullYear(), 0, dayInFirstWeek)
                , msPerDay    = 24 * 60 * 60 * 1000
                , daysBetween = (date.getTime() - jan4th.getTime()) / msPerDay
                , weekNum     = 1 + Math.round((daysBetween - dayShift + prevWeekDay(jan4th.getDay())) / daysPerWeek)
            ;

            return weekNum;
        },

        renderWeek = function (d, m, y) {
            var date = new Date(y, m, d)
                , week = hasMoment ? moment(date).isoWeek() : isoWeek(date)
            ;

            return '<td class="pika-week">' + week + '</td>';
        },

        renderRow = function(days, isRTL, pickWholeWeek, isRowSelected)
        {
            return '<tr class="pika-row' + (pickWholeWeek ? ' pick-whole-week' : '') + (isRowSelected ? ' is-selected' : '') + '">' + (isRTL ? days.reverse() : days).join('') + '</tr>';
        },

        renderBody = function(rows)
        {
            return '<tbody>' + rows.join('') + '</tbody>';
        },

        renderHead = function(opts)
        {
            var i, arr = [];
            if (opts.showWeekNumber) {
                arr.push('<th></th>');
            }
            for (i = 0; i < 7; i++) {
                arr.push('<th scope="col"><abbr title="' + renderDayName(opts, i) + '">' + renderDayName(opts, i, true) + '</abbr></th>');
            }
            return '<thead><tr>' + (opts.isRTL ? arr.reverse() : arr).join('') + '</tr></thead>';
        },

        renderTitle = function(instance, c, year, month, refYear, randId)
        {
            var i, j, arr,
                opts = instance._o,
                isMinYear = year === opts.minYear,
                isMaxYear = year === opts.maxYear,
                html = '<div id="' + randId + '" class="pika-title" role="heading" aria-live="assertive">',
                monthHtml,
                yearHtml,
                prev = true,
                next = true;

            for (arr = [], i = 0; i < 12; i++) {
                arr.push('<option value="' + (year === refYear ? i - c : 12 + i - c) + '"' +
                    (i === month ? ' selected="selected"': '') +
                    ((isMinYear && i < opts.minMonth) || (isMaxYear && i > opts.maxMonth) ? ' disabled="disabled"' : '') + '>' +
                    opts.i18n.months[i] + '</option>');
            }

            monthHtml = '<div class="pika-label">' + opts.i18n.months[month] + '<select class="pika-select pika-select-month" tabindex="-1">' + arr.join('') + '</select></div>';

            if (isArray(opts.yearRange)) {
                i = opts.yearRange[0];
                j = opts.yearRange[1] + 1;
            } else {
                i = year - opts.yearRange;
                j = 1 + year + opts.yearRange;
            }

            for (arr = []; i < j && i <= opts.maxYear; i++) {
                if (i >= opts.minYear) {
                    arr.push('<option value="' + i + '"' + (i === year ? ' selected="selected"': '') + '>' + (i) + '</option>');
                }
            }
            yearHtml = '<div class="pika-label">' + year + opts.yearSuffix + '<select class="pika-select pika-select-year" tabindex="-1">' + arr.join('') + '</select></div>';

            if (opts.showMonthAfterYear) {
                html += yearHtml + monthHtml;
            } else {
                html += monthHtml + yearHtml;
            }

            if (isMinYear && (month === 0 || opts.minMonth >= month)) {
                prev = false;
            }

            if (isMaxYear && (month === 11 || opts.maxMonth <= month)) {
                next = false;
            }

            if (c === 0) {
                html += '<button class="pika-prev' + (prev ? '' : ' is-disabled') + '" type="button">' + opts.i18n.previousMonth + '</button>';
            }
            if (c === (instance._o.numberOfMonths - 1) ) {
                html += '<button class="pika-next' + (next ? '' : ' is-disabled') + '" type="button">' + opts.i18n.nextMonth + '</button>';
            }

            return html += '</div>';
        },

        renderTable = function(opts, data, randId)
        {
            return '<table cellpadding="0" cellspacing="0" class="pika-table" role="grid" aria-labelledby="' + randId + '">' + renderHead(opts) + renderBody(data) + '</table>';
        },


        /**
         * Pikaday constructor
         */
        Pikaday = function(options)
        {
            var self = this,
                opts = self.config(options);

            self._onMouseDown = function(e)
            {
                if (!self._v) {
                    return;
                }
                e = e || window.event;
                var target = e.target || e.srcElement;
                if (!target) {
                    return;
                }

                if (!hasClass(target, 'is-disabled')) {
                    if (hasClass(target, 'pika-button') && !hasClass(target, 'is-empty') && !hasClass(target.parentNode, 'is-disabled')) {
                        self.setDate(new Date(target.getAttribute('data-pika-year'), target.getAttribute('data-pika-month'), target.getAttribute('data-pika-day')));
                        if (opts.bound) {
                            sto(function() {
                                self.hide();
                                if (opts.blurFieldOnSelect && opts.field) {
                                    opts.field.blur();
                                }
                            }, 100);
                        }
                    }
                    else if (hasClass(target, 'pika-prev')) {
                        self.prevMonth();
                    }
                    else if (hasClass(target, 'pika-next')) {
                        self.nextMonth();
                    }
                }
                if (!hasClass(target, 'pika-select')) {
                    // if this is touch event prevent mouse events emulation
                    if (e.preventDefault) {
                        e.preventDefault();
                    } else {
                        e.returnValue = false;
                        return false;
                    }
                } else {
                    self._c = true;
                }
            };

            self._onChange = function(e)
            {
                e = e || window.event;
                var target = e.target || e.srcElement;
                if (!target) {
                    return;
                }
                if (hasClass(target, 'pika-select-month')) {
                    self.gotoMonth(target.value);
                }
                else if (hasClass(target, 'pika-select-year')) {
                    self.gotoYear(target.value);
                }
            };

            self._onKeyChange = function(e)
            {
                e = e || window.event;

                if (self.isVisible()) {

                    switch(e.keyCode){
                        case 13:
                        case 27:
                            if (opts.field) {
                                opts.field.blur();
                            }
                            break;
                        case 37:
                            self.adjustDate('subtract', 1);
                            break;
                        case 38:
                            self.adjustDate('subtract', 7);
                            break;
                        case 39:
                            self.adjustDate('add', 1);
                            break;
                        case 40:
                            self.adjustDate('add', 7);
                            break;
                        case 8:
                        case 46:
                            self.setDate(null);
                            break;
                    }
                }
            };

            self._parseFieldValue = function()
            {
                if (opts.parse) {
                    return opts.parse(opts.field.value, opts.format);
                } else if (hasMoment) {
                    var date = moment(opts.field.value, opts.format, opts.formatStrict);
                    return (date && date.isValid()) ? date.toDate() : null;
                } else {
                    return new Date(Date.parse(opts.field.value));
                }
            };

            self._onInputChange = function(e)
            {
                var date;

                if (e.firedBy === self) {
                    return;
                }
                date = self._parseFieldValue();
                if (isDate(date)) {
                    self.setDate(date);
                }
                if (!self._v) {
                    self.show();
                }
            };

            self._onInputFocus = function()
            {
                self.show();
            };

            self._onInputClick = function()
            {
                self.show();
            };

            self._onInputBlur = function()
            {
                // IE allows pika div to gain focus; catch blur the input field
                var pEl = document.activeElement;
                do {
                    if (hasClass(pEl, 'pika-single')) {
                        return;
                    }
                }
                while ((pEl = pEl.parentNode));

                if (!self._c) {
                    self._b = sto(function() {
                        self.hide();
                    }, 50);
                }
                self._c = false;
            };

            self._onClick = function(e)
            {
                e = e || window.event;
                var target = e.target || e.srcElement,
                    pEl = target;
                if (!target) {
                    return;
                }
                if (!hasEventListeners && hasClass(target, 'pika-select')) {
                    if (!target.onchange) {
                        target.setAttribute('onchange', 'return;');
                        addEvent(target, 'change', self._onChange);
                    }
                }
                do {
                    if (hasClass(pEl, 'pika-single') || pEl === opts.trigger) {
                        return;
                    }
                }
                while ((pEl = pEl.parentNode));
                if (self._v && target !== opts.trigger && pEl !== opts.trigger) {
                    self.hide();
                }
            };

            self.el = document.createElement('div');
            self.el.className = 'pika-single' + (opts.isRTL ? ' is-rtl' : '') + (opts.theme ? ' ' + opts.theme : '');

            addEvent(self.el, 'mousedown', self._onMouseDown, true);
            addEvent(self.el, 'touchend', self._onMouseDown, true);
            addEvent(self.el, 'change', self._onChange);

            if (opts.keyboardInput) {
                addEvent(document, 'keydown', self._onKeyChange);
            }

            if (opts.field) {
                if (opts.container) {
                    opts.container.appendChild(self.el);
                } else if (opts.bound) {
                    document.body.appendChild(self.el);
                } else {
                    opts.field.parentNode.insertBefore(self.el, opts.field.nextSibling);
                }
                addEvent(opts.field, 'change', self._onInputChange);

                if (!opts.defaultDate) {
                    opts.defaultDate = self._parseFieldValue();
                    opts.setDefaultDate = true;
                }
            }

            var defDate = opts.defaultDate;

            if (isDate(defDate)) {
                if (opts.setDefaultDate) {
                    self.setDate(defDate, true);
                } else {
                    self.gotoDate(defDate);
                }
            } else {
                self.gotoDate(new Date());
            }

            if (opts.bound) {
                this.hide();
                self.el.className += ' is-bound';
                addEvent(opts.trigger, 'click', self._onInputClick);
                addEvent(opts.trigger, 'focus', self._onInputFocus);
                addEvent(opts.trigger, 'blur', self._onInputBlur);
            } else {
                this.show();
            }
        };


    /**
     * public Pikaday API
     */
    Pikaday.prototype = {


        /**
         * configure functionality
         */
        config: function(options)
        {
            if (!this._o) {
                this._o = extend({}, defaults, true);
            }

            var opts = extend(this._o, options, true);

            opts.isRTL = !!opts.isRTL;

            opts.field = (opts.field && opts.field.nodeName) ? opts.field : null;

            opts.theme = (typeof opts.theme) === 'string' && opts.theme ? opts.theme : null;

            opts.bound = !!(opts.bound !== undefined ? opts.field && opts.bound : opts.field);

            opts.trigger = (opts.trigger && opts.trigger.nodeName) ? opts.trigger : opts.field;

            opts.disableWeekends = !!opts.disableWeekends;

            opts.disableDayFn = (typeof opts.disableDayFn) === 'function' ? opts.disableDayFn : null;

            var nom = parseInt(opts.numberOfMonths, 10) || 1;
            opts.numberOfMonths = nom > 4 ? 4 : nom;

            if (!isDate(opts.minDate)) {
                opts.minDate = false;
            }
            if (!isDate(opts.maxDate)) {
                opts.maxDate = false;
            }
            if ((opts.minDate && opts.maxDate) && opts.maxDate < opts.minDate) {
                opts.maxDate = opts.minDate = false;
            }
            if (opts.minDate) {
                this.setMinDate(opts.minDate);
            }
            if (opts.maxDate) {
                this.setMaxDate(opts.maxDate);
            }

            if (isArray(opts.yearRange)) {
                var fallback = new Date().getFullYear() - 10;
                opts.yearRange[0] = parseInt(opts.yearRange[0], 10) || fallback;
                opts.yearRange[1] = parseInt(opts.yearRange[1], 10) || fallback;
            } else {
                opts.yearRange = Math.abs(parseInt(opts.yearRange, 10)) || defaults.yearRange;
                if (opts.yearRange > 100) {
                    opts.yearRange = 100;
                }
            }

            return opts;
        },

        /**
         * return a formatted string of the current selection (using Moment.js if available)
         */
        toString: function(format)
        {
            format = format || this._o.format;
            if (!isDate(this._d)) {
                return '';
            }
            if (this._o.toString) {
                return this._o.toString(this._d, format);
            }
            if (hasMoment) {
                return moment(this._d).format(format);
            }
            return this._d.toDateString();
        },

        /**
         * return a Moment.js object of the current selection (if available)
         */
        getMoment: function()
        {
            return hasMoment ? moment(this._d) : null;
        },

        /**
         * set the current selection from a Moment.js object (if available)
         */
        setMoment: function(date, preventOnSelect)
        {
            if (hasMoment && moment.isMoment(date)) {
                this.setDate(date.toDate(), preventOnSelect);
            }
        },

        /**
         * return a Date object of the current selection
         */
        getDate: function()
        {
            return isDate(this._d) ? new Date(this._d.getTime()) : null;
        },

        /**
         * set the current selection
         */
        setDate: function(date, preventOnSelect)
        {
            if (!date) {
                this._d = null;

                if (this._o.field) {
                    this._o.field.value = '';
                    fireEvent(this._o.field, 'change', { firedBy: this });
                }

                return this.draw();
            }
            if (typeof date === 'string') {
                date = new Date(Date.parse(date));
            }
            if (!isDate(date)) {
                return;
            }

            var min = this._o.minDate,
                max = this._o.maxDate;

            if (isDate(min) && date < min) {
                date = min;
            } else if (isDate(max) && date > max) {
                date = max;
            }

            this._d = new Date(date.getTime());
            setToStartOfDay(this._d);
            this.gotoDate(this._d);

            if (this._o.field) {
                this._o.field.value = this.toString();
                fireEvent(this._o.field, 'change', { firedBy: this });
            }
            if (!preventOnSelect && typeof this._o.onSelect === 'function') {
                this._o.onSelect.call(this, this.getDate());
            }
        },

        /**
         * clear and reset the date
         */
        clear: function()
        {
            this.setDate(null);
        },

        /**
         * change view to a specific date
         */
        gotoDate: function(date)
        {
            var newCalendar = true;

            if (!isDate(date)) {
                return;
            }

            if (this.calendars) {
                var firstVisibleDate = new Date(this.calendars[0].year, this.calendars[0].month, 1),
                    lastVisibleDate = new Date(this.calendars[this.calendars.length-1].year, this.calendars[this.calendars.length-1].month, 1),
                    visibleDate = date.getTime();
                // get the end of the month
                lastVisibleDate.setMonth(lastVisibleDate.getMonth()+1);
                lastVisibleDate.setDate(lastVisibleDate.getDate()-1);
                newCalendar = (visibleDate < firstVisibleDate.getTime() || lastVisibleDate.getTime() < visibleDate);
            }

            if (newCalendar) {
                this.calendars = [{
                    month: date.getMonth(),
                    year: date.getFullYear()
                }];
                if (this._o.mainCalendar === 'right') {
                    this.calendars[0].month += 1 - this._o.numberOfMonths;
                }
            }

            this.adjustCalendars();
        },

        adjustDate: function(sign, days) {

            var day = this.getDate() || new Date();
            var difference = parseInt(days)*24*60*60*1000;

            var newDay;

            if (sign === 'add') {
                newDay = new Date(day.valueOf() + difference);
            } else if (sign === 'subtract') {
                newDay = new Date(day.valueOf() - difference);
            }

            this.setDate(newDay);
        },

        adjustCalendars: function() {
            this.calendars[0] = adjustCalendar(this.calendars[0]);
            for (var c = 1; c < this._o.numberOfMonths; c++) {
                this.calendars[c] = adjustCalendar({
                    month: this.calendars[0].month + c,
                    year: this.calendars[0].year
                });
            }
            this.draw();
        },

        gotoToday: function()
        {
            this.gotoDate(new Date());
        },

        /**
         * change view to a specific month (zero-index, e.g. 0: January)
         */
        gotoMonth: function(month)
        {
            if (!isNaN(month)) {
                this.calendars[0].month = parseInt(month, 10);
                this.adjustCalendars();
            }
        },

        nextMonth: function()
        {
            this.calendars[0].month++;
            this.adjustCalendars();
        },

        prevMonth: function()
        {
            this.calendars[0].month--;
            this.adjustCalendars();
        },

        /**
         * change view to a specific full year (e.g. "2012")
         */
        gotoYear: function(year)
        {
            if (!isNaN(year)) {
                this.calendars[0].year = parseInt(year, 10);
                this.adjustCalendars();
            }
        },

        /**
         * change the minDate
         */
        setMinDate: function(value)
        {
            if(value instanceof Date) {
                setToStartOfDay(value);
                this._o.minDate = value;
                this._o.minYear  = value.getFullYear();
                this._o.minMonth = value.getMonth();
            } else {
                this._o.minDate = defaults.minDate;
                this._o.minYear  = defaults.minYear;
                this._o.minMonth = defaults.minMonth;
                this._o.startRange = defaults.startRange;
            }

            this.draw();
        },

        /**
         * change the maxDate
         */
        setMaxDate: function(value)
        {
            if(value instanceof Date) {
                setToStartOfDay(value);
                this._o.maxDate = value;
                this._o.maxYear = value.getFullYear();
                this._o.maxMonth = value.getMonth();
            } else {
                this._o.maxDate = defaults.maxDate;
                this._o.maxYear = defaults.maxYear;
                this._o.maxMonth = defaults.maxMonth;
                this._o.endRange = defaults.endRange;
            }

            this.draw();
        },

        setStartRange: function(value)
        {
            this._o.startRange = value;
        },

        setEndRange: function(value)
        {
            this._o.endRange = value;
        },

        /**
         * refresh the HTML
         */
        draw: function(force)
        {
            if (!this._v && !force) {
                return;
            }
            var opts = this._o,
                minYear = opts.minYear,
                maxYear = opts.maxYear,
                minMonth = opts.minMonth,
                maxMonth = opts.maxMonth,
                html = '',
                randId;

            if (this._y <= minYear) {
                this._y = minYear;
                if (!isNaN(minMonth) && this._m < minMonth) {
                    this._m = minMonth;
                }
            }
            if (this._y >= maxYear) {
                this._y = maxYear;
                if (!isNaN(maxMonth) && this._m > maxMonth) {
                    this._m = maxMonth;
                }
            }

            for (var c = 0; c < opts.numberOfMonths; c++) {
                randId = 'pika-title-' + Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 2);
                html += '<div class="pika-lendar">' + renderTitle(this, c, this.calendars[c].year, this.calendars[c].month, this.calendars[0].year, randId) + this.render(this.calendars[c].year, this.calendars[c].month, randId) + '</div>';
            }

            this.el.innerHTML = html;

            if (opts.bound) {
                if(opts.field.type !== 'hidden') {
                    sto(function() {
                        opts.trigger.focus();
                    }, 1);
                }
            }

            if (typeof this._o.onDraw === 'function') {
                this._o.onDraw(this);
            }

            if (opts.bound) {
                // let the screen reader user know to use arrow keys
                opts.field.setAttribute('aria-label', opts.ariaLabel);
            }
        },

        adjustPosition: function()
        {
            var field, pEl, width, height, viewportWidth, viewportHeight, scrollTop, left, top, clientRect, leftAligned, bottomAligned;

            if (this._o.container) return;

            this.el.style.position = 'absolute';

            field = this._o.trigger;
            pEl = field;
            width = this.el.offsetWidth;
            height = this.el.offsetHeight;
            viewportWidth = window.innerWidth || document.documentElement.clientWidth;
            viewportHeight = window.innerHeight || document.documentElement.clientHeight;
            scrollTop = window.pageYOffset || document.body.scrollTop || document.documentElement.scrollTop;
            leftAligned = true;
            bottomAligned = true;

            if (typeof field.getBoundingClientRect === 'function') {
                clientRect = field.getBoundingClientRect();
                left = clientRect.left + window.pageXOffset;
                top = clientRect.bottom + window.pageYOffset;
            } else {
                left = pEl.offsetLeft;
                top  = pEl.offsetTop + pEl.offsetHeight;
                while((pEl = pEl.offsetParent)) {
                    left += pEl.offsetLeft;
                    top  += pEl.offsetTop;
                }
            }

            // default position is bottom & left
            if ((this._o.reposition && left + width > viewportWidth) ||
                (
                    this._o.position.indexOf('right') > -1 &&
                    left - width + field.offsetWidth > 0
                )
            ) {
                left = left - width + field.offsetWidth;
                leftAligned = false;
            }
            if ((this._o.reposition && top + height > viewportHeight + scrollTop) ||
                (
                    this._o.position.indexOf('top') > -1 &&
                    top - height - field.offsetHeight > 0
                )
            ) {
                top = top - height - field.offsetHeight;
                bottomAligned = false;
            }

            this.el.style.left = left + 'px';
            this.el.style.top = top + 'px';

            addClass(this.el, leftAligned ? 'left-aligned' : 'right-aligned');
            addClass(this.el, bottomAligned ? 'bottom-aligned' : 'top-aligned');
            removeClass(this.el, !leftAligned ? 'left-aligned' : 'right-aligned');
            removeClass(this.el, !bottomAligned ? 'bottom-aligned' : 'top-aligned');
        },

        /**
         * render HTML for a particular month
         */
        render: function(year, month, randId)
        {
            var opts   = this._o,
                now    = new Date(),
                days   = getDaysInMonth(year, month),
                before = new Date(year, month, 1).getDay(),
                data   = [],
                row    = [];
            setToStartOfDay(now);
            if (opts.firstDay > 0) {
                before -= opts.firstDay;
                if (before < 0) {
                    before += 7;
                }
            }
            var previousMonth = month === 0 ? 11 : month - 1,
                nextMonth = month === 11 ? 0 : month + 1,
                yearOfPreviousMonth = month === 0 ? year - 1 : year,
                yearOfNextMonth = month === 11 ? year + 1 : year,
                daysInPreviousMonth = getDaysInMonth(yearOfPreviousMonth, previousMonth);
            var cells = days + before,
                after = cells;
            while(after > 7) {
                after -= 7;
            }
            cells += 7 - after;
            var isWeekSelected = false;
            for (var i = 0, r = 0; i < cells; i++)
            {
                var day = new Date(year, month, 1 + (i - before)),
                    isSelected = isDate(this._d) ? compareDates(day, this._d) : false,
                    isToday = compareDates(day, now),
                    hasEvent = opts.events.indexOf(day.toDateString()) !== -1 ? true : false,
                    isEmpty = i < before || i >= (days + before),
                    dayNumber = 1 + (i - before),
                    monthNumber = month,
                    yearNumber = year,
                    isStartRange = opts.startRange && compareDates(opts.startRange, day),
                    isEndRange = opts.endRange && compareDates(opts.endRange, day),
                    isInRange = opts.startRange && opts.endRange && opts.startRange < day && day < opts.endRange,
                    isDisabled = (opts.minDate && day < opts.minDate) ||
                        (opts.maxDate && day > opts.maxDate) ||
                        (opts.disableWeekends && isWeekend(day)) ||
                        (opts.disableDayFn && opts.disableDayFn(day));

                if (isEmpty) {
                    if (i < before) {
                        dayNumber = daysInPreviousMonth + dayNumber;
                        monthNumber = previousMonth;
                        yearNumber = yearOfPreviousMonth;
                    } else {
                        dayNumber = dayNumber - days;
                        monthNumber = nextMonth;
                        yearNumber = yearOfNextMonth;
                    }
                }

                var dayConfig = {
                    day: dayNumber,
                    month: monthNumber,
                    year: yearNumber,
                    hasEvent: hasEvent,
                    isSelected: isSelected,
                    isToday: isToday,
                    isDisabled: isDisabled,
                    isEmpty: isEmpty,
                    isStartRange: isStartRange,
                    isEndRange: isEndRange,
                    isInRange: isInRange,
                    showDaysInNextAndPreviousMonths: opts.showDaysInNextAndPreviousMonths,
                    enableSelectionDaysInNextAndPreviousMonths: opts.enableSelectionDaysInNextAndPreviousMonths
                };

                if (opts.pickWholeWeek && isSelected) {
                    isWeekSelected = true;
                }

                row.push(renderDay(dayConfig));

                if (++r === 7) {
                    if (opts.showWeekNumber) {
                        row.unshift(renderWeek(i - before, month, year));
                    }
                    data.push(renderRow(row, opts.isRTL, opts.pickWholeWeek, isWeekSelected));
                    row = [];
                    r = 0;
                    isWeekSelected = false;
                }
            }
            return renderTable(opts, data, randId);
        },

        isVisible: function()
        {
            return this._v;
        },

        show: function()
        {
            if (!this.isVisible()) {
                this._v = true;
                this.draw();
                removeClass(this.el, 'is-hidden');
                if (this._o.bound) {
                    addEvent(document, 'click', this._onClick);
                    this.adjustPosition();
                }
                if (typeof this._o.onOpen === 'function') {
                    this._o.onOpen.call(this);
                }
            }
        },

        hide: function()
        {
            var v = this._v;
            if (v !== false) {
                if (this._o.bound) {
                    removeEvent(document, 'click', this._onClick);
                }
                this.el.style.position = 'static'; // reset
                this.el.style.left = 'auto';
                this.el.style.top = 'auto';
                addClass(this.el, 'is-hidden');
                this._v = false;
                if (v !== undefined && typeof this._o.onClose === 'function') {
                    this._o.onClose.call(this);
                }
            }
        },

        /**
         * GAME OVER
         */
        destroy: function()
        {
            var opts = this._o;

            this.hide();
            removeEvent(this.el, 'mousedown', this._onMouseDown, true);
            removeEvent(this.el, 'touchend', this._onMouseDown, true);
            removeEvent(this.el, 'change', this._onChange);
            if (opts.keyboardInput) {
                removeEvent(document, 'keydown', this._onKeyChange);
            }
            if (opts.field) {
                removeEvent(opts.field, 'change', this._onInputChange);
                if (opts.bound) {
                    removeEvent(opts.trigger, 'click', this._onInputClick);
                    removeEvent(opts.trigger, 'focus', this._onInputFocus);
                    removeEvent(opts.trigger, 'blur', this._onInputBlur);
                }
            }
            if (this.el.parentNode) {
                this.el.parentNode.removeChild(this.el);
            }
        }

    };

    return Pikaday;
}));
var dt = window.dt || {};

(function ($) {

    dt.defaultConfig = {
        baseUrl: 'http://127.0.0.1:8000',
        popupPath: '/show',
        popupStore:'/store',
        cssPath: '/whitelabel/tui/css/layer/layer.css'
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
    var TuiIBETripDataDecoderMobile = $.extend({}, dt.AbstractTripDataDecoder, {
        name: 'TUI Rundreisen Mobile',
        matchesUrl: 'm.tui.com/(buchen)',
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

    var TuiIBETripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        decodeDate: function (raw) {
            var r = /\w+\.\s+(\d+\.\d+.\d+)/.exec(raw);

            if (r === null || r.length !== 2) {
                return null;
            }

            return r[1];
        },
        name: 'TUI IBE',
        matchesUrl: 'www.tui.com/(hotel|pauschalreisen|last-minute)(/[a-z-]+)*/suchen|airtours.de',
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

    var TuiHMTripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        name: 'TUI Honeymoon',
        matchesUrl: 'www.tui.com/pauschalreisen(/[a-z-]+)*/flitterwochen',
        filterFormSelector: 'body',
        filterDataDecoders: {},
        getTripData: function () {
            return {
                is_popup_allowed: true
            };
        },
        getRandomElement: function (arr) {
            return arr[Math.floor(Math.random() * arr.length)];
        },
        getVariant: function () {
            if(isMobile()){
                return 'eil-mobile';
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

    var KwizzmeFakeTripDataDecoder = $.extend({}, dt.AbstractTripDataDecoder, {
        name: 'DesireTec WL',
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
    dt.decoders.push(TuiIBETripDataDecoder);
    dt.decoders.push(TuiIBETripDataDecoderMobile);
    dt.decoders.push(KwizzmeFakeTripDataDecoder);
    dt.decoders.push(TuiHMTripDataDecoder);

    //dt.decoders.push($.extend({}, TuiIBETripDataDecoder, {
    //    name: 'TUI Landingpages',
    //    matchesUrl: 'tui.com/pauschalreisen',
    //    filterFormSelector: '.simpleSearch'
    //}));

   /* dt.initCallbacks = dt.initCallbacks || [];
    dt.initCallbacks.push(function (popup) {
        dt.exitIntent = ExitIntent(function () {
            popup.show();
        }, {
            oneTime: true,
            useTopDist: true,
            useMouseLeave: true,
            useAccel: true,
            useCookie: !window.dt.debug,
            manualCookie: true,
            excludeLeftPixels: 120,
            cookieOptions: {
                path: '/'
            }
        });
    });*/


    dt.PopupManager.closePopup = function(event) {
        event.preventDefault();

        if(isMobile()){
            var formSent = $('.kwp-content').hasClass('kwp-completed-tui');

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
        dt.Tracking.init('tui_exitwindow','UA-105970361-1');

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

                if (val) {
                    $('.kwp-content').addClass('kwp-show-ages');
                } else {
                    $('.kwp-content').removeClass('kwp-show-ages');
                }

                var i;

                for (i = 1; i <= 3; ++i) {

                    if (i <= val) {
                        $(age + i).closest('.kwp-custom-select').show();
                    } else {
                        $(age + i).val('').closest('.kwp-custom-select').hide();
                    }

                    if(i == val){
                        $(age + i).closest('.kwp-col-3').addClass('last');
                    }else{
                        $(age + i).closest('.kwp-col-3').removeClass('last');
                    }
                }

            }

            $(children).on('change keydown blur', update);
            update();
        })(jQuery, '#children', '#age_');
    };

    dt.hotelStars = function () {
        function restoreValue() {
            var val = $('#hotel_category').val();

            if (!val) {
                val = 0;
            }

            highlight(parseInt(val));
        }

        function setValue(val) {
            $('#hotel_category').val(val);
            restoreValue(val);
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
        }

        $('.kwp-star-input .kwp-star').hover(function () {
            highlight(parseInt($(this).attr('data-val')));
        }).click(function () {
            setValue(parseInt($(this).attr('data-val')));
        });

        $('.kwp-star-input').mouseout(function () {
            restoreValue();
        });

        restoreValue();
    };


    dt.agbModal = function (e) {
        e && e.preventDefault();

        var element = null;


        var data_agb = '<section id="c45306" class="csc-default csc-content-text"> <header> <h2 class="csc-header">Bedingungen für die Nutzung des TUI Reisewunschportals</h2></header> <h3>1. Funktion des TUI Reisewunschportals, Nutzungsbedingungen</h3> <p><b>1.1.</b> Die TUI Deutschland GmbH (im Folgenden „TUI“) bietet über das Online-Tool „TUI Reisewunschportal“ (im Folgenden „System") unentgeltlich die technische Möglichkeit, Suchanzeigen nach Reiseangeboten („Reisewünsche“) aufzugeben und so persönlichen Kontakt zu Reiseberatern in teilnehmenden Reisebüros (Filialen und Partneragenturen [andere Legal Entity] der TUI Deutschland GmbH) zum Zwecke einer individuellen Kommunikation herzustellen. </p><p><b>1.2</b>. Für die Nutzung des Systems gelten diese Nutzungsbedingungen, die nach Maßgabe von Ziff. 9.1 geändert werden können. </p><h3>2. Anmeldung</h3> <p><b>2.1. </b> Das System ist über ein entsprechendes Dialogfeld auf der Website www.TUI.com sowie über www.TUI-reisewunsch.com zu erreichen. Die Nutzung des Systems setzt die Anmeldung als Nutzer voraus. </p><p><b>2.2. </b> Die Anmeldung ist nur volljährigen und unbeschränkt geschäftsfähigen Personen gestattet.</p><p><b>2.3. &nbsp;&nbsp;</b>Die Anmeldung erfolgt durch Einsendung der E-Mailadresse sowie des Reisewunsches und ggf. weiterer Suchkriterien (alles zusammenfassend: „Nutzerdaten“) sowie Akzeptanz dieser Nutzungsbedingungen über das Dialogfeld. Sie wird durch Zusendung einer Bestätigungsmail mit einem individuellen Zugangslink durch TUI Deutschland an die angegebene E-Mail-Adresse abgeschlossen. Es besteht kein Anspruch des Nutzers auf Einstellen von Inhalten.</p><p><b>2.4</b>. Über den Zugangslink kann der Nutzer seine Anfrage, einschließlich der Nutzerdaten, im System jederzeit einsehen, anpassen oder durch Betätigung einer entsprechenden Schaltfläche deaktivieren. Passt der Nutzer den Reisewunsch an oder deaktiviert ihn, verschickt das System eine entsprechende Info-Mail an ihn.</p><p><b>2.6</b>. TUI Deutschland überprüft grundsätzlich nicht die Richtigkeit der Nutzerdaten</p><p><b>2.7.</b> TUI behält sich das Recht vor, nach alleinigem Ermessen und ohne Ankündigung den Zugang von Nutzern zum System oder dessen Teilen zu verweigern und/oder den Betrieb des Systems einzustellen.</p><h3>&nbsp;</h3> <h3>3. Reisewünsche, Bearbeitung</h3> <p><b>3.1.</b> Ein Reisewunsch stellt grundsätzlich nur eine unverbindliche Anfrage und kein rechtlich bindendes Angebot dar. </p><p><b>3.2. </b> Die in das System eingegebenen Reisewünsche der Nutzer werden durch das System an ein teilnehmendes, mit TUI Deutschland kooperierendes Reisebüro weitergeleitet, das sich vorher im TUI Reisewunschportal registriert hat und nach eigener Angabe über besondere Kompetenz für das betreffende Zielgebiet verfügt. Die Verteilung erfolgt automatisiert nach den Kriterien: 1. Standort des Nutzers, 2. Expertise eines Reisebüros für das jeweilige Zielgebiet.</p><p><b>3.3.</b> Die Reisewünsche werden nicht veröffentlicht.</p><p><b>3.4.</b> Reisebüros können auf einen Reisewunsch mit einem Angebotsvorschlag gegenüber dem Nutzer reagieren. Auch dieser Vorschlag ist grundsätzlich rechtlich unverbindlich, soweit darin nichts anderes bestimmt ist </p><p><b>3.5.</b> Nachdem ein Reisebüro eine Anfrage bearbeitet und das Ergebnis (Nachfrage bzw. Angebot) in das System eingestellt hat, bekommt der Nutzer eine E-Mail, in der erneut ein Link zu der Anfrage und dem Feedback/ Angebot enthalten ist </p><p><b>3.6.</b> Der Nutzer, welcher den Reisewunsch eingestellt hat, kann auf den Vorschlag hin das Reisebüro kontaktieren. Er ist jedoch nicht verpflichtet, auf einen Vorschlag zu reagieren.</p><p><b>3.7.</b> Der Nutzer kann wählen, über welchen Weg (E-Mail, Telefon, persönlich vor Ort) er weiter mit dem Reisebüro kommunizieren möchte. Solange der Nutzer dem Reisebüro keine Kontaktdaten für einen Direktkontakt mitteilt, erfolgt die beschriebene Kommunikation zwischen Nutzer und Reisebüro ausschließlich über das System als Absender von Nachrichten in beide Richtungen. </p><h3>&nbsp;</h3> <h3>4. Rechtbeziehungen</h3> <p><b>4.1.</b> Die Leistung von TUI Deutschland im Rahmen des Systems ist allein die Übermittlung der Nachrichten zwischen den Nutzern und den Reisebüros. Für die Systembereitstellung können Erfüllungsgehilfen eingesetzt werden. </p><p><b>4.2.</b> Sofern infolge der Nutzung des Systems ein Kontakt zwischen dem Nutzer und einem Reisebüro zustande kommt, bestehen etwaige daraus resultierende Rechtsbeziehungen ausschließlich zwischen diesen Parteien. TUI Deutschland ist hieran nicht beteiligt. Daher ist TUI Deutschland auch nicht für die Erfüllung von Verträgen, die zwischen den Nutzern und den Reisebüros und/oder von diesen vermittelten Leistungsträgern geschlossen wurden, verantwortlich. </p><h3>&nbsp;</h3> <h3>5. Pflichten des Nutzers, Verantwortung für Inhalte</h3> <p><b>5.1.</b> Der Nutzer ist verpflichtet, den Zugangslink geheim zu halten.</p><p><b>5.2.</b> Der Nutzer ist grundsätzlich für alle über seinen Zugangslink vorgenommenen Aktivitäten verantwortlich. Die Regelungen dieses Absatzes gelten nicht, wenn der Nutzer einen etwaigen Missbrauch seines Zugangslinks nicht zu vertreten hat, weil keine Sorgfaltspflichtverletzung des Nutzers vorliegt. Der Nutzer ist verpflichtet, TUI Deutschland umgehend zu informieren, wenn er Anhaltspunkte für einen Missbrauch seines Zugangslinks durch Dritte hat.</p><p><b>5.3.</b> Der Nutzer ist verpflichtet, bei Einstellung von Reisewünschen und sonstigen Inhalten sämtliche geltenden Rechtsvorschriften, Rechte Dritter und diese Nutzungsbedingungen zu beachten. Er ist für die Rechtmäßigkeit, Richtigkeit und Vollständigkeit aller von ihm eingestellten Inhalte verantwortlich und haftet für die Verletzung von Rechtsvorschriften oder von Rechten Dritter durch von ihm eingestellte Inhalte</p><p><b>5.4.</b> TUI Deutschland überprüft die in das System eingestellten Inhalte der Nutzer grundsätzlich nicht und übernimmt für diese keinerlei Haftung. TUI Deutschland behält sich aber das Recht vor, die Inhalte zu überprüfen, auch wenn dafür eine gesetzliche Verpflichtung nicht besteht.</p><p><b>5.5. </b>Der Nutzer erhält etwaige Informationen über die von ihm im System hinterlegte E-Mail-Adresse. Es obliegt ihm, sicherzustellen, dass er unter dieser E-Mail-Adresse erreichbar ist.</p><h3>&nbsp;</h3> <h3>6. Unzulässige Nutzungshandlungen, Maßnahmen bei Verstößen, Freistellung</h3> <p><b>6.1. </b>Die folgenden Nutzungshandlungen sind unzulässig:</p><ul> <li>&nbsp;das Einstellen von anderen Inhalten als Reisewünschen</li></ul> <ul> <li>das Einstellen von unzulässigen Inhalten; unzulässig sind Inhalte, die gegen diese Nutzungsbedingungen oder gegen gesetzliche Verbote oder die guten Sitten verstoßen (z.B. pornografische, volksverhetzende, rassistische oder verfassungswidrige Inhalte, Gewaltdarstellungen, Drohungen, Nötigungen, Ehrverletzungen oder sonst verwerfliche Inhalte) oder Rechte Dritter (insbesondere Persönlichkeits-, Namensrechte oder Rechte zum Schutze geistigen Eigentums wie z.B. Marken- oder Urheberrechte) verletzen; </li></ul> <ul> <li>die Offenlegung und Weitergabe des Zugangslinks zum System;</li></ul> <ul> <li>das automatische Auslesen der auf dem System befindlichen Daten sowie der Aufbau eigener Suchsysteme, Dienste und Verzeichnisse unter Zuhilfenahme der im System abrufbaren Inhalte sowie das vielfache Erstellen inhaltsgleicher Inhalte; </li></ul> <ul> <li>die Verwendung oder das Aufspielen von Dateien, die Viren, beschädigte Dateien, Software oder sonstige Mechanismen oder Inhalte enthalten, welche das System oder dessen Nutzer, deren Rechner, die Server von TUI Deutschland oder die auf den Rechnern der Nutzer oder von TUI Deutschland verwendete Software ausspionieren, attackieren oder in sonstiger Weise beeinträchtigen könnten. </li></ul> <p><b>6.2.</b> TUI Deutschland kann folgende Maßnahmen ergreifen, wenn konkrete Anhaltspunkte dafür bestehen, dass ein Nutzer gesetzliche Vorschriften, Rechte Dritter, diese Bedingungen verletzt, oder wenn TUI Deutschland ein sonstiges berechtigtes Interesse hat: Löschen von Reisewünschen oder sonstigen Inhalten, Verwarnung des Nutzers, Beschränkung der Nutzungsmöglichkeit des Systems durch den Nutzer, so dass u.a. keine Inhalte mehr eingestellt werden können, Löschung des Nutzerkontos.</p><p><b>6.3.</b> Der Nutzer stellt TUI Deutschland von allen Ansprüchen frei, die von Dritten gegen TUI Deutschland aufgrund einer Verletzung ihrer Rechte geltend gemacht werden, soweit der Nutzer diese Rechtsverletzung zu vertreten hat. Die Freistellung umfasst die Übernahme sämtlicher Gerichtskosten und angemessener Anwaltskosten.</p><p><b>6.4.</b> Der Nutzer wird TUI Deutschland bei der Verteidigung gegen die Inanspruchnahme unterstützen und insbesondere unverzüglich alle Informationen zur Verfügung stellen, die für die Prüfung und Abwehr der Ansprüche von Bedeutung sein können</p><p><b>6.5. </b>TUI Deutschland ist im Fall der berechtigten Geltendmachung von Rechten durch einen Dritten berechtigt, dem Dritten den Namen und die E-Mail-Adresse des Nutzers mitzuteilen</p><p><b>6.6. </b>TUI Deutschland ist zur Geltendmachung weiterer gesetzlicher Rechte im Fall von unzulässigen Nutzungshandlungen berechtigt. </p><h3>&nbsp;</h3> <h3>7. Haftungsbeschränkung</h3> <p><b>7.1.</b> TUI Deutschland übernimmt keine Garantie oder Gewähr für die Verfügbarkeit und Funktion des Systems oder der eingestellten Inhalte. TUI Deutschland behält sich vor, das TUI Reisewunschportal (auch ohne vorherige Ankündigung) ganz oder teilweise einzustellen oder den Zugang hierzu ganz oder teilweise einzuschränken, ohne dass hieraus Ansprüche der Nutzer gegenüber TUI Deutschland entstehen. </p><p><b>7.2.</b> . Für eine Haftung von TUI Deutschland auf Schadensersatz gelten unbeschadet der sonstigen gesetzlichen Anspruchsvoraussetzungen folgende Haftungsausschlüsse und Haftungsbegrenzungen: </p><p><b>7.2.1.</b> TUI Deutschland haftet unbeschränkt, soweit die Schadensursache auf Vorsatz oder grober Fahrlässigkeit beruht. Ferner haftet TUI für die leicht fahrlässige Verletzung von wesentlichen Pflichten, deren Verletzung die Erreichung des Vertragszwecks gefährdet, und für die Verletzung von Pflichten auf deren Einhaltung Vertragspartner regelmäßig vertrauen. In diesem Fall haftet TUI jedoch nur für den vorhersehbaren, vertragstypischen Schaden. TUI Deutschland haftet nicht für die leicht fahrlässige Verletzung anderer als der in den vorstehenden Sätzen genannten Pflichten. </p><p><b>7.2.2.</b> Die vorstehenden Haftungsbeschränkungen gelten nicht bei Verletzung von Leben, Körper und Gesundheit, für einen Mangel nach Übernahme von Beschaffenheitsgarantien für die Beschaffenheit eines Produktes und bei arglistig verschwiegenen Mängeln. Die Haftung nach dem Produkthaftungsgesetz bleibt unberührt. Soweit die Haftung von TUI Deutschland ausgeschlossen oder beschränkt ist, gilt dies auch für die persönliche Haftung ihrer Arbeitnehmer, Vertreter und Erfüllungsgehilfen.</p><h3>&nbsp;</h3> <h3> 8. Nutzung Ihrer Daten innerhalb des Reisewunschportals</h3> <p>Für die TUI ist der Schutz Ihrer Privatsphäre und persönlicher Daten von großer Wichtigkeit. Personenbezogene Daten werden im TUI Reisewunschportal nur dann erhoben, verarbeitet und genutzt, sofern dies gesetzlich erlaubt ist oder Sie uns hierzu Ihre Einwilligung erteilt haben. Die Einwilligung erfolgt durch die Bestätigung der Teilnahmebedingungen und dem Klick auf das Feld „Reisewunsch abschicken“. Die nachfolgenden Punkte geben Ihnen einen Überblick darüber, anwelchen Stellen und zu welchem Zweck die TUI die Daten der Interessenten erhebt, verarbeitet und nutzt.</p><p><b>8.1.</b> Informationen zur Datenverarbeitung und zum Datenschutz ergeben sich aus unserer Datenschutzerklärung. Diese finden Sie hier: <a target="_blank" href="https://www.tui.com/datenschutz/" target="_top"><span style="font-family:&quot;TUIType&quot;,&quot;sans-serif&quot;">http://www.TUI.com/datenschutz/</span></a><span style="font-family:&quot;TUIType&quot;,&quot;sans-serif&quot;">. </span></p><p><b>8.2.</b> Einsatz von Cookies im Reisewunschportal: Tealium IQ ist ein Tag Management System mit dem Messpixel („Tags“) von Drittanbietern auf den Seiten der TUI Deutschland geladen werden. Beispiele für Drittanbieter sind Google Analytics und DesireTec Conversion Intelligence. Zur Optimierung des Ladens der Messpixel erfasst Tealium über ein Cookie einige personenbezogene (E-Mail-Adresse und IP Adresse) und nicht personenbezogene Daten (Reisewunschdaten). Dieses Cookie verliert nach 12 Monaten seine Gültigkeit.</span></a> </p><p>Die folgenden Informationen werden im Tealium Cookie gespeichert:</p><ul> <li>Zeitstempel des Webseitenbesuchs</li><li>ID für den Seitenaufruf</li><li>ID für den Besucher</li><li>ID für die Reisewunsch Session</li><li>IP Adresse zur regionalen Zusteuerung zum Reisebüro</li><li>Flag (0 oder 1) zur Kennzeichnung des Sessionstarts</li></ul> <p>Wenn Sie sie sich von Tealium und den Messungen der nachfolgenden Drittanbieter ausschließen wollen klicken Sie auf den Link. (<a href="http://www.TUI.com/datenschutz/tracking-einstellungen">http://www.TUI.com/datenschutz/tracking-einstellungen</a>)</p><p><b>8.3.</b> Einsatz von Mauszeiger-Tracking der Firma DesireTec (DesireTec Conversion Intelligence)</p><p>DesireTec Conversion Intelligence ist ein Tracking System, das die Bewegung der Maus (Richtung, Geschwindigkeit, Beschleunigung) misst, um bei der Erfüllung festgelegter Kriterien ein Formular auszuspielen, dass Sie bei Ihrer Suche nach einer Reise unterstützen soll. Über das Tracking findet keine Speicherung personenbezogener Daten statt und es ist keine Wiedererkennung möglich.</p><p>Sollte das Formular ausgespielt werden, wird ein Cookie gespeichert, um ein mehrfaches Auslösen zu verhindern. Dieses speichert ausschließlich die Information, dass das Formular bereits ausgespielt wurde.</p><p><b>8.4.</b> Sofern keine gesetzlichen Speicherpflichten bestehen, können Sie zu jederzeit eine Löschung der von Ihnen zur Verfügung gestellten personenbezogenen Daten durch uns vornehmen lassen. Für Fragen, Wünsche oder Kommentare zum Thema Datenschutz wenden Sie sich bitte per E-Mail an den Datenschutzbeauftragten der TUI Deutschland GmbH: datenschutz@tui.de.</p><h3>&nbsp;</h3> <h3>9. Schlussbestimmungen</h3> <p><b>9.1.</b> TUI Deutschland ist berechtigt, Änderungen oder Ergänzungen an diesen Nutzungsbedingungen vorzunehmen, sofern dies dem billigen Ermessen von TUI Deutschland entspricht und für den Nutzer zumutbar ist. Diese werden erst wirksam, nachdem TUI Deutschland dem registrierten Nutzer die Änderung der Nutzungsbedingungen in Textform mitgeteilt hat und der Nutzer dieser Neufassung nicht innerhalb von 6 Wochen ab Zugang mindestens in Textform widerspricht. Der Nutzer wird bei Mitteilung der Änderung auf die Bedeutung seines Schweigens besonders hingewiesen. </p><p><b>9.2.</b> Sofern einzelne oder mehrere Bestimmungen in diesen Nutzungsbedingungen ganz oder teilweise unwirksam oder ungültig sind oder werden, bleibt die Wirksamkeit der übrigen Regelungen und Bestimmungen hiervon unberührt. Die unwirksame oder ungültige Regelung gilt durch eine Regelung ersetzt, die dem Sinn und Zweck der unwirksamen oder ungültigen Regelung in rechtwirksamer Weise wirtschaftlich am nächsten kommt. Gleiches gilt für eventuelle Regelungslücken. </p><p><b>9.3.</b> Streitigkeiten, die im Zusammenhang mit diesen Nutzungsbedingungen oder aufgrund der Nutzung des TUI Reisewunschportals geführt werden unterliegen ausschließlich dem Recht der Bundesrepublik Deutschland. </p><p> <br/> <br/>Mai 2018</p></section><style type="text/css"> .csc-frame-tx-xsocial{display: none;}</style>';

        function show() {
            if (element) {
                hide();
            }

            element = $('<div class="dt-modal dt-modal-agb" ><div class="kwp"><div class="kwp-close-button kwp-close"></div><div class="kwp-agb-content"></div></div></div>');



            /*$.ajax({
                url: 'http://tui-reisewunsch.com/bundles/cstui/popup/static/agb.html',
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
        var url_string = window.location.href;
        var url = new URL(url_string);
        return url.searchParams.get(params);
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
