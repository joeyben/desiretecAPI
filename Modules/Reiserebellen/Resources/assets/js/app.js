$(document).ready(function(){

	// brandColor is assigned in master.blade
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

    var primaryButtons = $('a.primary-btn, .primary-btn, a.btn-primary, .btn-primary, input.primary-btn');
	primaryButtons
		.css(btnPrimaryCss)
		.mouseover(function () {
			$(this).css(btnPrimaryHoverCss);
		}).mouseout(function () {
			$(this).css(btnPrimaryCss);
		});

    var secondaryButtons = $('a.secondary-btn, .secondary-btn, a.btn-secondary, .btn-secondary');
	secondaryButtons
		.css(btnSecondaryCss)
		.mouseover(function () {
			$(this).css(btnSecondaryHoverCss);
		}).mouseout(function () {
			$(this).css(btnSecondaryCss);
	});

});
