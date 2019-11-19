
// Colors

// brandColor is assigned in master.blade
var brandColorDarker = brandColor;
var whiteColor = '#fff';

// Buttons styles

var btnPrimaryCss = {
  'background': brandColor,
  'border': '1px solid ' + brandColor,
  'color': whiteColor,
};
var btnPrimaryHoverCss = {
  'background': brandColorDarker,
  'border': '1px solid ' + brandColorDarker,
  'color': whiteColor,
};
var btnSecondaryCss = {
  'background': whiteColor,
  'border': '1px solid ' + brandColor,
  'color': brandColor,
};
var btnSecondaryHoverCss = {
  'background': whiteColor,
  'border': '1px solid ' + brandColorDarker,
  'color': brandColorDarker,
};

// Buttons

var primaryButtons = $('a.primary-btn, .primary-btn, a.btn-primary, .btn-primary, input.primary-btn');
primaryButtons.css(
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

var secondaryButtons = $('a.secondary-btn, .secondary-btn, a.btn-secondary, .btn-secondary');
secondaryButtons.css(
  btnSecondaryCss
).mouseover(function () {
  $(this).css(
    btnSecondaryHoverCss
  );
}).mouseout(function () {
  $(this).css(
    btnSecondaryCss
  );
});