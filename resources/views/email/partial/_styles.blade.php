<style>

/* Font
/* latin-ext */
@font-face {
  font-family: 'Lato';
  font-style: normal;
  font-weight: 400;
  src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v14/S6uyw4BMUTPHjxAwXjeu.woff2) format('woff2');
  unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Lato';
  font-style: normal;
  font-weight: 400;
  src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v14/S6uyw4BMUTPHjx4wXg.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}

/*!
 * # Semantic UI 2.3.1 - Segment
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

 /*******************************
             Reset
*******************************/

/* Border-Box */

*,
*:before,
*:after {
  -webkit-box-sizing: inherit;
  box-sizing: inherit;
}

html {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

/* iPad Input Shadows */

input[type="text"],
input[type="email"],
input[type="search"],
input[type="password"] {
  -webkit-appearance: none;
  -moz-appearance: none;
  /* mobile firefox too! */
}

/*! normalize.css v7.0.0 | MIT License | github.com/necolas/normalize.css */

/* Document
   ========================================================================== */

/**
 * 1. Correct the line height in all browsers.
 * 2. Prevent adjustments of font size after orientation changes in
 *    IE on Windows Phone and in iOS.
 */

html {
  line-height: 1.15;
  /* 1 */
  -ms-text-size-adjust: 100%;
  /* 2 */
  -webkit-text-size-adjust: 100%;
  /* 2 */
}

/* Sections
   ========================================================================== */

/**
 * Remove the margin in all browsers (opinionated).
 */

body {
  margin: 0;
}

/**
 * Add the correct display in IE 9-.
 */

article,
aside,
footer,
header,
nav,
section {
  display: block;
}

/**
 * Correct the font size and margin on `h1` elements within `section` and
 * `article` contexts in Chrome, Firefox, and Safari.
 */

h1 {
  font-size: 2em;
  margin: 0.67em 0;
}

/* Grouping content
   ========================================================================== */

/**
 * Add the correct display in IE 9-.
 * 1. Add the correct display in IE.
 */

figcaption,
figure,
main {
  /* 1 */
  display: block;
}

/**
 * Add the correct margin in IE 8.
 */

figure {
  margin: 1em 40px;
}

/**
 * 1. Add the correct box sizing in Firefox.
 * 2. Show the overflow in Edge and IE.
 */

hr {
  -webkit-box-sizing: content-box;
  box-sizing: content-box;
  /* 1 */
  height: 0;
  /* 1 */
  overflow: visible;
  /* 2 */
}

/**
 * 1. Correct the inheritance and scaling of font size in all browsers.
 * 2. Correct the odd `em` font sizing in all browsers.
 */

pre {
  font-family: monospace, monospace;
  /* 1 */
  font-size: 1em;
  /* 2 */
}

/* Text-level semantics
   ========================================================================== */

/**
 * 1. Remove the gray background on active links in IE 10.
 * 2. Remove gaps in links underline in iOS 8+ and Safari 8+.
 */

a {
  background-color: transparent;
  /* 1 */
  -webkit-text-decoration-skip: objects;
  /* 2 */
}

/**
 * 1. Remove the bottom border in Chrome 57- and Firefox 39-.
 * 2. Add the correct text decoration in Chrome, Edge, IE, Opera, and Safari.
 */

abbr[title] {
  border-bottom: none;
  /* 1 */
  text-decoration: underline;
  /* 2 */
  -webkit-text-decoration: underline dotted;
  text-decoration: underline dotted;
  /* 2 */
}

/**
 * Prevent the duplicate application of `bolder` by the next rule in Safari 6.
 */

b,
strong {
  font-weight: inherit;
}

/**
 * Add the correct font weight in Chrome, Edge, and Safari.
 */

b,
strong {
  font-weight: bolder;
}

/**
 * 1. Correct the inheritance and scaling of font size in all browsers.
 * 2. Correct the odd `em` font sizing in all browsers.
 */

code,
kbd,
samp {
  font-family: monospace, monospace;
  /* 1 */
  font-size: 1em;
  /* 2 */
}

/**
 * Add the correct font style in Android 4.3-.
 */

dfn {
  font-style: italic;
}

/**
 * Add the correct background and color in IE 9-.
 */

mark {
  background-color: #ff0;
  color: #000;
}

/**
 * Add the correct font size in all browsers.
 */

small {
  font-size: 80%;
}

/**
 * Prevent `sub` and `sup` elements from affecting the line height in
 * all browsers.
 */

sub,
sup {
  font-size: 75%;
  line-height: 0;
  position: relative;
  vertical-align: baseline;
}

sub {
  bottom: -0.25em;
}

sup {
  top: -0.5em;
}

/* Embedded content
   ========================================================================== */

/**
 * Add the correct display in IE 9-.
 */

audio,
video {
  display: inline-block;
}

/**
 * Add the correct display in iOS 4-7.
 */

audio:not([controls]) {
  display: none;
  height: 0;
}

/**
 * Remove the border on images inside links in IE 10-.
 */

img {
  border-style: none;
}

/**
 * Hide the overflow in IE.
 */

svg:not(:root) {
  overflow: hidden;
}

/* Forms
   ========================================================================== */

/**
 * 1. Change the font styles in all browsers (opinionated).
 * 2. Remove the margin in Firefox and Safari.
 */

button,
input,
optgroup,
select,
textarea {
  font-family: sans-serif;
  /* 1 */
  font-size: 100%;
  /* 1 */
  line-height: 1.15;
  /* 1 */
  margin: 0;
  /* 2 */
}

/**
 * Show the overflow in IE.
 * 1. Show the overflow in Edge.
 */

button,
input {
  /* 1 */
  overflow: visible;
}

/**
 * Remove the inheritance of text transform in Edge, Firefox, and IE.
 * 1. Remove the inheritance of text transform in Firefox.
 */

button,
select {
  /* 1 */
  text-transform: none;
}

/**
 * 1. Prevent a WebKit bug where (2) destroys native `audio` and `video`
 *    controls in Android 4.
 * 2. Correct the inability to style clickable types in iOS and Safari.
 */

button,
html [type="button"],
[type="reset"],
[type="submit"] {
  -webkit-appearance: button;
  /* 2 */
}

/**
 * Remove the inner border and padding in Firefox.
 */

button::-moz-focus-inner,
[type="button"]::-moz-focus-inner,
[type="reset"]::-moz-focus-inner,
[type="submit"]::-moz-focus-inner {
  border-style: none;
  padding: 0;
}

/**
 * Restore the focus styles unset by the previous rule.
 */

button:-moz-focusring,
[type="button"]:-moz-focusring,
[type="reset"]:-moz-focusring,
[type="submit"]:-moz-focusring {
  outline: 1px dotted ButtonText;
}

/**
 * Correct the padding in Firefox.
 */

fieldset {
  padding: 0.35em 0.75em 0.625em;
}

/**
 * 1. Correct the text wrapping in Edge and IE.
 * 2. Correct the color inheritance from `fieldset` elements in IE.
 * 3. Remove the padding so developers are not caught out when they zero out
 *    `fieldset` elements in all browsers.
 */

legend {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  /* 1 */
  color: inherit;
  /* 2 */
  display: table;
  /* 1 */
  max-width: 100%;
  /* 1 */
  padding: 0;
  /* 3 */
  white-space: normal;
  /* 1 */
}

/**
 * 1. Add the correct display in IE 9-.
 * 2. Add the correct vertical alignment in Chrome, Firefox, and Opera.
 */

progress {
  display: inline-block;
  /* 1 */
  vertical-align: baseline;
  /* 2 */
}

/**
 * Remove the default vertical scrollbar in IE.
 */

textarea {
  overflow: auto;
}

/**
 * 1. Add the correct box sizing in IE 10-.
 * 2. Remove the padding in IE 10-.
 */

[type="checkbox"],
[type="radio"] {
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  /* 1 */
  padding: 0;
  /* 2 */
}

/**
 * Correct the cursor style of increment and decrement buttons in Chrome.
 */

[type="number"]::-webkit-inner-spin-button,
[type="number"]::-webkit-outer-spin-button {
  height: auto;
}

/**
 * 1. Correct the odd appearance in Chrome and Safari.
 * 2. Correct the outline style in Safari.
 */

[type="search"] {
  -webkit-appearance: textfield;
  /* 1 */
  outline-offset: -2px;
  /* 2 */
}

/**
 * Remove the inner padding and cancel buttons in Chrome and Safari on macOS.
 */

[type="search"]::-webkit-search-cancel-button,
[type="search"]::-webkit-search-decoration {
  -webkit-appearance: none;
}

/**
 * 1. Correct the inability to style clickable types in iOS and Safari.
 * 2. Change font properties to `inherit` in Safari.
 */

::-webkit-file-upload-button {
  -webkit-appearance: button;
  /* 1 */
  font: inherit;
  /* 2 */
}

/* Interactive
   ========================================================================== */

/*
 * Add the correct display in IE 9-.
 * 1. Add the correct display in Edge, IE, and Firefox.
 */

details,
menu {
  display: block;
}

/*
 * Add the correct display in all browsers.
 */

summary {
  display: list-item;
}

/* Scripting
   ========================================================================== */

/**
 * Add the correct display in IE 9-.
 */

canvas {
  display: inline-block;
}

/**
 * Add the correct display in IE.
 */

template {
  display: none;
}

/* Hidden
   ========================================================================== */

/**
 * Add the correct display in IE 10-.
 */

[hidden] {
  display: none;
}

/*******************************
         Site Overrides
*******************************/
/*!
 * # Semantic UI 2.3.1 - Site
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */

/*******************************
             Page
*******************************/

html,
body {
  height: 100%;
}

html {
  font-size: 14px;
}

body {
  margin: 0px;
  padding: 0px;
  overflow-x: hidden;
  min-width: 320px;
  background: #FFFFFF;
  font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
  font-size: 14px;
  line-height: 1.4285em;
  color: rgba(0, 0, 0, 0.87);
  font-smoothing: antialiased;
}

/*******************************
             Headers
*******************************/

h1,
h2,
h3,
h4,
h5 {
  font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
  line-height: 1.28571429em;
  margin: calc(2rem -  0.14285714em ) 0em 1rem;
  font-weight: bold;
  padding: 0em;
}

h1 {
  min-height: 1rem;
  font-size: 2rem;
}

h2 {
  font-size: 1.71428571rem;
}

h3 {
  font-size: 1.28571429rem;
}

h4 {
  font-size: 1.07142857rem;
}

h5 {
  font-size: 1rem;
}

h1:first-child,
h2:first-child,
h3:first-child,
h4:first-child,
h5:first-child {
  margin-top: 0em;
}

h1:last-child,
h2:last-child,
h3:last-child,
h4:last-child,
h5:last-child {
  margin-bottom: 0em;
}

/*******************************
             Text
*******************************/

p {
  margin: 0em 0em 1em;
  line-height: 1.4285em;
}

p:first-child {
  margin-top: 0em;
}

p:last-child {
  margin-bottom: 0em;
}

/*-------------------
        Links
--------------------*/

a {
  color: #4183C4;
  text-decoration: none;
}

a:hover {
  color: #1e70bf;
  text-decoration: none;
}


/*******************************
            Segment
*******************************/

.ui.segment {
  position: relative;
  background: #FFFFFF;
  -webkit-box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15);
          box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15);
  margin: 1rem 0em;
  padding: 1em 1em;
  border-radius: 0.28571429rem;
  border: 1px solid rgba(34, 36, 38, 0.15);
}
.ui.segment:first-child {
  margin-top: 0em;
}
.ui.segment:last-child {
  margin-bottom: 0em;
}

/* Vertical */
.ui.vertical.segment {
  margin: 0em;
  padding-left: 0em;
  padding-right: 0em;
  background: none transparent;
  border-radius: 0px;
  -webkit-box-shadow: none;
          box-shadow: none;
  border: none;
  border-bottom: 1px solid rgba(34, 36, 38, 0.15);
}
.ui.vertical.segment:last-child {
  border-bottom: none;
}

/*-------------------
    Loose Coupling
--------------------*/


/* Header */
.ui.inverted.segment > .ui.header {
  color: #FFFFFF;
}

/* Label */
.ui[class*="bottom attached"].segment > [class*="top attached"].label {
  border-top-left-radius: 0em;
  border-top-right-radius: 0em;
}
.ui[class*="top attached"].segment > [class*="bottom attached"].label {
  border-bottom-left-radius: 0em;
  border-bottom-right-radius: 0em;
}
.ui.attached.segment:not(.top):not(.bottom) > [class*="top attached"].label {
  border-top-left-radius: 0em;
  border-top-right-radius: 0em;
}
.ui.attached.segment:not(.top):not(.bottom) > [class*="bottom attached"].label {
  border-bottom-left-radius: 0em;
  border-bottom-right-radius: 0em;
}

/* Grid */
.ui.page.grid.segment,
.ui.grid > .row > .ui.segment.column,
.ui.grid > .ui.segment.column {
  padding-top: 2em;
  padding-bottom: 2em;
}
.ui.grid.segment {
  margin: 1rem 0em;
  border-radius: 0.28571429rem;
}

/* Table */
.ui.basic.table.segment {
  background: #FFFFFF;
  border: 1px solid rgba(34, 36, 38, 0.15);
  -webkit-box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15);
          box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15);
}
.ui[class*="very basic"].table.segment {
  padding: 1em 1em;
}


/*******************************
             Types
*******************************/


/*-------------------
        Piled
--------------------*/

.ui.piled.segments,
.ui.piled.segment {
  margin: 3em 0em;
  -webkit-box-shadow: '';
          box-shadow: '';
  z-index: auto;
}
.ui.piled.segment:first-child {
  margin-top: 0em;
}
.ui.piled.segment:last-child {
  margin-bottom: 0em;
}
.ui.piled.segments:after,
.ui.piled.segments:before,
.ui.piled.segment:after,
.ui.piled.segment:before {
  background-color: #FFFFFF;
  visibility: visible;
  content: '';
  display: block;
  height: 100%;
  left: 0px;
  position: absolute;
  width: 100%;
  border: 1px solid rgba(34, 36, 38, 0.15);
  -webkit-box-shadow: '';
          box-shadow: '';
}
.ui.piled.segments:before,
.ui.piled.segment:before {
  -webkit-transform: rotate(-1.2deg);
          transform: rotate(-1.2deg);
  top: 0;
  z-index: -2;
}
.ui.piled.segments:after,
.ui.piled.segment:after {
  -webkit-transform: rotate(1.2deg);
          transform: rotate(1.2deg);
  top: 0;
  z-index: -1;
}

/* Piled Attached */
.ui[class*="top attached"].piled.segment {
  margin-top: 3em;
  margin-bottom: 0em;
}
.ui.piled.segment[class*="top attached"]:first-child {
  margin-top: 0em;
}
.ui.piled.segment[class*="bottom attached"] {
  margin-top: 0em;
  margin-bottom: 3em;
}
.ui.piled.segment[class*="bottom attached"]:last-child {
  margin-bottom: 0em;
}

/*-------------------
       Stacked
--------------------*/

.ui.stacked.segment {
  padding-bottom: 1.4em;
}
.ui.stacked.segments:before,
.ui.stacked.segments:after,
.ui.stacked.segment:before,
.ui.stacked.segment:after {
  content: '';
  position: absolute;
  bottom: -3px;
  left: 0%;
  border-top: 1px solid rgba(34, 36, 38, 0.15);
  background: rgba(0, 0, 0, 0.03);
  width: 100%;
  height: 6px;
  visibility: visible;
}
.ui.stacked.segments:before,
.ui.stacked.segment:before {
  display: none;
}

/* Add additional page */
.ui.tall.stacked.segments:before,
.ui.tall.stacked.segment:before {
  display: block;
  bottom: 0px;
}

/* Inverted */
.ui.stacked.inverted.segments:before,
.ui.stacked.inverted.segments:after,
.ui.stacked.inverted.segment:before,
.ui.stacked.inverted.segment:after {
  background-color: rgba(0, 0, 0, 0.03);
  border-top: 1px solid rgba(34, 36, 38, 0.35);
}

/*-------------------
       Padded
--------------------*/

.ui.padded.segment {
  padding: 1.5em;
}
.ui[class*="very padded"].segment {
  padding: 3em;
}

/* Padded vertical */
.ui.padded.segment.vertical.segment,
.ui[class*="very padded"].vertical.segment {
  padding-left: 0px;
  padding-right: 0px;
}

/*-------------------
       Compact
--------------------*/

.ui.compact.segment {
  display: table;
}

/* Compact Group */
.ui.compact.segments {
  display: -webkit-inline-box;
  display: -ms-inline-flexbox;
  display: inline-flex;
}
.ui.compact.segments .segment,
.ui.segments .compact.segment {
  display: block;
  -webkit-box-flex: 0;
      -ms-flex: 0 1 auto;
          flex: 0 1 auto;
}

/*-------------------
       Circular
--------------------*/

.ui.circular.segment {
  display: table-cell;
  padding: 2em;
  text-align: center;
  vertical-align: middle;
  border-radius: 500em;
}

/*-------------------
       Raised
--------------------*/

.ui.raised.segments,
.ui.raised.segment {
  -webkit-box-shadow: 0px 2px 4px 0px rgba(34, 36, 38, 0.12), 0px 2px 10px 0px rgba(34, 36, 38, 0.15);
          box-shadow: 0px 2px 4px 0px rgba(34, 36, 38, 0.12), 0px 2px 10px 0px rgba(34, 36, 38, 0.15);
}


/*******************************
            Groups
*******************************/


/* Group */
.ui.segments {
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  position: relative;
  margin: 1rem 0em;
  border: 1px solid rgba(34, 36, 38, 0.15);
  -webkit-box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15);
          box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15);
  border-radius: 0.28571429rem;
}
.ui.segments:first-child {
  margin-top: 0em;
}
.ui.segments:last-child {
  margin-bottom: 0em;
}

/* Nested Segment */
.ui.segments > .segment {
  top: 0px;
  bottom: 0px;
  border-radius: 0px;
  margin: 0em;
  width: auto;
  -webkit-box-shadow: none;
          box-shadow: none;
  border: none;
  border-top: 1px solid rgba(34, 36, 38, 0.15);
}
.ui.segments:not(.horizontal) > .segment:first-child {
  border-top: none;
  margin-top: 0em;
  bottom: 0px;
  margin-bottom: 0em;
  top: 0px;
  border-radius: 0.28571429rem 0.28571429rem 0em 0em;
}

/* Bottom */
.ui.segments:not(.horizontal) > .segment:last-child {
  top: 0px;
  bottom: 0px;
  margin-top: 0em;
  margin-bottom: 0em;
  -webkit-box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15), none;
          box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15), none;
  border-radius: 0em 0em 0.28571429rem 0.28571429rem;
}

/* Only */
.ui.segments:not(.horizontal) > .segment:only-child {
  border-radius: 0.28571429rem;
}

/* Nested Group */
.ui.segments > .ui.segments {
  border-top: 1px solid rgba(34, 36, 38, 0.15);
  margin: 1rem 1rem;
}
.ui.segments > .segments:first-child {
  border-top: none;
}
.ui.segments > .segment + .segments:not(.horizontal) {
  margin-top: 0em;
}

/* Horizontal Group */
.ui.horizontal.segments {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-direction: row;
          flex-direction: row;
  background-color: transparent;
  border-radius: 0px;
  padding: 0em;
  background-color: #FFFFFF;
  -webkit-box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15);
          box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15);
  margin: 1rem 0em;
  border-radius: 0.28571429rem;
  border: 1px solid rgba(34, 36, 38, 0.15);
}

/* Nested Horizontal Group */
.ui.segments > .horizontal.segments {
  margin: 0em;
  background-color: transparent;
  border-radius: 0px;
  border: none;
  -webkit-box-shadow: none;
          box-shadow: none;
  border-top: 1px solid rgba(34, 36, 38, 0.15);
}

/* Horizontal Segment */
.ui.horizontal.segments > .segment {
  -webkit-box-flex: 1;
          flex: 1 1 auto;
  -ms-flex: 1 1 0px;

/* Solves #2550 MS Flex */
  margin: 0em;
  min-width: 0px;
  background-color: transparent;
  border-radius: 0px;
  border: none;
  -webkit-box-shadow: none;
          box-shadow: none;
  border-left: 1px solid rgba(34, 36, 38, 0.15);
}

/* Border Fixes */
.ui.segments > .horizontal.segments:first-child {
  border-top: none;
}
.ui.horizontal.segments > .segment:first-child {
  border-left: none;
}


/*******************************
            States
*******************************/


/*--------------
    Disabled
---------------*/

.ui.disabled.segment {
  opacity: 0.45;
  color: rgba(40, 40, 40, 0.3);
}

/*--------------
    Loading
---------------*/

.ui.loading.segment {
  position: relative;
  cursor: default;
  pointer-events: none;
  text-shadow: none !important;
  color: transparent !important;
  -webkit-transition: all 0s linear;
  transition: all 0s linear;
}
.ui.loading.segment:before {
  position: absolute;
  content: '';
  top: 0%;
  left: 0%;
  background: rgba(255, 255, 255, 0.8);
  width: 100%;
  height: 100%;
  border-radius: 0.28571429rem;
  z-index: 100;
}
.ui.loading.segment:after {
  position: absolute;
  content: '';
  top: 50%;
  left: 50%;
  margin: -1.5em 0em 0em -1.5em;
  width: 3em;
  height: 3em;
  -webkit-animation: segment-spin 0.6s linear;
          animation: segment-spin 0.6s linear;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  border-radius: 500rem;
  border-color: #767676 rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1);
  border-style: solid;
  border-width: 0.2em;
  -webkit-box-shadow: 0px 0px 0px 1px transparent;
          box-shadow: 0px 0px 0px 1px transparent;
  visibility: visible;
  z-index: 101;
}
@-webkit-keyframes segment-spin {
  from {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}
@keyframes segment-spin {
  from {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}


/*******************************
           Variations
*******************************/


/*-------------------
       Basic
--------------------*/

.ui.basic.segment {
  background: none transparent;
  -webkit-box-shadow: none;
          box-shadow: none;
  border: none;
  border-radius: 0px;
}

/*-------------------
       Clearing
--------------------*/

.ui.clearing.segment:after {
  content: ".";
  display: block;
  height: 0;
  clear: both;
  visibility: hidden;
}

/*-------------------
       Colors
--------------------*/


/* Red */
.ui.red.segment:not(.inverted) {
  border-top: 2px solid #DB2828 !important;
}
.ui.inverted.red.segment {
  background-color: #DB2828 !important;
  color: #FFFFFF !important;
}

/* Orange */
.ui.orange.segment:not(.inverted) {
  border-top: 2px solid #F2711C !important;
}
.ui.inverted.orange.segment {
  background-color: #F2711C !important;
  color: #FFFFFF !important;
}

/* Yellow */
.ui.yellow.segment:not(.inverted) {
  border-top: 2px solid #FBBD08 !important;
}
.ui.inverted.yellow.segment {
  background-color: #FBBD08 !important;
  color: #FFFFFF !important;
}

/* Olive */
.ui.olive.segment:not(.inverted) {
  border-top: 2px solid #B5CC18 !important;
}
.ui.inverted.olive.segment {
  background-color: #B5CC18 !important;
  color: #FFFFFF !important;
}

/* Green */
.ui.green.segment:not(.inverted) {
  border-top: 2px solid #21BA45 !important;
}
.ui.inverted.green.segment {
  background-color: #21BA45 !important;
  color: #FFFFFF !important;
}

/* Teal */
.ui.teal.segment:not(.inverted) {
  border-top: 2px solid #00B5AD !important;
}
.ui.inverted.teal.segment {
  background-color: #00B5AD !important;
  color: #FFFFFF !important;
}

/* Blue */
.ui.blue.segment:not(.inverted) {
  border-top: 2px solid #2185D0 !important;
}
.ui.inverted.blue.segment {
  background-color: #2185D0 !important;
  color: #FFFFFF !important;
}

/* Violet */
.ui.violet.segment:not(.inverted) {
  border-top: 2px solid #6435C9 !important;
}
.ui.inverted.violet.segment {
  background-color: #6435C9 !important;
  color: #FFFFFF !important;
}

/* Purple */
.ui.purple.segment:not(.inverted) {
  border-top: 2px solid #A333C8 !important;
}
.ui.inverted.purple.segment {
  background-color: #A333C8 !important;
  color: #FFFFFF !important;
}

/* Pink */
.ui.pink.segment:not(.inverted) {
  border-top: 2px solid #E03997 !important;
}
.ui.inverted.pink.segment {
  background-color: #E03997 !important;
  color: #FFFFFF !important;
}

/* Brown */
.ui.brown.segment:not(.inverted) {
  border-top: 2px solid #A5673F !important;
}
.ui.inverted.brown.segment {
  background-color: #A5673F !important;
  color: #FFFFFF !important;
}

/* Grey */
.ui.grey.segment:not(.inverted) {
  border-top: 2px solid #767676 !important;
}
.ui.inverted.grey.segment {
  background-color: #767676 !important;
  color: #FFFFFF !important;
}

/* Black */
.ui.black.segment:not(.inverted) {
  border-top: 2px solid #1B1C1D !important;
}
.ui.inverted.black.segment {
  background-color: #1B1C1D !important;
  color: #FFFFFF !important;
}

/*-------------------
       Aligned
--------------------*/

.ui[class*="left aligned"].segment {
  text-align: left;
}
.ui[class*="right aligned"].segment {
  text-align: right;
}
.ui[class*="center aligned"].segment {
  text-align: center;
}

/*-------------------
       Floated
--------------------*/

.ui.floated.segment,
.ui[class*="left floated"].segment {
  float: left;
  margin-right: 1em;
}
.ui[class*="right floated"].segment {
  float: right;
  margin-left: 1em;
}

/*-------------------
      Inverted
--------------------*/

.ui.inverted.segment {
  border: none;
  -webkit-box-shadow: none;
          box-shadow: none;
}
.ui.inverted.segment,
.ui.primary.inverted.segment {
  background: #1B1C1D;
  color: rgba(255, 255, 255, 0.9);
}

/* Nested */
.ui.inverted.segment .segment {
  color: rgba(0, 0, 0, 0.87);
}
.ui.inverted.segment .inverted.segment {
  color: rgba(255, 255, 255, 0.9);
}

/* Attached */
.ui.inverted.attached.segment {
  border-color: #555555;
}

/*-------------------
     Emphasis
--------------------*/


/* Secondary */
.ui.secondary.segment {
  background: #F3F4F5;
  color: rgba(0, 0, 0, 0.6);
}
.ui.secondary.inverted.segment {
  background: #4c4f52 -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.2)), to(rgba(255, 255, 255, 0.2)));
  background: #4c4f52 -webkit-linear-gradient(rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.2) 100%);
  background: #4c4f52 linear-gradient(rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.2) 100%);
  color: rgba(255, 255, 255, 0.8);
}

/* Tertiary */
.ui.tertiary.segment {
  background: #DCDDDE;
  color: rgba(0, 0, 0, 0.6);
}
.ui.tertiary.inverted.segment {
  background: #717579 -webkit-gradient(linear, left top, left bottom, from(rgba(255, 255, 255, 0.35)), to(rgba(255, 255, 255, 0.35)));
  background: #717579 -webkit-linear-gradient(rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0.35) 100%);
  background: #717579 linear-gradient(rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0.35) 100%);
  color: rgba(255, 255, 255, 0.8);
}

/*-------------------
      Attached
--------------------*/


/* Middle */
.ui.attached.segment {
  top: 0px;
  bottom: 0px;
  border-radius: 0px;
  margin: 0em -1px;
  width: calc(100% +  2px );
  max-width: calc(100% +  2px );
  -webkit-box-shadow: none;
          box-shadow: none;
  border: 1px solid #D4D4D5;
}
.ui.attached:not(.message) + .ui.attached.segment:not(.top) {
  border-top: none;
}

/* Top */
.ui[class*="top attached"].segment {
  bottom: 0px;
  margin-bottom: 0em;
  top: 0px;
  margin-top: 1rem;
  border-radius: 0.28571429rem 0.28571429rem 0em 0em;
}
.ui.segment[class*="top attached"]:first-child {
  margin-top: 0em;
}

/* Bottom */
.ui.segment[class*="bottom attached"] {
  bottom: 0px;
  margin-top: 0em;
  top: 0px;
  margin-bottom: 1rem;
  -webkit-box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15), none;
          box-shadow: 0px 1px 2px 0 rgba(34, 36, 38, 0.15), none;
  border-radius: 0em 0em 0.28571429rem 0.28571429rem;
}
.ui.segment[class*="bottom attached"]:last-child {
  margin-bottom: 0em;
}

/*-------------------
        Size
--------------------*/

.ui.mini.segments .segment,
.ui.mini.segment {
  font-size: 0.78571429rem;
}
.ui.tiny.segments .segment,
.ui.tiny.segment {
  font-size: 0.85714286rem;
}
.ui.small.segments .segment,
.ui.small.segment {
  font-size: 0.92857143rem;
}
.ui.segments .segment,
.ui.segment {
  font-size: 1rem;
}
.ui.large.segments .segment,
.ui.large.segment {
  font-size: 1.14285714rem;
}
.ui.big.segments .segment,
.ui.big.segment {
  font-size: 1.28571429rem;
}
.ui.huge.segments .segment,
.ui.huge.segment {
  font-size: 1.42857143rem;
}
.ui.massive.segments .segment,
.ui.massive.segment {
  font-size: 1.71428571rem;
}

/*******************************
             Image
*******************************/

.ui.image {
  position: relative;
  display: inline-block;
  vertical-align: middle;
  max-width: 100%;
  background-color: transparent;
}
img.ui.image {
  display: block;
}
.ui.image svg,
.ui.image img {
  display: block;
  max-width: 100%;
  height: auto;
}


/*******************************
            States
*******************************/

.ui.hidden.images,
.ui.hidden.image {
  display: none;
}
.ui.hidden.transition.images,
.ui.hidden.transition.image {
  display: block;
  visibility: hidden;
}
.ui.images > .hidden.transition {
  display: inline-block;
  visibility: hidden;
}
.ui.disabled.images,
.ui.disabled.image {
  cursor: default;
  opacity: 0.45;
}


/*******************************
          Variations
*******************************/


/*--------------
     Inline
---------------*/

.ui.inline.image,
.ui.inline.image svg,
.ui.inline.image img {
  display: inline-block;
}

/*------------------
  Vertical Aligned
-------------------*/

.ui.top.aligned.images .image,
.ui.top.aligned.image,
.ui.top.aligned.image svg,
.ui.top.aligned.image img {
  display: inline-block;
  vertical-align: top;
}
.ui.middle.aligned.images .image,
.ui.middle.aligned.image,
.ui.middle.aligned.image svg,
.ui.middle.aligned.image img {
  display: inline-block;
  vertical-align: middle;
}
.ui.bottom.aligned.images .image,
.ui.bottom.aligned.image,
.ui.bottom.aligned.image svg,
.ui.bottom.aligned.image img {
  display: inline-block;
  vertical-align: bottom;
}

/*--------------
     Rounded
---------------*/

.ui.rounded.images .image,
.ui.rounded.image,
.ui.rounded.images .image > *,
.ui.rounded.image > * {
  border-radius: 0.3125em;
}

/*--------------
    Bordered
---------------*/

.ui.bordered.images .image,
.ui.bordered.images img,
.ui.bordered.images svg,
.ui.bordered.image img,
.ui.bordered.image svg,
img.ui.bordered.image {
  border: 1px solid rgba(0, 0, 0, 0.1);
}

/*--------------
    Circular
---------------*/

.ui.circular.images,
.ui.circular.image {
  overflow: hidden;
}
.ui.circular.images .image,
.ui.circular.image,
.ui.circular.images .image > *,
.ui.circular.image > * {
  border-radius: 500rem;
}

/*--------------
     Fluid
---------------*/

.ui.fluid.images,
.ui.fluid.image,
.ui.fluid.images img,
.ui.fluid.images svg,
.ui.fluid.image svg,
.ui.fluid.image img {
  display: block;
  width: 100%;
  height: auto;
}

/*--------------
     Avatar
---------------*/

.ui.avatar.images .image,
.ui.avatar.images img,
.ui.avatar.images svg,
.ui.avatar.image img,
.ui.avatar.image svg,
.ui.avatar.image {
  margin-right: 0.25em;
  display: inline-block;
  width: 2em;
  height: 2em;
  border-radius: 500rem;
}

/*-------------------
       Spaced
--------------------*/

.ui.spaced.image {
  display: inline-block !important;
  margin-left: 0.5em;
  margin-right: 0.5em;
}
.ui[class*="left spaced"].image {
  margin-left: 0.5em;
  margin-right: 0em;
}
.ui[class*="right spaced"].image {
  margin-left: 0em;
  margin-right: 0.5em;
}

/*-------------------
       Floated
--------------------*/

.ui.floated.image,
.ui.floated.images {
  float: left;
  margin-right: 1em;
  margin-bottom: 1em;
}
.ui.right.floated.images,
.ui.right.floated.image {
  float: right;
  margin-right: 0em;
  margin-bottom: 1em;
  margin-left: 1em;
}
.ui.floated.images:last-child,
.ui.floated.image:last-child {
  margin-bottom: 0em;
}
.ui.centered.images,
.ui.centered.image {
  margin-left: auto;
  margin-right: auto;
}

/*--------------
     Sizes
---------------*/

.ui.mini.images .image,
.ui.mini.images img,
.ui.mini.images svg,
.ui.mini.image {
  width: 35px;
  height: auto;
  font-size: 0.78571429rem;
}
.ui.tiny.images .image,
.ui.tiny.images img,
.ui.tiny.images svg,
.ui.tiny.image {
  width: 80px;
  height: auto;
  font-size: 0.85714286rem;
}
.ui.small.images .image,
.ui.small.images img,
.ui.small.images svg,
.ui.small.image {
  width: 150px;
  height: auto;
  font-size: 0.92857143rem;
}
.ui.medium.images .image,
.ui.medium.images img,
.ui.medium.images svg,
.ui.medium.image {
  width: 300px;
  height: auto;
  font-size: 1rem;
}
.ui.large.images .image,
.ui.large.images img,
.ui.large.images svg,
.ui.large.image {
  width: 450px;
  height: auto;
  font-size: 1.14285714rem;
}
.ui.big.images .image,
.ui.big.images img,
.ui.big.images svg,
.ui.big.image {
  width: 600px;
  height: auto;
  font-size: 1.28571429rem;
}
.ui.huge.images .image,
.ui.huge.images img,
.ui.huge.images svg,
.ui.huge.image {
  width: 800px;
  height: auto;
  font-size: 1.42857143rem;
}
.ui.massive.images .image,
.ui.massive.images img,
.ui.massive.images svg,
.ui.massive.image {
  width: 960px;
  height: auto;
  font-size: 1.71428571rem;
}


/*******************************
              Groups
*******************************/

.ui.images {
  font-size: 0em;
  margin: 0em -0.25rem 0rem;
}
.ui.images .image,
.ui.images > img,
.ui.images > svg {
  display: inline-block;
  margin: 0em 0.25rem 0.5rem;
}

/*!
 * # Semantic UI 2.3.1 - Header
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */


/*******************************
            Header
*******************************/


/* Standard */
.ui.header {
  border: none;
  margin: calc(2rem -  0.14285714em ) 0em 1rem;
  padding: 0em 0em;
  font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
  font-weight: bold;
  line-height: 1.28571429em;
  text-transform: none;
  color: rgba(0, 0, 0, 0.87);
}
.ui.header:first-child {
  margin-top: -0.14285714em;
}
.ui.header:last-child {
  margin-bottom: 0em;
}

/*--------------
   Sub Header
---------------*/

.ui.header .sub.header {
  display: block;
  font-weight: normal;
  padding: 0em;
  margin: 0em;
  font-size: 1rem;
  line-height: 1.2em;
  color: rgba(0, 0, 0, 0.6);
}

/*--------------
      Icon
---------------*/

.ui.header > .icon {
  display: table-cell;
  opacity: 1;
  font-size: 1.5em;
  padding-top: 0em;
  vertical-align: middle;
}

/* With Text Node */
.ui.header .icon:only-child {
  display: inline-block;
  padding: 0em;
  margin-right: 0.75rem;
}

/*-------------------
        Image
--------------------*/

.ui.header > .image:not(.icon),
.ui.header > img {
  display: inline-block;
  margin-top: 0.14285714em;
  width: 2.5em;
  height: auto;
  vertical-align: middle;
}
.ui.header > .image:not(.icon):only-child,
.ui.header > img:only-child {
  margin-right: 0.75rem;
}

/*--------------
     Content
---------------*/

.ui.header .content {
  display: inline-block;
  vertical-align: top;
}

/* After Image */
.ui.header > img + .content,
.ui.header > .image + .content {
  padding-left: 0.75rem;
  vertical-align: middle;
}

/* After Icon */
.ui.header > .icon + .content {
  padding-left: 0.75rem;
  display: table-cell;
  vertical-align: middle;
}

/*--------------
 Loose Coupling
---------------*/

.ui.header .ui.label {
  font-size: '';
  margin-left: 0.5rem;
  vertical-align: middle;
}

/* Positioning */
.ui.header + p {
  margin-top: 0em;
}


/*******************************
            Types
*******************************/


/*--------------
     Page
---------------*/

h1.ui.header {
  font-size: 2rem;
}
h2.ui.header {
  font-size: 1.71428571rem;
}
h3.ui.header {
  font-size: 1.28571429rem;
}
h4.ui.header {
  font-size: 1.07142857rem;
}
h5.ui.header {
  font-size: 1rem;
}

/* Sub Header */
h1.ui.header .sub.header {
  font-size: 1.14285714rem;
}
h2.ui.header .sub.header {
  font-size: 1.14285714rem;
}
h3.ui.header .sub.header {
  font-size: 1rem;
}
h4.ui.header .sub.header {
  font-size: 1rem;
}
h5.ui.header .sub.header {
  font-size: 0.92857143rem;
}

/*--------------
 Content Heading
---------------*/

.ui.huge.header {
  min-height: 1em;
  font-size: 2em;
}
.ui.large.header {
  font-size: 1.71428571em;
}
.ui.medium.header {
  font-size: 1.28571429em;
}
.ui.small.header {
  font-size: 1.07142857em;
}
.ui.tiny.header {
  font-size: 1em;
}

/* Sub Header */
.ui.huge.header .sub.header {
  font-size: 1.14285714rem;
}
.ui.large.header .sub.header {
  font-size: 1.14285714rem;
}
.ui.header .sub.header {
  font-size: 1rem;
}
.ui.small.header .sub.header {
  font-size: 1rem;
}
.ui.tiny.header .sub.header {
  font-size: 0.92857143rem;
}

/*--------------
   Sub Heading
---------------*/

.ui.sub.header {
  padding: 0em;
  margin-bottom: 0.14285714rem;
  font-weight: bold;
  font-size: 0.85714286em;
  text-transform: uppercase;
  color: '';
}
.ui.small.sub.header {
  font-size: 0.78571429em;
}
.ui.sub.header {
  font-size: 0.85714286em;
}
.ui.large.sub.header {
  font-size: 0.92857143em;
}
.ui.huge.sub.header {
  font-size: 1em;
}

/*-------------------
        Icon
--------------------*/

.ui.icon.header {
  display: inline-block;
  text-align: center;
  margin: 2rem 0em 1rem;
}
.ui.icon.header:after {
  content: '';
  display: block;
  height: 0px;
  clear: both;
  visibility: hidden;
}
.ui.icon.header:first-child {
  margin-top: 0em;
}
.ui.icon.header .icon {
  float: none;
  display: block;
  width: auto;
  height: auto;
  line-height: 1;
  padding: 0em;
  font-size: 3em;
  margin: 0em auto 0.5rem;
  opacity: 1;
}
.ui.icon.header .content {
  display: block;
  padding: 0em;
}
.ui.icon.header .circular.icon {
  font-size: 2em;
}
.ui.icon.header .square.icon {
  font-size: 2em;
}
.ui.block.icon.header .icon {
  margin-bottom: 0em;
}
.ui.icon.header.aligned {
  margin-left: auto;
  margin-right: auto;
  display: block;
}


/*******************************
            States
*******************************/

.ui.disabled.header {
  opacity: 0.45;
}


/*******************************
           Variations
*******************************/


/*-------------------
      Inverted
--------------------*/

.ui.inverted.header {
  color: #FFFFFF;
}
.ui.inverted.header .sub.header {
  color: rgba(255, 255, 255, 0.8);
}
.ui.inverted.attached.header {
  background: #545454 -webkit-gradient(linear, left top, left bottom, from(transparent), to(rgba(0, 0, 0, 0.05)));
  background: #545454 -webkit-linear-gradient(transparent, rgba(0, 0, 0, 0.05));
  background: #545454 linear-gradient(transparent, rgba(0, 0, 0, 0.05));
  -webkit-box-shadow: none;
          box-shadow: none;
  border-color: transparent;
}
.ui.inverted.block.header {
  background: #545454 -webkit-gradient(linear, left top, left bottom, from(transparent), to(rgba(0, 0, 0, 0.05)));
  background: #545454 -webkit-linear-gradient(transparent, rgba(0, 0, 0, 0.05));
  background: #545454 linear-gradient(transparent, rgba(0, 0, 0, 0.05));
  -webkit-box-shadow: none;
          box-shadow: none;
}
.ui.inverted.block.header {
  border-bottom: none;
}

/*-------------------
       Colors
--------------------*/


/*--- Red ---*/

.ui.red.header {
  color: #DB2828 !important;
}
a.ui.red.header:hover {
  color: #d01919 !important;
}
.ui.red.dividing.header {
  border-bottom: 2px solid #DB2828;
}

/* Inverted */
.ui.inverted.red.header {
  color: #FF695E !important;
}
a.ui.inverted.red.header:hover {
  color: #ff5144 !important;
}

/*--- Orange ---*/

.ui.orange.header {
  color: #F2711C !important;
}
a.ui.orange.header:hover {
  color: #f26202 !important;
}
.ui.orange.dividing.header {
  border-bottom: 2px solid #F2711C;
}

/* Inverted */
.ui.inverted.orange.header {
  color: #FF851B !important;
}
a.ui.inverted.orange.header:hover {
  color: #ff7701 !important;
}

/*--- Olive ---*/

.ui.olive.header {
  color: #B5CC18 !important;
}
a.ui.olive.header:hover {
  color: #a7bd0d !important;
}
.ui.olive.dividing.header {
  border-bottom: 2px solid #B5CC18;
}

/* Inverted */
.ui.inverted.olive.header {
  color: #D9E778 !important;
}
a.ui.inverted.olive.header:hover {
  color: #d8ea5c !important;
}

/*--- Yellow ---*/

.ui.yellow.header {
  color: #FBBD08 !important;
}
a.ui.yellow.header:hover {
  color: #eaae00 !important;
}
.ui.yellow.dividing.header {
  border-bottom: 2px solid #FBBD08;
}

/* Inverted */
.ui.inverted.yellow.header {
  color: #FFE21F !important;
}
a.ui.inverted.yellow.header:hover {
  color: #ffdf05 !important;
}

/*--- Green ---*/

.ui.green.header {
  color: #21BA45 !important;
}
a.ui.green.header:hover {
  color: #16ab39 !important;
}
.ui.green.dividing.header {
  border-bottom: 2px solid #21BA45;
}

/* Inverted */
.ui.inverted.green.header {
  color: #2ECC40 !important;
}
a.ui.inverted.green.header:hover {
  color: #22be34 !important;
}

/*--- Teal ---*/

.ui.teal.header {
  color: #00B5AD !important;
}
a.ui.teal.header:hover {
  color: #009c95 !important;
}
.ui.teal.dividing.header {
  border-bottom: 2px solid #00B5AD;
}

/* Inverted */
.ui.inverted.teal.header {
  color: #6DFFFF !important;
}
a.ui.inverted.teal.header:hover {
  color: #54ffff !important;
}

/*--- Blue ---*/

.ui.blue.header {
  color: #2185D0 !important;
}
a.ui.blue.header:hover {
  color: #1678c2 !important;
}
.ui.blue.dividing.header {
  border-bottom: 2px solid #2185D0;
}

/* Inverted */
.ui.inverted.blue.header {
  color: #54C8FF !important;
}
a.ui.inverted.blue.header:hover {
  color: #3ac0ff !important;
}

/*--- Violet ---*/

.ui.violet.header {
  color: #6435C9 !important;
}
a.ui.violet.header:hover {
  color: #5829bb !important;
}
.ui.violet.dividing.header {
  border-bottom: 2px solid #6435C9;
}

/* Inverted */
.ui.inverted.violet.header {
  color: #A291FB !important;
}
a.ui.inverted.violet.header:hover {
  color: #8a73ff !important;
}

/*--- Purple ---*/

.ui.purple.header {
  color: #A333C8 !important;
}
a.ui.purple.header:hover {
  color: #9627ba !important;
}
.ui.purple.dividing.header {
  border-bottom: 2px solid #A333C8;
}

/* Inverted */
.ui.inverted.purple.header {
  color: #DC73FF !important;
}
a.ui.inverted.purple.header:hover {
  color: #d65aff !important;
}

/*--- Pink ---*/

.ui.pink.header {
  color: #E03997 !important;
}
a.ui.pink.header:hover {
  color: #e61a8d !important;
}
.ui.pink.dividing.header {
  border-bottom: 2px solid #E03997;
}

/* Inverted */
.ui.inverted.pink.header {
  color: #FF8EDF !important;
}
a.ui.inverted.pink.header:hover {
  color: #ff74d8 !important;
}

/*--- Brown ---*/

.ui.brown.header {
  color: #A5673F !important;
}
a.ui.brown.header:hover {
  color: #975b33 !important;
}
.ui.brown.dividing.header {
  border-bottom: 2px solid #A5673F;
}

/* Inverted */
.ui.inverted.brown.header {
  color: #D67C1C !important;
}
a.ui.inverted.brown.header:hover {
  color: #c86f11 !important;
}

/*--- Grey ---*/

.ui.grey.header {
  color: #767676 !important;
}
a.ui.grey.header:hover {
  color: #838383 !important;
}
.ui.grey.dividing.header {
  border-bottom: 2px solid #767676;
}

/* Inverted */
.ui.inverted.grey.header {
  color: #DCDDDE !important;
}
a.ui.inverted.grey.header:hover {
  color: #cfd0d2 !important;
}

/*-------------------
       Aligned
--------------------*/

.ui.left.aligned.header {
  text-align: left;
}
.ui.right.aligned.header {
  text-align: right;
}
.ui.centered.header,
.ui.center.aligned.header {
  text-align: center;
}
.ui.justified.header {
  text-align: justify;
}
.ui.justified.header:after {
  display: inline-block;
  content: '';
  width: 100%;
}

/*-------------------
       Floated
--------------------*/

.ui.floated.header,
.ui[class*="left floated"].header {
  float: left;
  margin-top: 0em;
  margin-right: 0.5em;
}
.ui[class*="right floated"].header {
  float: right;
  margin-top: 0em;
  margin-left: 0.5em;
}

/*-------------------
       Fitted
--------------------*/

.ui.fitted.header {
  padding: 0em;
}

/*-------------------
      Dividing
--------------------*/

.ui.dividing.header {
  padding-bottom: 0.21428571rem;
  border-bottom: 1px solid rgba(34, 36, 38, 0.15);
}
.ui.dividing.header .sub.header {
  padding-bottom: 0.21428571rem;
}
.ui.dividing.header .icon {
  margin-bottom: 0em;
}
.ui.inverted.dividing.header {
  border-bottom-color: rgba(255, 255, 255, 0.1);
}

/*-------------------
        Block
--------------------*/

.ui.block.header {
  background: #F3F4F5;
  padding: 0.78571429rem 1rem;
  -webkit-box-shadow: none;
          box-shadow: none;
  border: 1px solid #D4D4D5;
  border-radius: 0.28571429rem;
}
.ui.tiny.block.header {
  font-size: 0.85714286rem;
}
.ui.small.block.header {
  font-size: 0.92857143rem;
}
.ui.block.header:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6) {
  font-size: 1rem;
}
.ui.large.block.header {
  font-size: 1.14285714rem;
}
.ui.huge.block.header {
  font-size: 1.42857143rem;
}

/*-------------------
       Attached
--------------------*/

.ui.attached.header {
  background: #FFFFFF;
  padding: 0.78571429rem 1rem;
  margin-left: -1px;
  margin-right: -1px;
  -webkit-box-shadow: none;
          box-shadow: none;
  border: 1px solid #D4D4D5;
}
.ui.attached.block.header {
  background: #F3F4F5;
}
.ui.attached:not(.top):not(.bottom).header {
  margin-top: 0em;
  margin-bottom: 0em;
  border-top: none;
  border-radius: 0em;
}
.ui.top.attached.header {
  margin-bottom: 0em;
  border-radius: 0.28571429rem 0.28571429rem 0em 0em;
}
.ui.bottom.attached.header {
  margin-top: 0em;
  border-top: none;
  border-radius: 0em 0em 0.28571429rem 0.28571429rem;
}

/* Attached Sizes */
.ui.tiny.attached.header {
  font-size: 0.85714286em;
}
.ui.small.attached.header {
  font-size: 0.92857143em;
}
.ui.attached.header:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6) {
  font-size: 1em;
}
.ui.large.attached.header {
  font-size: 1.14285714em;
}
.ui.huge.attached.header {
  font-size: 1.42857143em;
}

/*-------------------
        Sizing
--------------------*/

.ui.header:not(h1):not(h2):not(h3):not(h4):not(h5):not(h6) {
  font-size: 1.28571429em;
}

/*!
 * # Semantic UI 2.3.1 - Table
 * http://github.com/semantic-org/semantic-ui/
 *
 *
 * Released under the MIT license
 * http://opensource.org/licenses/MIT
 *
 */


/*******************************
             Table
*******************************/


/* Prototype */
.ui.table {
  width: 100%;
  background: #FFFFFF;
  margin: 1em 0em;
  border: 1px solid rgba(34, 36, 38, 0.15);
  -webkit-box-shadow: none;
          box-shadow: none;
  border-radius: 0.28571429rem;
  text-align: left;
  color: rgba(0, 0, 0, 0.87);
  border-collapse: separate;
  border-spacing: 0px;
}
.ui.table:first-child {
  margin-top: 0em;
}
.ui.table:last-child {
  margin-bottom: 0em;
}


/*******************************
             Parts
*******************************/


/* Table Content */
.ui.table th,
.ui.table td {
  -webkit-transition: background 0.1s ease, color 0.1s ease;
  transition: background 0.1s ease, color 0.1s ease;
}

/* Headers */
.ui.table thead {
  -webkit-box-shadow: none;
          box-shadow: none;
}
.ui.table thead th {
  cursor: auto;
  background: #F9FAFB;
  text-align: inherit;
  color: rgba(0, 0, 0, 0.87);
  padding: 0.92857143em 0.78571429em;
  vertical-align: inherit;
  font-style: none;
  font-weight: bold;
  text-transform: none;
  border-bottom: 1px solid rgba(34, 36, 38, 0.1);
  border-left: none;
}
.ui.table thead tr > th:first-child {
  border-left: none;
}
.ui.table thead tr:first-child > th:first-child {
  border-radius: 0.28571429rem 0em 0em 0em;
}
.ui.table thead tr:first-child > th:last-child {
  border-radius: 0em 0.28571429rem 0em 0em;
}
.ui.table thead tr:first-child > th:only-child {
  border-radius: 0.28571429rem 0.28571429rem 0em 0em;
}

/* Footer */
.ui.table tfoot {
  -webkit-box-shadow: none;
          box-shadow: none;
}
.ui.table tfoot th {
  cursor: auto;
  border-top: 1px solid rgba(34, 36, 38, 0.15);
  background: #F9FAFB;
  text-align: inherit;
  color: rgba(0, 0, 0, 0.87);
  padding: 0.78571429em 0.78571429em;
  vertical-align: middle;
  font-style: normal;
  font-weight: normal;
  text-transform: none;
}
.ui.table tfoot tr > th:first-child {
  border-left: none;
}
.ui.table tfoot tr:first-child > th:first-child {
  border-radius: 0em 0em 0em 0.28571429rem;
}
.ui.table tfoot tr:first-child > th:last-child {
  border-radius: 0em 0em 0.28571429rem 0em;
}
.ui.table tfoot tr:first-child > th:only-child {
  border-radius: 0em 0em 0.28571429rem 0.28571429rem;
}

/* Table Row */
.ui.table tr td {
  border-top: 1px solid rgba(34, 36, 38, 0.1);
}
.ui.table tr:first-child td {
  border-top: none;
}

/* Repeated tbody */
.ui.table tbody + tbody tr:first-child td {
  border-top: 1px solid rgba(34, 36, 38, 0.1);
}

/* Table Cells */
.ui.table td {
  padding: 0.78571429em 0.78571429em;
  text-align: inherit;
}

/* Icons */
.ui.table > .icon {
  vertical-align: baseline;
}
.ui.table > .icon:only-child {
  margin: 0em;
}

/* Table Segment */
.ui.table.segment {
  padding: 0em;
}
.ui.table.segment:after {
  display: none;
}
.ui.table.segment.stacked:after {
  display: block;
}

/* Responsive */
@media only screen and (max-width: 767px) {
  .ui.table:not(.unstackable) {
    width: 100%;
  }
  .ui.table:not(.unstackable) tbody,
  .ui.table:not(.unstackable) tr,
  .ui.table:not(.unstackable) tr > th,
  .ui.table:not(.unstackable) tr > td {
    width: auto !important;
    display: block !important;
  }
  .ui.table:not(.unstackable) {
    padding: 0em;
  }
  .ui.table:not(.unstackable) thead {
    display: block;
  }
  .ui.table:not(.unstackable) tfoot {
    display: block;
  }
  .ui.table:not(.unstackable) tr {
    padding-top: 1em;
    padding-bottom: 1em;
    -webkit-box-shadow: 0px -1px 0px 0px rgba(0, 0, 0, 0.1) inset !important;
            box-shadow: 0px -1px 0px 0px rgba(0, 0, 0, 0.1) inset !important;
  }
  .ui.table:not(.unstackable) tr > th,
  .ui.table:not(.unstackable) tr > td {
    background: none;
    border: none !important;
    padding: 0.25em 0.75em !important;
    -webkit-box-shadow: none !important;
            box-shadow: none !important;
  }
  .ui.table:not(.unstackable) th:first-child,
  .ui.table:not(.unstackable) td:first-child {
    font-weight: bold;
  }

/* Definition Table */
  .ui.definition.table:not(.unstackable) thead th:first-child {
    -webkit-box-shadow: none !important;
            box-shadow: none !important;
  }
}


/*******************************
            Coupling
*******************************/


/* UI Image */
.ui.table th .image,
.ui.table th .image img,
.ui.table td .image,
.ui.table td .image img {
  max-width: none;
}


/*******************************
             Types
*******************************/


/*--------------
    Complex
---------------*/

.ui.structured.table {
  border-collapse: collapse;
}
.ui.structured.table thead th {
  border-left: none;
  border-right: none;
}
.ui.structured.sortable.table thead th {
  border-left: 1px solid rgba(34, 36, 38, 0.15);
  border-right: 1px solid rgba(34, 36, 38, 0.15);
}
.ui.structured.basic.table th {
  border-left: none;
  border-right: none;
}
.ui.structured.celled.table tr th,
.ui.structured.celled.table tr td {
  border-left: 1px solid rgba(34, 36, 38, 0.1);
  border-right: 1px solid rgba(34, 36, 38, 0.1);
}

/*--------------
   Definition
---------------*/

.ui.definition.table thead:not(.full-width) th:first-child {
  pointer-events: none;
  background: transparent;
  font-weight: normal;
  color: rgba(0, 0, 0, 0.4);
  -webkit-box-shadow: -1px -1px 0px 1px #FFFFFF;
          box-shadow: -1px -1px 0px 1px #FFFFFF;
}
.ui.definition.table tfoot:not(.full-width) th:first-child {
  pointer-events: none;
  background: transparent;
  font-weight: rgba(0, 0, 0, 0.4);
  color: normal;
  -webkit-box-shadow: 1px 1px 0px 1px #FFFFFF;
          box-shadow: 1px 1px 0px 1px #FFFFFF;
}

/* Remove Border */
.ui.celled.definition.table thead:not(.full-width) th:first-child {
  -webkit-box-shadow: 0px -1px 0px 1px #FFFFFF;
          box-shadow: 0px -1px 0px 1px #FFFFFF;
}
.ui.celled.definition.table tfoot:not(.full-width) th:first-child {
  -webkit-box-shadow: 0px 1px 0px 1px #FFFFFF;
          box-shadow: 0px 1px 0px 1px #FFFFFF;
}

/* Highlight Defining Column */
.ui.definition.table tr td:first-child:not(.ignored),
.ui.definition.table tr td.definition {
  background: rgba(0, 0, 0, 0.03);
  font-weight: bold;
  color: rgba(0, 0, 0, 0.95);
  text-transform: '';
  -webkit-box-shadow: '';
          box-shadow: '';
  text-align: '';
  font-size: 1em;
  padding-left: '';
  padding-right: '';
}

/* Fix 2nd Column */
.ui.definition.table thead:not(.full-width) th:nth-child(2) {
  border-left: 1px solid rgba(34, 36, 38, 0.15);
}
.ui.definition.table tfoot:not(.full-width) th:nth-child(2) {
  border-left: 1px solid rgba(34, 36, 38, 0.15);
}
.ui.definition.table td:nth-child(2) {
  border-left: 1px solid rgba(34, 36, 38, 0.15);
}


/*******************************
             States
*******************************/


/*--------------
    Positive
---------------*/

.ui.table tr.positive,
.ui.table td.positive {
  -webkit-box-shadow: 0px 0px 0px #A3C293 inset;
          box-shadow: 0px 0px 0px #A3C293 inset;
}
.ui.table tr.positive,
.ui.table td.positive {
  background: #FCFFF5 !important;
  color: #2C662D !important;
}

/*--------------
     Negative
---------------*/

.ui.table tr.negative,
.ui.table td.negative {
  -webkit-box-shadow: 0px 0px 0px #E0B4B4 inset;
          box-shadow: 0px 0px 0px #E0B4B4 inset;
}
.ui.table tr.negative,
.ui.table td.negative {
  background: #FFF6F6 !important;
  color: #9F3A38 !important;
}

/*--------------
      Error
---------------*/

.ui.table tr.error,
.ui.table td.error {
  -webkit-box-shadow: 0px 0px 0px #E0B4B4 inset;
          box-shadow: 0px 0px 0px #E0B4B4 inset;
}
.ui.table tr.error,
.ui.table td.error {
  background: #FFF6F6 !important;
  color: #9F3A38 !important;
}

/*--------------
     Warning
---------------*/

.ui.table tr.warning,
.ui.table td.warning {
  -webkit-box-shadow: 0px 0px 0px #C9BA9B inset;
          box-shadow: 0px 0px 0px #C9BA9B inset;
}
.ui.table tr.warning,
.ui.table td.warning {
  background: #FFFAF3 !important;
  color: #573A08 !important;
}

/*--------------
     Active
---------------*/

.ui.table tr.active,
.ui.table td.active {
  -webkit-box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.87) inset;
          box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.87) inset;
}
.ui.table tr.active,
.ui.table td.active {
  background: #E0E0E0 !important;
  color: rgba(0, 0, 0, 0.87) !important;
}

/*--------------
     Disabled
---------------*/

.ui.table tr.disabled td,
.ui.table tr td.disabled,
.ui.table tr.disabled:hover,
.ui.table tr:hover td.disabled {
  pointer-events: none;
  color: rgba(40, 40, 40, 0.3);
}


/*******************************
          Variations
*******************************/


/*--------------
    Stackable
---------------*/

@media only screen and (max-width: 991px) {
  .ui[class*="tablet stackable"].table,
  .ui[class*="tablet stackable"].table tbody,
  .ui[class*="tablet stackable"].table tr,
  .ui[class*="tablet stackable"].table tr > th,
  .ui[class*="tablet stackable"].table tr > td {
    width: 100% !important;
    display: block !important;
  }
  .ui[class*="tablet stackable"].table {
    padding: 0em;
  }
  .ui[class*="tablet stackable"].table thead {
    display: block;
  }
  .ui[class*="tablet stackable"].table tfoot {
    display: block;
  }
  .ui[class*="tablet stackable"].table tr {
    padding-top: 1em;
    padding-bottom: 1em;
    -webkit-box-shadow: 0px -1px 0px 0px rgba(0, 0, 0, 0.1) inset !important;
            box-shadow: 0px -1px 0px 0px rgba(0, 0, 0, 0.1) inset !important;
  }
  .ui[class*="tablet stackable"].table tr > th,
  .ui[class*="tablet stackable"].table tr > td {
    background: none;
    border: none !important;
    padding: 0.25em 0.75em;
    -webkit-box-shadow: none !important;
            box-shadow: none !important;
  }

/* Definition Table */
  .ui.definition[class*="tablet stackable"].table thead th:first-child {
    -webkit-box-shadow: none !important;
            box-shadow: none !important;
  }
}

/*--------------
 Text Alignment
---------------*/

.ui.table[class*="left aligned"],
.ui.table [class*="left aligned"] {
  text-align: left;
}
.ui.table[class*="center aligned"],
.ui.table [class*="center aligned"] {
  text-align: center;
}
.ui.table[class*="right aligned"],
.ui.table [class*="right aligned"] {
  text-align: right;
}

/*------------------
 Vertical Alignment
------------------*/

.ui.table[class*="top aligned"],
.ui.table [class*="top aligned"] {
  vertical-align: top;
}
.ui.table[class*="middle aligned"],
.ui.table [class*="middle aligned"] {
  vertical-align: middle;
}
.ui.table[class*="bottom aligned"],
.ui.table [class*="bottom aligned"] {
  vertical-align: bottom;
}

/*--------------
    Collapsing
---------------*/

.ui.table th.collapsing,
.ui.table td.collapsing {
  width: 1px;
  white-space: nowrap;
}

/*--------------
     Fixed
---------------*/

.ui.fixed.table {
  table-layout: fixed;
}
.ui.fixed.table th,
.ui.fixed.table td {
  overflow: hidden;
  text-overflow: ellipsis;
}

/*--------------
   Selectable
---------------*/

.ui.selectable.table tbody tr:hover,
.ui.table tbody tr td.selectable:hover {
  background: rgba(0, 0, 0, 0.05) !important;
  color: rgba(0, 0, 0, 0.95) !important;
}
.ui.selectable.inverted.table tbody tr:hover,
.ui.inverted.table tbody tr td.selectable:hover {
  background: rgba(255, 255, 255, 0.08) !important;
  color: #ffffff !important;
}

/* Selectable Cell Link */
.ui.table tbody tr td.selectable {
  padding: 0em;
}
.ui.table tbody tr td.selectable > a:not(.ui) {
  display: block;
  color: inherit;
  padding: 0.78571429em 0.78571429em;
}

/* Other States */
.ui.selectable.table tr.error:hover,
.ui.table tr td.selectable.error:hover,
.ui.selectable.table tr:hover td.error {
  background: #ffe7e7 !important;
  color: #943634 !important;
}
.ui.selectable.table tr.warning:hover,
.ui.table tr td.selectable.warning:hover,
.ui.selectable.table tr:hover td.warning {
  background: #fff4e4 !important;
  color: #493107 !important;
}
.ui.selectable.table tr.active:hover,
.ui.table tr td.selectable.active:hover,
.ui.selectable.table tr:hover td.active {
  background: #E0E0E0 !important;
  color: rgba(0, 0, 0, 0.87) !important;
}
.ui.selectable.table tr.positive:hover,
.ui.table tr td.selectable.positive:hover,
.ui.selectable.table tr:hover td.positive {
  background: #f7ffe6 !important;
  color: #275b28 !important;
}
.ui.selectable.table tr.negative:hover,
.ui.table tr td.selectable.negative:hover,
.ui.selectable.table tr:hover td.negative {
  background: #ffe7e7 !important;
  color: #943634 !important;
}

/*-------------------
      Attached
--------------------*/


/* Middle */
.ui.attached.table {
  top: 0px;
  bottom: 0px;
  border-radius: 0px;
  margin: 0em -1px;
  width: calc(100% +  2px );
  max-width: calc(100% +  2px );
  -webkit-box-shadow: none;
          box-shadow: none;
  border: 1px solid #D4D4D5;
}
.ui.attached + .ui.attached.table:not(.top) {
  border-top: none;
}

/* Top */
.ui[class*="top attached"].table {
  bottom: 0px;
  margin-bottom: 0em;
  top: 0px;
  margin-top: 1em;
  border-radius: 0.28571429rem 0.28571429rem 0em 0em;
}
.ui.table[class*="top attached"]:first-child {
  margin-top: 0em;
}

/* Bottom */
.ui[class*="bottom attached"].table {
  bottom: 0px;
  margin-top: 0em;
  top: 0px;
  margin-bottom: 1em;
  -webkit-box-shadow: none, none;
          box-shadow: none, none;
  border-radius: 0em 0em 0.28571429rem 0.28571429rem;
}
.ui[class*="bottom attached"].table:last-child {
  margin-bottom: 0em;
}

/*--------------
     Striped
---------------*/


/* Table Striping */
.ui.striped.table > tr:nth-child(2n),
.ui.striped.table tbody tr:nth-child(2n) {
  background-color: rgba(0, 0, 50, 0.02);
}

/* Stripes */
.ui.inverted.striped.table > tr:nth-child(2n),
.ui.inverted.striped.table tbody tr:nth-child(2n) {
  background-color: rgba(255, 255, 255, 0.05);
}

/* Allow striped active hover */
.ui.striped.selectable.selectable.selectable.table tbody tr.active:hover {
  background: #EFEFEF !important;
  color: rgba(0, 0, 0, 0.95) !important;
}

/*--------------
   Single Line
---------------*/

.ui.table[class*="single line"],
.ui.table [class*="single line"] {
  white-space: nowrap;
}
.ui.table[class*="single line"],
.ui.table [class*="single line"] {
  white-space: nowrap;
}

/*-------------------
       Colors
--------------------*/


/* Red */
.ui.red.table {
  border-top: 0.2em solid #DB2828;
}
.ui.inverted.red.table {
  background-color: #DB2828 !important;
  color: #FFFFFF !important;
}

/* Orange */
.ui.orange.table {
  border-top: 0.2em solid #F2711C;
}
.ui.inverted.orange.table {
  background-color: #F2711C !important;
  color: #FFFFFF !important;
}

/* Yellow */
.ui.yellow.table {
  border-top: 0.2em solid #FBBD08;
}
.ui.inverted.yellow.table {
  background-color: #FBBD08 !important;
  color: #FFFFFF !important;
}

/* Olive */
.ui.olive.table {
  border-top: 0.2em solid #B5CC18;
}
.ui.inverted.olive.table {
  background-color: #B5CC18 !important;
  color: #FFFFFF !important;
}

/* Green */
.ui.green.table {
  border-top: 0.2em solid #21BA45;
}
.ui.inverted.green.table {
  background-color: #21BA45 !important;
  color: #FFFFFF !important;
}

/* Teal */
.ui.teal.table {
  border-top: 0.2em solid #00B5AD;
}
.ui.inverted.teal.table {
  background-color: #00B5AD !important;
  color: #FFFFFF !important;
}

/* Blue */
.ui.blue.table {
  border-top: 0.2em solid #2185D0;
}
.ui.inverted.blue.table {
  background-color: #2185D0 !important;
  color: #FFFFFF !important;
}

/* Violet */
.ui.violet.table {
  border-top: 0.2em solid #6435C9;
}
.ui.inverted.violet.table {
  background-color: #6435C9 !important;
  color: #FFFFFF !important;
}

/* Purple */
.ui.purple.table {
  border-top: 0.2em solid #A333C8;
}
.ui.inverted.purple.table {
  background-color: #A333C8 !important;
  color: #FFFFFF !important;
}

/* Pink */
.ui.pink.table {
  border-top: 0.2em solid #E03997;
}
.ui.inverted.pink.table {
  background-color: #E03997 !important;
  color: #FFFFFF !important;
}

/* Brown */
.ui.brown.table {
  border-top: 0.2em solid #A5673F;
}
.ui.inverted.brown.table {
  background-color: #A5673F !important;
  color: #FFFFFF !important;
}

/* Grey */
.ui.grey.table {
  border-top: 0.2em solid #767676;
}
.ui.inverted.grey.table {
  background-color: #767676 !important;
  color: #FFFFFF !important;
}

/* Black */
.ui.black.table {
  border-top: 0.2em solid #1B1C1D;
}
.ui.inverted.black.table {
  background-color: #1B1C1D !important;
  color: #FFFFFF !important;
}

/*--------------
  Column Count
---------------*/


/* Grid Based */
.ui.one.column.table td {
  width: 100%;
}
.ui.two.column.table td {
  width: 50%;
}
.ui.three.column.table td {
  width: 33.33333333%;
}
.ui.four.column.table td {
  width: 25%;
}
.ui.five.column.table td {
  width: 20%;
}
.ui.six.column.table td {
  width: 16.66666667%;
}
.ui.seven.column.table td {
  width: 14.28571429%;
}
.ui.eight.column.table td {
  width: 12.5%;
}
.ui.nine.column.table td {
  width: 11.11111111%;
}
.ui.ten.column.table td {
  width: 10%;
}
.ui.eleven.column.table td {
  width: 9.09090909%;
}
.ui.twelve.column.table td {
  width: 8.33333333%;
}
.ui.thirteen.column.table td {
  width: 7.69230769%;
}
.ui.fourteen.column.table td {
  width: 7.14285714%;
}
.ui.fifteen.column.table td {
  width: 6.66666667%;
}
.ui.sixteen.column.table td {
  width: 6.25%;
}

/* Column Width */
.ui.table th.one.wide,
.ui.table td.one.wide {
  width: 6.25%;
}
.ui.table th.two.wide,
.ui.table td.two.wide {
  width: 12.5%;
}
.ui.table th.three.wide,
.ui.table td.three.wide {
  width: 18.75%;
}
.ui.table th.four.wide,
.ui.table td.four.wide {
  width: 25%;
}
.ui.table th.five.wide,
.ui.table td.five.wide {
  width: 31.25%;
}
.ui.table th.six.wide,
.ui.table td.six.wide {
  width: 37.5%;
}
.ui.table th.seven.wide,
.ui.table td.seven.wide {
  width: 43.75%;
}
.ui.table th.eight.wide,
.ui.table td.eight.wide {
  width: 50%;
}
.ui.table th.nine.wide,
.ui.table td.nine.wide {
  width: 56.25%;
}
.ui.table th.ten.wide,
.ui.table td.ten.wide {
  width: 62.5%;
}
.ui.table th.eleven.wide,
.ui.table td.eleven.wide {
  width: 68.75%;
}
.ui.table th.twelve.wide,
.ui.table td.twelve.wide {
  width: 75%;
}
.ui.table th.thirteen.wide,
.ui.table td.thirteen.wide {
  width: 81.25%;
}
.ui.table th.fourteen.wide,
.ui.table td.fourteen.wide {
  width: 87.5%;
}
.ui.table th.fifteen.wide,
.ui.table td.fifteen.wide {
  width: 93.75%;
}
.ui.table th.sixteen.wide,
.ui.table td.sixteen.wide {
  width: 100%;
}

/*--------------
    Sortable
---------------*/

.ui.sortable.table thead th {
  cursor: pointer;
  white-space: nowrap;
  border-left: 1px solid rgba(34, 36, 38, 0.15);
  color: rgba(0, 0, 0, 0.87);
}
.ui.sortable.table thead th:first-child {
  border-left: none;
}
.ui.sortable.table thead th.sorted,
.ui.sortable.table thead th.sorted:hover {
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}
.ui.sortable.table thead th:after {
  display: none;
  font-style: normal;
  font-weight: normal;
  text-decoration: inherit;
  content: '';
  height: 1em;
  width: auto;
  opacity: 0.8;
  margin: 0em 0em 0em 0.5em;
  font-family: 'Icons';
}
.ui.sortable.table thead th.ascending:after {
  content: '\f0d8';
}
.ui.sortable.table thead th.descending:after {
  content: '\f0d7';
}

/* Hover */
.ui.sortable.table th.disabled:hover {
  cursor: auto;
  color: rgba(40, 40, 40, 0.3);
}
.ui.sortable.table thead th:hover {
  background: rgba(0, 0, 0, 0.05);
  color: rgba(0, 0, 0, 0.8);
}

/* Sorted */
.ui.sortable.table thead th.sorted {
  background: rgba(0, 0, 0, 0.05);
  color: rgba(0, 0, 0, 0.95);
}
.ui.sortable.table thead th.sorted:after {
  display: inline-block;
}

/* Sorted Hover */
.ui.sortable.table thead th.sorted:hover {
  background: rgba(0, 0, 0, 0.05);
  color: rgba(0, 0, 0, 0.95);
}

/* Inverted */
.ui.inverted.sortable.table thead th.sorted {
  background: rgba(255, 255, 255, 0.15) -webkit-gradient(linear, left top, left bottom, from(transparent), to(rgba(0, 0, 0, 0.05)));
  background: rgba(255, 255, 255, 0.15) -webkit-linear-gradient(transparent, rgba(0, 0, 0, 0.05));
  background: rgba(255, 255, 255, 0.15) linear-gradient(transparent, rgba(0, 0, 0, 0.05));
  color: #ffffff;
}
.ui.inverted.sortable.table thead th:hover {
  background: rgba(255, 255, 255, 0.08) -webkit-gradient(linear, left top, left bottom, from(transparent), to(rgba(0, 0, 0, 0.05)));
  background: rgba(255, 255, 255, 0.08) -webkit-linear-gradient(transparent, rgba(0, 0, 0, 0.05));
  background: rgba(255, 255, 255, 0.08) linear-gradient(transparent, rgba(0, 0, 0, 0.05));
  color: #ffffff;
}
.ui.inverted.sortable.table thead th {
  border-left-color: transparent;
  border-right-color: transparent;
}

/*--------------
    Inverted
---------------*/


/* Text Color */
.ui.inverted.table {
  background: #333333;
  color: rgba(255, 255, 255, 0.9);
  border: none;
}
.ui.inverted.table th {
  background-color: rgba(0, 0, 0, 0.15);
  border-color: rgba(255, 255, 255, 0.1) !important;
  color: rgba(255, 255, 255, 0.9) !important;
}
.ui.inverted.table tr td {
  border-color: rgba(255, 255, 255, 0.1) !important;
}
.ui.inverted.table tr.disabled td,
.ui.inverted.table tr td.disabled,
.ui.inverted.table tr.disabled:hover td,
.ui.inverted.table tr:hover td.disabled {
  pointer-events: none;
  color: rgba(225, 225, 225, 0.3);
}

/* Definition */
.ui.inverted.definition.table tfoot:not(.full-width) th:first-child,
.ui.inverted.definition.table thead:not(.full-width) th:first-child {
  background: #FFFFFF;
}
.ui.inverted.definition.table tr td:first-child {
  background: rgba(255, 255, 255, 0.02);
  color: #ffffff;
}

/*--------------
   Collapsing
---------------*/

.ui.collapsing.table {
  width: auto;
}

/*--------------
      Basic
---------------*/

.ui.basic.table {
  background: transparent;
  border: 1px solid rgba(34, 36, 38, 0.15);
  -webkit-box-shadow: none;
          box-shadow: none;
}
.ui.basic.table thead,
.ui.basic.table tfoot {
  -webkit-box-shadow: none;
          box-shadow: none;
}
.ui.basic.table th {
  background: transparent;
  border-left: none;
}
.ui.basic.table tbody tr {
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.ui.basic.table td {
  background: transparent;
}
.ui.basic.striped.table tbody tr:nth-child(2n) {
  background-color: rgba(0, 0, 0, 0.05) !important;
}

/* Very Basic */
.ui[class*="very basic"].table {
  border: none;
}
.ui[class*="very basic"].table:not(.sortable):not(.striped) th,
.ui[class*="very basic"].table:not(.sortable):not(.striped) td {
  padding: '';
}
.ui[class*="very basic"].table:not(.sortable):not(.striped) th:first-child,
.ui[class*="very basic"].table:not(.sortable):not(.striped) td:first-child {
  padding-left: 0em;
}
.ui[class*="very basic"].table:not(.sortable):not(.striped) th:last-child,
.ui[class*="very basic"].table:not(.sortable):not(.striped) td:last-child {
  padding-right: 0em;
}
.ui[class*="very basic"].table:not(.sortable):not(.striped) thead tr:first-child th {
  padding-top: 0em;
}

/*--------------
     Celled
---------------*/

.ui.celled.table tr th,
.ui.celled.table tr td {
  border-left: 1px solid rgba(34, 36, 38, 0.1);
}
.ui.celled.table tr th:first-child,
.ui.celled.table tr td:first-child {
  border-left: none;
}

/*--------------
     Padded
---------------*/

.ui.padded.table th {
  padding-left: 1em;
  padding-right: 1em;
}
.ui.padded.table th,
.ui.padded.table td {
  padding: 1em 1em;
}

/* Very */
.ui[class*="very padded"].table th {
  padding-left: 1.5em;
  padding-right: 1.5em;
}
.ui[class*="very padded"].table td {
  padding: 1.5em 1.5em;
}

/*--------------
     Compact
---------------*/

.ui.compact.table th {
  padding-left: 0.7em;
  padding-right: 0.7em;
}
.ui.compact.table td {
  padding: 0.5em 0.7em;
}

/* Very */
.ui[class*="very compact"].table th {
  padding-left: 0.6em;
  padding-right: 0.6em;
}
.ui[class*="very compact"].table td {
  padding: 0.4em 0.6em;
}

/*--------------
      Sizes
---------------*/


/* Small */
.ui.small.table {
  font-size: 0.9em;
}

/* Standard */
.ui.table {
  font-size: 1em;
}

/* Large */
.ui.large.table {
  font-size: 1.1em;
}


/*******************************
         Site Overrides
*******************************/


</style>
