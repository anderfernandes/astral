
<!DOCTYPE html>
<html>
<head>
  <!-- Standard Meta -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

  <!-- Reset -->
  <style>
     /*
      * # Semantic UI - 2.4.2
      * https://github.com/Semantic-Org/Semantic-UI
      * http://www.semantic-ui.com/
      *
      * Copyright 2014 Contributors
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */
      /*!
      * # Semantic UI - Reset
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

  </style>

  <!-- Site -->
  <style>
     /*
      * # Semantic UI - 2.4.2
      * https://github.com/Semantic-Org/Semantic-UI
      * http://www.semantic-ui.com/
      *
      * Copyright 2014 Contributors
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */
      /*!
      * # Semantic UI - Site
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

      @import url('https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic&subset=latin');
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
              Scrollbars
      *******************************/



      /*******************************
                Highlighting
      *******************************/


      /* Site */
      ::-webkit-selection {
        background-color: #CCE2FF;
        color: rgba(0, 0, 0, 0.87);
      }
      ::-moz-selection {
        background-color: #CCE2FF;
        color: rgba(0, 0, 0, 0.87);
      }
      ::selection {
        background-color: #CCE2FF;
        color: rgba(0, 0, 0, 0.87);
      }

      /* Form */
      textarea::-webkit-selection,
      input::-webkit-selection {
        background-color: rgba(100, 100, 100, 0.4);
        color: rgba(0, 0, 0, 0.87);
      }
      textarea::-moz-selection,
      input::-moz-selection {
        background-color: rgba(100, 100, 100, 0.4);
        color: rgba(0, 0, 0, 0.87);
      }
      textarea::selection,
      input::selection {
        background-color: rgba(100, 100, 100, 0.4);
        color: rgba(0, 0, 0, 0.87);
      }

      /* Force Simple Scrollbars */
      body ::-webkit-scrollbar {
        -webkit-appearance: none;
        width: 10px;
        height: 10px;
      }
      body ::-webkit-scrollbar-track {
        background: rgba(0, 0, 0, 0.1);
        border-radius: 0px;
      }
      body ::-webkit-scrollbar-thumb {
        cursor: pointer;
        border-radius: 5px;
        background: rgba(0, 0, 0, 0.25);
        -webkit-transition: color 0.2s ease;
        transition: color 0.2s ease;
      }
      body ::-webkit-scrollbar-thumb:window-inactive {
        background: rgba(0, 0, 0, 0.15);
      }
      body ::-webkit-scrollbar-thumb:hover {
        background: rgba(128, 135, 139, 0.8);
      }

      /* Inverted UI */
      body .ui.inverted::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
      }
      body .ui.inverted::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.25);
      }
      body .ui.inverted::-webkit-scrollbar-thumb:window-inactive {
        background: rgba(255, 255, 255, 0.15);
      }
      body .ui.inverted::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.35);
      }


      /*******************************
              Global Overrides
      *******************************/



      /*******************************
              Site Overrides
      *******************************/

  </style>
  
  <!--- Container --->
  <style>
     /*
      * # Semantic UI - 2.4.2
      * https://github.com/Semantic-Org/Semantic-UI
      * http://www.semantic-ui.com/
      *
      * Copyright 2014 Contributors
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */
      /*!
      * # Semantic UI - Container
      * http://github.com/semantic-org/semantic-ui/
      *
      *
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */


      /*******************************
                  Container
      *******************************/


      /* All Sizes */
      .ui.container {
        display: block;
        max-width: 100% !important;
      }

      /* Mobile */
      @media only screen and (max-width: 767px) {
        .ui.container {
          width: auto !important;
          margin-left: 1em !important;
          margin-right: 1em !important;
        }
        .ui.grid.container {
          width: auto !important;
        }
        .ui.relaxed.grid.container {
          width: auto !important;
        }
        .ui.very.relaxed.grid.container {
          width: auto !important;
        }
      }

      /* Tablet */
      @media only screen and (min-width: 768px) and (max-width: 991px) {
        .ui.container {
          width: 723px;
          margin-left: auto !important;
          margin-right: auto !important;
        }
        .ui.grid.container {
          width: calc( 723px  +  2rem ) !important;
        }
        .ui.relaxed.grid.container {
          width: calc( 723px  +  3rem ) !important;
        }
        .ui.very.relaxed.grid.container {
          width: calc( 723px  +  5rem ) !important;
        }
      }

      /* Small Monitor */
      @media only screen and (min-width: 992px) and (max-width: 1199px) {
        .ui.container {
          width: 933px;
          margin-left: auto !important;
          margin-right: auto !important;
        }
        .ui.grid.container {
          width: calc( 933px  +  2rem ) !important;
        }
        .ui.relaxed.grid.container {
          width: calc( 933px  +  3rem ) !important;
        }
        .ui.very.relaxed.grid.container {
          width: calc( 933px  +  5rem ) !important;
        }
      }

      /* Large Monitor */
      @media only screen and (min-width: 1200px) {
        .ui.container {
          width: 1127px;
          margin-left: auto !important;
          margin-right: auto !important;
        }
        .ui.grid.container {
          width: calc( 1127px  +  2rem ) !important;
        }
        .ui.relaxed.grid.container {
          width: calc( 1127px  +  3rem ) !important;
        }
        .ui.very.relaxed.grid.container {
          width: calc( 1127px  +  5rem ) !important;
        }
      }


      /*******************************
                  Types
      *******************************/


      /* Text Container */
      .ui.text.container {
        font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
        max-width: 700px !important;
        line-height: 1.5;
      }
      .ui.text.container {
        font-size: 1.14285714rem;
      }

      /* Fluid */
      .ui.fluid.container {
        width: 100%;
      }


      /*******************************
                Variations
      *******************************/

      .ui[class*="left aligned"].container {
        text-align: left;
      }
      .ui[class*="center aligned"].container {
        text-align: center;
      }
      .ui[class*="right aligned"].container {
        text-align: right;
      }
      .ui.justified.container {
        text-align: justify;
        -webkit-hyphens: auto;
            -ms-hyphens: auto;
                hyphens: auto;
      }


      /*******************************
              Theme Overrides
      *******************************/



      /*******************************
              Site Overrides
      *******************************/

  </style>

  <!--- Divider --->
  <style>
     /*
      * # Semantic UI - 2.4.2
      * https://github.com/Semantic-Org/Semantic-UI
      * http://www.semantic-ui.com/
      *
      * Copyright 2014 Contributors
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */
      /*!
      * # Semantic UI - Divider
      * http://github.com/semantic-org/semantic-ui/
      *
      *
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */


      /*******************************
                  Divider
      *******************************/

      .ui.divider {
        margin: 1rem 0rem;
        line-height: 1;
        height: 0em;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: rgba(0, 0, 0, 0.85);
        -webkit-user-select: none;
          -moz-user-select: none;
            -ms-user-select: none;
                user-select: none;
        -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
      }

      /*--------------
            Basic
      ---------------*/

      .ui.divider:not(.vertical):not(.horizontal) {
        border-top: 1px solid rgba(34, 36, 38, 0.15);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      }

      /*--------------
          Coupling
      ---------------*/


      /* Allow divider between each column row */
      .ui.grid > .column + .divider,
      .ui.grid > .row > .column + .divider {
        left: auto;
      }

      /*--------------
        Horizontal
      ---------------*/

      .ui.horizontal.divider {
        display: table;
        white-space: nowrap;
        height: auto;
        margin: '';
        line-height: 1;
        text-align: center;
      }
      .ui.horizontal.divider:before,
      .ui.horizontal.divider:after {
        content: '';
        display: table-cell;
        position: relative;
        top: 50%;
        width: 50%;
        background-repeat: no-repeat;
      }
      .ui.horizontal.divider:before {
        background-position: right 1em top 50%;
      }
      .ui.horizontal.divider:after {
        background-position: left 1em top 50%;
      }

      /*--------------
          Vertical
      ---------------*/

      .ui.vertical.divider {
        position: absolute;
        z-index: 2;
        top: 50%;
        left: 50%;
        margin: 0rem;
        padding: 0em;
        width: auto;
        height: 50%;
        line-height: 0em;
        text-align: center;
        -webkit-transform: translateX(-50%);
                transform: translateX(-50%);
      }
      .ui.vertical.divider:before,
      .ui.vertical.divider:after {
        position: absolute;
        left: 50%;
        content: '';
        z-index: 3;
        border-left: 1px solid rgba(34, 36, 38, 0.15);
        border-right: 1px solid rgba(255, 255, 255, 0.1);
        width: 0%;
        height: calc(100% -  1rem );
      }
      .ui.vertical.divider:before {
        top: -100%;
      }
      .ui.vertical.divider:after {
        top: auto;
        bottom: 0px;
      }

      /* Inside grid */
      @media only screen and (max-width: 767px) {
        .ui.stackable.grid .ui.vertical.divider,
        .ui.grid .stackable.row .ui.vertical.divider {
          display: table;
          white-space: nowrap;
          height: auto;
          margin: '';
          overflow: hidden;
          line-height: 1;
          text-align: center;
          position: static;
          top: 0;
          left: 0;
          -webkit-transform: none;
                  transform: none;
        }
        .ui.stackable.grid .ui.vertical.divider:before,
        .ui.grid .stackable.row .ui.vertical.divider:before,
        .ui.stackable.grid .ui.vertical.divider:after,
        .ui.grid .stackable.row .ui.vertical.divider:after {
          position: static;
          left: 0;
          border-left: none;
          border-right: none;
          content: '';
          display: table-cell;
          position: relative;
          top: 50%;
          width: 50%;
          background-repeat: no-repeat;
        }
        .ui.stackable.grid .ui.vertical.divider:before,
        .ui.grid .stackable.row .ui.vertical.divider:before {
          background-position: right 1em top 50%;
        }
        .ui.stackable.grid .ui.vertical.divider:after,
        .ui.grid .stackable.row .ui.vertical.divider:after {
          background-position: left 1em top 50%;
        }
      }

      /*--------------
            Icon
      ---------------*/

      .ui.divider > .icon {
        margin: 0rem;
        font-size: 1rem;
        height: 1em;
        vertical-align: middle;
      }


      /*******************************
                Variations
      *******************************/


      /*--------------
          Hidden
      ---------------*/

      .ui.hidden.divider {
        border-color: transparent !important;
      }
      .ui.hidden.divider:before,
      .ui.hidden.divider:after {
        display: none;
      }

      /*--------------
          Inverted
      ---------------*/

      .ui.divider.inverted,
      .ui.vertical.inverted.divider,
      .ui.horizontal.inverted.divider {
        color: #FFFFFF;
      }
      .ui.divider.inverted,
      .ui.divider.inverted:after,
      .ui.divider.inverted:before {
        border-top-color: rgba(34, 36, 38, 0.15) !important;
        border-left-color: rgba(34, 36, 38, 0.15) !important;
        border-bottom-color: rgba(255, 255, 255, 0.15) !important;
        border-right-color: rgba(255, 255, 255, 0.15) !important;
      }

      /*--------------
          Fitted
      ---------------*/

      .ui.fitted.divider {
        margin: 0em;
      }

      /*--------------
          Clearing
      ---------------*/

      .ui.clearing.divider {
        clear: both;
      }

      /*--------------
          Section
      ---------------*/

      .ui.section.divider {
        margin-top: 2rem;
        margin-bottom: 2rem;
      }

      /*--------------
          Sizes
      ---------------*/

      .ui.divider {
        font-size: 1rem;
      }


      /*******************************
              Theme Overrides
      *******************************/

      .ui.horizontal.divider:before,
      .ui.horizontal.divider:after {
        background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABaAAAAACCAYAAACuTHuKAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo1OThBRDY4OUNDMTYxMUU0OUE3NUVGOEJDMzMzMjE2NyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo1OThBRDY4QUNDMTYxMUU0OUE3NUVGOEJDMzMzMjE2NyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjU5OEFENjg3Q0MxNjExRTQ5QTc1RUY4QkMzMzMyMTY3IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjU5OEFENjg4Q0MxNjExRTQ5QTc1RUY4QkMzMzMyMTY3Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+VU513gAAADVJREFUeNrs0DENACAQBDBIWLGBJQby/mUcJn5sJXQmOQMAAAAAAJqt+2prAAAAAACg2xdgANk6BEVuJgyMAAAAAElFTkSuQmCC');
      }
      @media only screen and (max-width: 767px) {
        .ui.stackable.grid .ui.vertical.divider:before,
        .ui.grid .stackable.row .ui.vertical.divider:before,
        .ui.stackable.grid .ui.vertical.divider:after,
        .ui.grid .stackable.row .ui.vertical.divider:after {
          background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABaAAAAACCAYAAACuTHuKAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo1OThBRDY4OUNDMTYxMUU0OUE3NUVGOEJDMzMzMjE2NyIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDo1OThBRDY4QUNDMTYxMUU0OUE3NUVGOEJDMzMzMjE2NyI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjU5OEFENjg3Q0MxNjExRTQ5QTc1RUY4QkMzMzMyMTY3IiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjU5OEFENjg4Q0MxNjExRTQ5QTc1RUY4QkMzMzMyMTY3Ii8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+VU513gAAADVJREFUeNrs0DENACAQBDBIWLGBJQby/mUcJn5sJXQmOQMAAAAAAJqt+2prAAAAAACg2xdgANk6BEVuJgyMAAAAAElFTkSuQmCC');
        }
      }


      /*******************************
              Site Overrides
      *******************************/

  </style>

  <!--- Grid --->
  <style>
     /*
      * # Semantic UI - 2.4.2
      * https://github.com/Semantic-Org/Semantic-UI
      * http://www.semantic-ui.com/
      *
      * Copyright 2014 Contributors
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */
      /*!
      * # Semantic UI - Grid
      * http://github.com/semantic-org/semantic-ui/
      *
      *
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */


      /*******************************
                  Standard
      *******************************/

      .ui.grid {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
            -ms-flex-direction: row;
                flex-direction: row;
        -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        -webkit-box-align: stretch;
            -ms-flex-align: stretch;
                align-items: stretch;
        padding: 0em;
      }

      /*----------------------
            Remove Gutters
      -----------------------*/

      .ui.grid {
        margin-top: -1rem;
        margin-bottom: -1rem;
        margin-left: -1rem;
        margin-right: -1rem;
      }
      .ui.relaxed.grid {
        margin-left: -1.5rem;
        margin-right: -1.5rem;
      }
      .ui[class*="very relaxed"].grid {
        margin-left: -2.5rem;
        margin-right: -2.5rem;
      }

      /* Preserve Rows Spacing on Consecutive Grids */
      .ui.grid + .grid {
        margin-top: 1rem;
      }

      /*-------------------
            Columns
      --------------------*/


      /* Standard 16 column */
      .ui.grid > .column:not(.row),
      .ui.grid > .row > .column {
        position: relative;
        display: inline-block;
        width: 6.25%;
        padding-left: 1rem;
        padding-right: 1rem;
        vertical-align: top;
      }
      .ui.grid > * {
        padding-left: 1rem;
        padding-right: 1rem;
      }

      /*-------------------
              Rows
      --------------------*/

      .ui.grid > .row {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
            -ms-flex-direction: row;
                flex-direction: row;
        -ms-flex-wrap: wrap;
            flex-wrap: wrap;
        -webkit-box-pack: inherit;
            -ms-flex-pack: inherit;
                justify-content: inherit;
        -webkit-box-align: stretch;
            -ms-flex-align: stretch;
                align-items: stretch;
        width: 100% !important;
        padding: 0rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
      }

      /*-------------------
            Columns
      --------------------*/


      /* Vertical padding when no rows */
      .ui.grid > .column:not(.row) {
        padding-top: 1rem;
        padding-bottom: 1rem;
      }
      .ui.grid > .row > .column {
        margin-top: 0em;
        margin-bottom: 0em;
      }

      /*-------------------
            Content
      --------------------*/

      .ui.grid > .row > img,
      .ui.grid > .row > .column > img {
        max-width: 100%;
      }

      /*-------------------
          Loose Coupling
      --------------------*/


      /* Collapse Margin on Consecutive Grid */
      .ui.grid > .ui.grid:first-child {
        margin-top: 0em;
      }
      .ui.grid > .ui.grid:last-child {
        margin-bottom: 0em;
      }

      /* Segment inside Aligned Grid */
      .ui.grid .aligned.row > .column > .segment:not(.compact):not(.attached),
      .ui.aligned.grid .column > .segment:not(.compact):not(.attached) {
        width: 100%;
      }

      /* Align Dividers with Gutter */
      .ui.grid .row + .ui.divider {
        -webkit-box-flex: 1;
            -ms-flex-positive: 1;
                flex-grow: 1;
        margin: 1rem 1rem;
      }
      .ui.grid .column + .ui.vertical.divider {
        height: calc(50% - (2rem / 2));
      }

      /* Remove Border on Last Horizontal Segment */
      .ui.grid > .row > .column:last-child > .horizontal.segment,
      .ui.grid > .column:last-child > .horizontal.segment {
        -webkit-box-shadow: none;
                box-shadow: none;
      }


      /*******************************
                Variations
      *******************************/


      /*-----------------------
            Page Grid
      -------------------------*/

      @media only screen and (max-width: 767px) {
        .ui.page.grid {
          width: auto;
          padding-left: 0em;
          padding-right: 0em;
          margin-left: 0em;
          margin-right: 0em;
        }
      }
      @media only screen and (min-width: 768px) and (max-width: 991px) {
        .ui.page.grid {
          width: auto;
          margin-left: 0em;
          margin-right: 0em;
          padding-left: 2em;
          padding-right: 2em;
        }
      }
      @media only screen and (min-width: 992px) and (max-width: 1199px) {
        .ui.page.grid {
          width: auto;
          margin-left: 0em;
          margin-right: 0em;
          padding-left: 3%;
          padding-right: 3%;
        }
      }
      @media only screen and (min-width: 1200px) and (max-width: 1919px) {
        .ui.page.grid {
          width: auto;
          margin-left: 0em;
          margin-right: 0em;
          padding-left: 15%;
          padding-right: 15%;
        }
      }
      @media only screen and (min-width: 1920px) {
        .ui.page.grid {
          width: auto;
          margin-left: 0em;
          margin-right: 0em;
          padding-left: 23%;
          padding-right: 23%;
        }
      }

      /*-------------------
          Column Count
      --------------------*/


      /* Assume full width with one column */
      .ui.grid > .column:only-child,
      .ui.grid > .row > .column:only-child {
        width: 100%;
      }

      /* Grid Based */
      .ui[class*="one column"].grid > .row > .column,
      .ui[class*="one column"].grid > .column:not(.row) {
        width: 100%;
      }
      .ui[class*="two column"].grid > .row > .column,
      .ui[class*="two column"].grid > .column:not(.row) {
        width: 50%;
      }
      .ui[class*="three column"].grid > .row > .column,
      .ui[class*="three column"].grid > .column:not(.row) {
        width: 33.33333333%;
      }
      .ui[class*="four column"].grid > .row > .column,
      .ui[class*="four column"].grid > .column:not(.row) {
        width: 25%;
      }
      .ui[class*="five column"].grid > .row > .column,
      .ui[class*="five column"].grid > .column:not(.row) {
        width: 20%;
      }
      .ui[class*="six column"].grid > .row > .column,
      .ui[class*="six column"].grid > .column:not(.row) {
        width: 16.66666667%;
      }
      .ui[class*="seven column"].grid > .row > .column,
      .ui[class*="seven column"].grid > .column:not(.row) {
        width: 14.28571429%;
      }
      .ui[class*="eight column"].grid > .row > .column,
      .ui[class*="eight column"].grid > .column:not(.row) {
        width: 12.5%;
      }
      .ui[class*="nine column"].grid > .row > .column,
      .ui[class*="nine column"].grid > .column:not(.row) {
        width: 11.11111111%;
      }
      .ui[class*="ten column"].grid > .row > .column,
      .ui[class*="ten column"].grid > .column:not(.row) {
        width: 10%;
      }
      .ui[class*="eleven column"].grid > .row > .column,
      .ui[class*="eleven column"].grid > .column:not(.row) {
        width: 9.09090909%;
      }
      .ui[class*="twelve column"].grid > .row > .column,
      .ui[class*="twelve column"].grid > .column:not(.row) {
        width: 8.33333333%;
      }
      .ui[class*="thirteen column"].grid > .row > .column,
      .ui[class*="thirteen column"].grid > .column:not(.row) {
        width: 7.69230769%;
      }
      .ui[class*="fourteen column"].grid > .row > .column,
      .ui[class*="fourteen column"].grid > .column:not(.row) {
        width: 7.14285714%;
      }
      .ui[class*="fifteen column"].grid > .row > .column,
      .ui[class*="fifteen column"].grid > .column:not(.row) {
        width: 6.66666667%;
      }
      .ui[class*="sixteen column"].grid > .row > .column,
      .ui[class*="sixteen column"].grid > .column:not(.row) {
        width: 6.25%;
      }

      /* Row Based Overrides */
      .ui.grid > [class*="one column"].row > .column {
        width: 100% !important;
      }
      .ui.grid > [class*="two column"].row > .column {
        width: 50% !important;
      }
      .ui.grid > [class*="three column"].row > .column {
        width: 33.33333333% !important;
      }
      .ui.grid > [class*="four column"].row > .column {
        width: 25% !important;
      }
      .ui.grid > [class*="five column"].row > .column {
        width: 20% !important;
      }
      .ui.grid > [class*="six column"].row > .column {
        width: 16.66666667% !important;
      }
      .ui.grid > [class*="seven column"].row > .column {
        width: 14.28571429% !important;
      }
      .ui.grid > [class*="eight column"].row > .column {
        width: 12.5% !important;
      }
      .ui.grid > [class*="nine column"].row > .column {
        width: 11.11111111% !important;
      }
      .ui.grid > [class*="ten column"].row > .column {
        width: 10% !important;
      }
      .ui.grid > [class*="eleven column"].row > .column {
        width: 9.09090909% !important;
      }
      .ui.grid > [class*="twelve column"].row > .column {
        width: 8.33333333% !important;
      }
      .ui.grid > [class*="thirteen column"].row > .column {
        width: 7.69230769% !important;
      }
      .ui.grid > [class*="fourteen column"].row > .column {
        width: 7.14285714% !important;
      }
      .ui.grid > [class*="fifteen column"].row > .column {
        width: 6.66666667% !important;
      }
      .ui.grid > [class*="sixteen column"].row > .column {
        width: 6.25% !important;
      }

      /* Celled Page */
      .ui.celled.page.grid {
        -webkit-box-shadow: none;
                box-shadow: none;
      }

      /*-------------------
          Column Width
      --------------------*/


      /* Sizing Combinations */
      .ui.grid > .row > [class*="one wide"].column,
      .ui.grid > .column.row > [class*="one wide"].column,
      .ui.grid > [class*="one wide"].column,
      .ui.column.grid > [class*="one wide"].column {
        width: 6.25% !important;
      }
      .ui.grid > .row > [class*="two wide"].column,
      .ui.grid > .column.row > [class*="two wide"].column,
      .ui.grid > [class*="two wide"].column,
      .ui.column.grid > [class*="two wide"].column {
        width: 12.5% !important;
      }
      .ui.grid > .row > [class*="three wide"].column,
      .ui.grid > .column.row > [class*="three wide"].column,
      .ui.grid > [class*="three wide"].column,
      .ui.column.grid > [class*="three wide"].column {
        width: 18.75% !important;
      }
      .ui.grid > .row > [class*="four wide"].column,
      .ui.grid > .column.row > [class*="four wide"].column,
      .ui.grid > [class*="four wide"].column,
      .ui.column.grid > [class*="four wide"].column {
        width: 25% !important;
      }
      .ui.grid > .row > [class*="five wide"].column,
      .ui.grid > .column.row > [class*="five wide"].column,
      .ui.grid > [class*="five wide"].column,
      .ui.column.grid > [class*="five wide"].column {
        width: 31.25% !important;
      }
      .ui.grid > .row > [class*="six wide"].column,
      .ui.grid > .column.row > [class*="six wide"].column,
      .ui.grid > [class*="six wide"].column,
      .ui.column.grid > [class*="six wide"].column {
        width: 37.5% !important;
      }
      .ui.grid > .row > [class*="seven wide"].column,
      .ui.grid > .column.row > [class*="seven wide"].column,
      .ui.grid > [class*="seven wide"].column,
      .ui.column.grid > [class*="seven wide"].column {
        width: 43.75% !important;
      }
      .ui.grid > .row > [class*="eight wide"].column,
      .ui.grid > .column.row > [class*="eight wide"].column,
      .ui.grid > [class*="eight wide"].column,
      .ui.column.grid > [class*="eight wide"].column {
        width: 50% !important;
      }
      .ui.grid > .row > [class*="nine wide"].column,
      .ui.grid > .column.row > [class*="nine wide"].column,
      .ui.grid > [class*="nine wide"].column,
      .ui.column.grid > [class*="nine wide"].column {
        width: 56.25% !important;
      }
      .ui.grid > .row > [class*="ten wide"].column,
      .ui.grid > .column.row > [class*="ten wide"].column,
      .ui.grid > [class*="ten wide"].column,
      .ui.column.grid > [class*="ten wide"].column {
        width: 62.5% !important;
      }
      .ui.grid > .row > [class*="eleven wide"].column,
      .ui.grid > .column.row > [class*="eleven wide"].column,
      .ui.grid > [class*="eleven wide"].column,
      .ui.column.grid > [class*="eleven wide"].column {
        width: 68.75% !important;
      }
      .ui.grid > .row > [class*="twelve wide"].column,
      .ui.grid > .column.row > [class*="twelve wide"].column,
      .ui.grid > [class*="twelve wide"].column,
      .ui.column.grid > [class*="twelve wide"].column {
        width: 75% !important;
      }
      .ui.grid > .row > [class*="thirteen wide"].column,
      .ui.grid > .column.row > [class*="thirteen wide"].column,
      .ui.grid > [class*="thirteen wide"].column,
      .ui.column.grid > [class*="thirteen wide"].column {
        width: 81.25% !important;
      }
      .ui.grid > .row > [class*="fourteen wide"].column,
      .ui.grid > .column.row > [class*="fourteen wide"].column,
      .ui.grid > [class*="fourteen wide"].column,
      .ui.column.grid > [class*="fourteen wide"].column {
        width: 87.5% !important;
      }
      .ui.grid > .row > [class*="fifteen wide"].column,
      .ui.grid > .column.row > [class*="fifteen wide"].column,
      .ui.grid > [class*="fifteen wide"].column,
      .ui.column.grid > [class*="fifteen wide"].column {
        width: 93.75% !important;
      }
      .ui.grid > .row > [class*="sixteen wide"].column,
      .ui.grid > .column.row > [class*="sixteen wide"].column,
      .ui.grid > [class*="sixteen wide"].column,
      .ui.column.grid > [class*="sixteen wide"].column {
        width: 100% !important;
      }

      /*----------------------
          Width per Device
      -----------------------*/


      /* Mobile Sizing Combinations */
      @media only screen and (min-width: 320px) and (max-width: 767px) {
        .ui.grid > .row > [class*="one wide mobile"].column,
        .ui.grid > .column.row > [class*="one wide mobile"].column,
        .ui.grid > [class*="one wide mobile"].column,
        .ui.column.grid > [class*="one wide mobile"].column {
          width: 6.25% !important;
        }
        .ui.grid > .row > [class*="two wide mobile"].column,
        .ui.grid > .column.row > [class*="two wide mobile"].column,
        .ui.grid > [class*="two wide mobile"].column,
        .ui.column.grid > [class*="two wide mobile"].column {
          width: 12.5% !important;
        }
        .ui.grid > .row > [class*="three wide mobile"].column,
        .ui.grid > .column.row > [class*="three wide mobile"].column,
        .ui.grid > [class*="three wide mobile"].column,
        .ui.column.grid > [class*="three wide mobile"].column {
          width: 18.75% !important;
        }
        .ui.grid > .row > [class*="four wide mobile"].column,
        .ui.grid > .column.row > [class*="four wide mobile"].column,
        .ui.grid > [class*="four wide mobile"].column,
        .ui.column.grid > [class*="four wide mobile"].column {
          width: 25% !important;
        }
        .ui.grid > .row > [class*="five wide mobile"].column,
        .ui.grid > .column.row > [class*="five wide mobile"].column,
        .ui.grid > [class*="five wide mobile"].column,
        .ui.column.grid > [class*="five wide mobile"].column {
          width: 31.25% !important;
        }
        .ui.grid > .row > [class*="six wide mobile"].column,
        .ui.grid > .column.row > [class*="six wide mobile"].column,
        .ui.grid > [class*="six wide mobile"].column,
        .ui.column.grid > [class*="six wide mobile"].column {
          width: 37.5% !important;
        }
        .ui.grid > .row > [class*="seven wide mobile"].column,
        .ui.grid > .column.row > [class*="seven wide mobile"].column,
        .ui.grid > [class*="seven wide mobile"].column,
        .ui.column.grid > [class*="seven wide mobile"].column {
          width: 43.75% !important;
        }
        .ui.grid > .row > [class*="eight wide mobile"].column,
        .ui.grid > .column.row > [class*="eight wide mobile"].column,
        .ui.grid > [class*="eight wide mobile"].column,
        .ui.column.grid > [class*="eight wide mobile"].column {
          width: 50% !important;
        }
        .ui.grid > .row > [class*="nine wide mobile"].column,
        .ui.grid > .column.row > [class*="nine wide mobile"].column,
        .ui.grid > [class*="nine wide mobile"].column,
        .ui.column.grid > [class*="nine wide mobile"].column {
          width: 56.25% !important;
        }
        .ui.grid > .row > [class*="ten wide mobile"].column,
        .ui.grid > .column.row > [class*="ten wide mobile"].column,
        .ui.grid > [class*="ten wide mobile"].column,
        .ui.column.grid > [class*="ten wide mobile"].column {
          width: 62.5% !important;
        }
        .ui.grid > .row > [class*="eleven wide mobile"].column,
        .ui.grid > .column.row > [class*="eleven wide mobile"].column,
        .ui.grid > [class*="eleven wide mobile"].column,
        .ui.column.grid > [class*="eleven wide mobile"].column {
          width: 68.75% !important;
        }
        .ui.grid > .row > [class*="twelve wide mobile"].column,
        .ui.grid > .column.row > [class*="twelve wide mobile"].column,
        .ui.grid > [class*="twelve wide mobile"].column,
        .ui.column.grid > [class*="twelve wide mobile"].column {
          width: 75% !important;
        }
        .ui.grid > .row > [class*="thirteen wide mobile"].column,
        .ui.grid > .column.row > [class*="thirteen wide mobile"].column,
        .ui.grid > [class*="thirteen wide mobile"].column,
        .ui.column.grid > [class*="thirteen wide mobile"].column {
          width: 81.25% !important;
        }
        .ui.grid > .row > [class*="fourteen wide mobile"].column,
        .ui.grid > .column.row > [class*="fourteen wide mobile"].column,
        .ui.grid > [class*="fourteen wide mobile"].column,
        .ui.column.grid > [class*="fourteen wide mobile"].column {
          width: 87.5% !important;
        }
        .ui.grid > .row > [class*="fifteen wide mobile"].column,
        .ui.grid > .column.row > [class*="fifteen wide mobile"].column,
        .ui.grid > [class*="fifteen wide mobile"].column,
        .ui.column.grid > [class*="fifteen wide mobile"].column {
          width: 93.75% !important;
        }
        .ui.grid > .row > [class*="sixteen wide mobile"].column,
        .ui.grid > .column.row > [class*="sixteen wide mobile"].column,
        .ui.grid > [class*="sixteen wide mobile"].column,
        .ui.column.grid > [class*="sixteen wide mobile"].column {
          width: 100% !important;
        }
      }

      /* Tablet Sizing Combinations */
      @media only screen and (min-width: 768px) and (max-width: 991px) {
        .ui.grid > .row > [class*="one wide tablet"].column,
        .ui.grid > .column.row > [class*="one wide tablet"].column,
        .ui.grid > [class*="one wide tablet"].column,
        .ui.column.grid > [class*="one wide tablet"].column {
          width: 6.25% !important;
        }
        .ui.grid > .row > [class*="two wide tablet"].column,
        .ui.grid > .column.row > [class*="two wide tablet"].column,
        .ui.grid > [class*="two wide tablet"].column,
        .ui.column.grid > [class*="two wide tablet"].column {
          width: 12.5% !important;
        }
        .ui.grid > .row > [class*="three wide tablet"].column,
        .ui.grid > .column.row > [class*="three wide tablet"].column,
        .ui.grid > [class*="three wide tablet"].column,
        .ui.column.grid > [class*="three wide tablet"].column {
          width: 18.75% !important;
        }
        .ui.grid > .row > [class*="four wide tablet"].column,
        .ui.grid > .column.row > [class*="four wide tablet"].column,
        .ui.grid > [class*="four wide tablet"].column,
        .ui.column.grid > [class*="four wide tablet"].column {
          width: 25% !important;
        }
        .ui.grid > .row > [class*="five wide tablet"].column,
        .ui.grid > .column.row > [class*="five wide tablet"].column,
        .ui.grid > [class*="five wide tablet"].column,
        .ui.column.grid > [class*="five wide tablet"].column {
          width: 31.25% !important;
        }
        .ui.grid > .row > [class*="six wide tablet"].column,
        .ui.grid > .column.row > [class*="six wide tablet"].column,
        .ui.grid > [class*="six wide tablet"].column,
        .ui.column.grid > [class*="six wide tablet"].column {
          width: 37.5% !important;
        }
        .ui.grid > .row > [class*="seven wide tablet"].column,
        .ui.grid > .column.row > [class*="seven wide tablet"].column,
        .ui.grid > [class*="seven wide tablet"].column,
        .ui.column.grid > [class*="seven wide tablet"].column {
          width: 43.75% !important;
        }
        .ui.grid > .row > [class*="eight wide tablet"].column,
        .ui.grid > .column.row > [class*="eight wide tablet"].column,
        .ui.grid > [class*="eight wide tablet"].column,
        .ui.column.grid > [class*="eight wide tablet"].column {
          width: 50% !important;
        }
        .ui.grid > .row > [class*="nine wide tablet"].column,
        .ui.grid > .column.row > [class*="nine wide tablet"].column,
        .ui.grid > [class*="nine wide tablet"].column,
        .ui.column.grid > [class*="nine wide tablet"].column {
          width: 56.25% !important;
        }
        .ui.grid > .row > [class*="ten wide tablet"].column,
        .ui.grid > .column.row > [class*="ten wide tablet"].column,
        .ui.grid > [class*="ten wide tablet"].column,
        .ui.column.grid > [class*="ten wide tablet"].column {
          width: 62.5% !important;
        }
        .ui.grid > .row > [class*="eleven wide tablet"].column,
        .ui.grid > .column.row > [class*="eleven wide tablet"].column,
        .ui.grid > [class*="eleven wide tablet"].column,
        .ui.column.grid > [class*="eleven wide tablet"].column {
          width: 68.75% !important;
        }
        .ui.grid > .row > [class*="twelve wide tablet"].column,
        .ui.grid > .column.row > [class*="twelve wide tablet"].column,
        .ui.grid > [class*="twelve wide tablet"].column,
        .ui.column.grid > [class*="twelve wide tablet"].column {
          width: 75% !important;
        }
        .ui.grid > .row > [class*="thirteen wide tablet"].column,
        .ui.grid > .column.row > [class*="thirteen wide tablet"].column,
        .ui.grid > [class*="thirteen wide tablet"].column,
        .ui.column.grid > [class*="thirteen wide tablet"].column {
          width: 81.25% !important;
        }
        .ui.grid > .row > [class*="fourteen wide tablet"].column,
        .ui.grid > .column.row > [class*="fourteen wide tablet"].column,
        .ui.grid > [class*="fourteen wide tablet"].column,
        .ui.column.grid > [class*="fourteen wide tablet"].column {
          width: 87.5% !important;
        }
        .ui.grid > .row > [class*="fifteen wide tablet"].column,
        .ui.grid > .column.row > [class*="fifteen wide tablet"].column,
        .ui.grid > [class*="fifteen wide tablet"].column,
        .ui.column.grid > [class*="fifteen wide tablet"].column {
          width: 93.75% !important;
        }
        .ui.grid > .row > [class*="sixteen wide tablet"].column,
        .ui.grid > .column.row > [class*="sixteen wide tablet"].column,
        .ui.grid > [class*="sixteen wide tablet"].column,
        .ui.column.grid > [class*="sixteen wide tablet"].column {
          width: 100% !important;
        }
      }

      /* Computer/Desktop Sizing Combinations */
      @media only screen and (min-width: 992px) {
        .ui.grid > .row > [class*="one wide computer"].column,
        .ui.grid > .column.row > [class*="one wide computer"].column,
        .ui.grid > [class*="one wide computer"].column,
        .ui.column.grid > [class*="one wide computer"].column {
          width: 6.25% !important;
        }
        .ui.grid > .row > [class*="two wide computer"].column,
        .ui.grid > .column.row > [class*="two wide computer"].column,
        .ui.grid > [class*="two wide computer"].column,
        .ui.column.grid > [class*="two wide computer"].column {
          width: 12.5% !important;
        }
        .ui.grid > .row > [class*="three wide computer"].column,
        .ui.grid > .column.row > [class*="three wide computer"].column,
        .ui.grid > [class*="three wide computer"].column,
        .ui.column.grid > [class*="three wide computer"].column {
          width: 18.75% !important;
        }
        .ui.grid > .row > [class*="four wide computer"].column,
        .ui.grid > .column.row > [class*="four wide computer"].column,
        .ui.grid > [class*="four wide computer"].column,
        .ui.column.grid > [class*="four wide computer"].column {
          width: 25% !important;
        }
        .ui.grid > .row > [class*="five wide computer"].column,
        .ui.grid > .column.row > [class*="five wide computer"].column,
        .ui.grid > [class*="five wide computer"].column,
        .ui.column.grid > [class*="five wide computer"].column {
          width: 31.25% !important;
        }
        .ui.grid > .row > [class*="six wide computer"].column,
        .ui.grid > .column.row > [class*="six wide computer"].column,
        .ui.grid > [class*="six wide computer"].column,
        .ui.column.grid > [class*="six wide computer"].column {
          width: 37.5% !important;
        }
        .ui.grid > .row > [class*="seven wide computer"].column,
        .ui.grid > .column.row > [class*="seven wide computer"].column,
        .ui.grid > [class*="seven wide computer"].column,
        .ui.column.grid > [class*="seven wide computer"].column {
          width: 43.75% !important;
        }
        .ui.grid > .row > [class*="eight wide computer"].column,
        .ui.grid > .column.row > [class*="eight wide computer"].column,
        .ui.grid > [class*="eight wide computer"].column,
        .ui.column.grid > [class*="eight wide computer"].column {
          width: 50% !important;
        }
        .ui.grid > .row > [class*="nine wide computer"].column,
        .ui.grid > .column.row > [class*="nine wide computer"].column,
        .ui.grid > [class*="nine wide computer"].column,
        .ui.column.grid > [class*="nine wide computer"].column {
          width: 56.25% !important;
        }
        .ui.grid > .row > [class*="ten wide computer"].column,
        .ui.grid > .column.row > [class*="ten wide computer"].column,
        .ui.grid > [class*="ten wide computer"].column,
        .ui.column.grid > [class*="ten wide computer"].column {
          width: 62.5% !important;
        }
        .ui.grid > .row > [class*="eleven wide computer"].column,
        .ui.grid > .column.row > [class*="eleven wide computer"].column,
        .ui.grid > [class*="eleven wide computer"].column,
        .ui.column.grid > [class*="eleven wide computer"].column {
          width: 68.75% !important;
        }
        .ui.grid > .row > [class*="twelve wide computer"].column,
        .ui.grid > .column.row > [class*="twelve wide computer"].column,
        .ui.grid > [class*="twelve wide computer"].column,
        .ui.column.grid > [class*="twelve wide computer"].column {
          width: 75% !important;
        }
        .ui.grid > .row > [class*="thirteen wide computer"].column,
        .ui.grid > .column.row > [class*="thirteen wide computer"].column,
        .ui.grid > [class*="thirteen wide computer"].column,
        .ui.column.grid > [class*="thirteen wide computer"].column {
          width: 81.25% !important;
        }
        .ui.grid > .row > [class*="fourteen wide computer"].column,
        .ui.grid > .column.row > [class*="fourteen wide computer"].column,
        .ui.grid > [class*="fourteen wide computer"].column,
        .ui.column.grid > [class*="fourteen wide computer"].column {
          width: 87.5% !important;
        }
        .ui.grid > .row > [class*="fifteen wide computer"].column,
        .ui.grid > .column.row > [class*="fifteen wide computer"].column,
        .ui.grid > [class*="fifteen wide computer"].column,
        .ui.column.grid > [class*="fifteen wide computer"].column {
          width: 93.75% !important;
        }
        .ui.grid > .row > [class*="sixteen wide computer"].column,
        .ui.grid > .column.row > [class*="sixteen wide computer"].column,
        .ui.grid > [class*="sixteen wide computer"].column,
        .ui.column.grid > [class*="sixteen wide computer"].column {
          width: 100% !important;
        }
      }

      /* Large Monitor Sizing Combinations */
      @media only screen and (min-width: 1200px) and (max-width: 1919px) {
        .ui.grid > .row > [class*="one wide large screen"].column,
        .ui.grid > .column.row > [class*="one wide large screen"].column,
        .ui.grid > [class*="one wide large screen"].column,
        .ui.column.grid > [class*="one wide large screen"].column {
          width: 6.25% !important;
        }
        .ui.grid > .row > [class*="two wide large screen"].column,
        .ui.grid > .column.row > [class*="two wide large screen"].column,
        .ui.grid > [class*="two wide large screen"].column,
        .ui.column.grid > [class*="two wide large screen"].column {
          width: 12.5% !important;
        }
        .ui.grid > .row > [class*="three wide large screen"].column,
        .ui.grid > .column.row > [class*="three wide large screen"].column,
        .ui.grid > [class*="three wide large screen"].column,
        .ui.column.grid > [class*="three wide large screen"].column {
          width: 18.75% !important;
        }
        .ui.grid > .row > [class*="four wide large screen"].column,
        .ui.grid > .column.row > [class*="four wide large screen"].column,
        .ui.grid > [class*="four wide large screen"].column,
        .ui.column.grid > [class*="four wide large screen"].column {
          width: 25% !important;
        }
        .ui.grid > .row > [class*="five wide large screen"].column,
        .ui.grid > .column.row > [class*="five wide large screen"].column,
        .ui.grid > [class*="five wide large screen"].column,
        .ui.column.grid > [class*="five wide large screen"].column {
          width: 31.25% !important;
        }
        .ui.grid > .row > [class*="six wide large screen"].column,
        .ui.grid > .column.row > [class*="six wide large screen"].column,
        .ui.grid > [class*="six wide large screen"].column,
        .ui.column.grid > [class*="six wide large screen"].column {
          width: 37.5% !important;
        }
        .ui.grid > .row > [class*="seven wide large screen"].column,
        .ui.grid > .column.row > [class*="seven wide large screen"].column,
        .ui.grid > [class*="seven wide large screen"].column,
        .ui.column.grid > [class*="seven wide large screen"].column {
          width: 43.75% !important;
        }
        .ui.grid > .row > [class*="eight wide large screen"].column,
        .ui.grid > .column.row > [class*="eight wide large screen"].column,
        .ui.grid > [class*="eight wide large screen"].column,
        .ui.column.grid > [class*="eight wide large screen"].column {
          width: 50% !important;
        }
        .ui.grid > .row > [class*="nine wide large screen"].column,
        .ui.grid > .column.row > [class*="nine wide large screen"].column,
        .ui.grid > [class*="nine wide large screen"].column,
        .ui.column.grid > [class*="nine wide large screen"].column {
          width: 56.25% !important;
        }
        .ui.grid > .row > [class*="ten wide large screen"].column,
        .ui.grid > .column.row > [class*="ten wide large screen"].column,
        .ui.grid > [class*="ten wide large screen"].column,
        .ui.column.grid > [class*="ten wide large screen"].column {
          width: 62.5% !important;
        }
        .ui.grid > .row > [class*="eleven wide large screen"].column,
        .ui.grid > .column.row > [class*="eleven wide large screen"].column,
        .ui.grid > [class*="eleven wide large screen"].column,
        .ui.column.grid > [class*="eleven wide large screen"].column {
          width: 68.75% !important;
        }
        .ui.grid > .row > [class*="twelve wide large screen"].column,
        .ui.grid > .column.row > [class*="twelve wide large screen"].column,
        .ui.grid > [class*="twelve wide large screen"].column,
        .ui.column.grid > [class*="twelve wide large screen"].column {
          width: 75% !important;
        }
        .ui.grid > .row > [class*="thirteen wide large screen"].column,
        .ui.grid > .column.row > [class*="thirteen wide large screen"].column,
        .ui.grid > [class*="thirteen wide large screen"].column,
        .ui.column.grid > [class*="thirteen wide large screen"].column {
          width: 81.25% !important;
        }
        .ui.grid > .row > [class*="fourteen wide large screen"].column,
        .ui.grid > .column.row > [class*="fourteen wide large screen"].column,
        .ui.grid > [class*="fourteen wide large screen"].column,
        .ui.column.grid > [class*="fourteen wide large screen"].column {
          width: 87.5% !important;
        }
        .ui.grid > .row > [class*="fifteen wide large screen"].column,
        .ui.grid > .column.row > [class*="fifteen wide large screen"].column,
        .ui.grid > [class*="fifteen wide large screen"].column,
        .ui.column.grid > [class*="fifteen wide large screen"].column {
          width: 93.75% !important;
        }
        .ui.grid > .row > [class*="sixteen wide large screen"].column,
        .ui.grid > .column.row > [class*="sixteen wide large screen"].column,
        .ui.grid > [class*="sixteen wide large screen"].column,
        .ui.column.grid > [class*="sixteen wide large screen"].column {
          width: 100% !important;
        }
      }

      /* Widescreen Sizing Combinations */
      @media only screen and (min-width: 1920px) {
        .ui.grid > .row > [class*="one wide widescreen"].column,
        .ui.grid > .column.row > [class*="one wide widescreen"].column,
        .ui.grid > [class*="one wide widescreen"].column,
        .ui.column.grid > [class*="one wide widescreen"].column {
          width: 6.25% !important;
        }
        .ui.grid > .row > [class*="two wide widescreen"].column,
        .ui.grid > .column.row > [class*="two wide widescreen"].column,
        .ui.grid > [class*="two wide widescreen"].column,
        .ui.column.grid > [class*="two wide widescreen"].column {
          width: 12.5% !important;
        }
        .ui.grid > .row > [class*="three wide widescreen"].column,
        .ui.grid > .column.row > [class*="three wide widescreen"].column,
        .ui.grid > [class*="three wide widescreen"].column,
        .ui.column.grid > [class*="three wide widescreen"].column {
          width: 18.75% !important;
        }
        .ui.grid > .row > [class*="four wide widescreen"].column,
        .ui.grid > .column.row > [class*="four wide widescreen"].column,
        .ui.grid > [class*="four wide widescreen"].column,
        .ui.column.grid > [class*="four wide widescreen"].column {
          width: 25% !important;
        }
        .ui.grid > .row > [class*="five wide widescreen"].column,
        .ui.grid > .column.row > [class*="five wide widescreen"].column,
        .ui.grid > [class*="five wide widescreen"].column,
        .ui.column.grid > [class*="five wide widescreen"].column {
          width: 31.25% !important;
        }
        .ui.grid > .row > [class*="six wide widescreen"].column,
        .ui.grid > .column.row > [class*="six wide widescreen"].column,
        .ui.grid > [class*="six wide widescreen"].column,
        .ui.column.grid > [class*="six wide widescreen"].column {
          width: 37.5% !important;
        }
        .ui.grid > .row > [class*="seven wide widescreen"].column,
        .ui.grid > .column.row > [class*="seven wide widescreen"].column,
        .ui.grid > [class*="seven wide widescreen"].column,
        .ui.column.grid > [class*="seven wide widescreen"].column {
          width: 43.75% !important;
        }
        .ui.grid > .row > [class*="eight wide widescreen"].column,
        .ui.grid > .column.row > [class*="eight wide widescreen"].column,
        .ui.grid > [class*="eight wide widescreen"].column,
        .ui.column.grid > [class*="eight wide widescreen"].column {
          width: 50% !important;
        }
        .ui.grid > .row > [class*="nine wide widescreen"].column,
        .ui.grid > .column.row > [class*="nine wide widescreen"].column,
        .ui.grid > [class*="nine wide widescreen"].column,
        .ui.column.grid > [class*="nine wide widescreen"].column {
          width: 56.25% !important;
        }
        .ui.grid > .row > [class*="ten wide widescreen"].column,
        .ui.grid > .column.row > [class*="ten wide widescreen"].column,
        .ui.grid > [class*="ten wide widescreen"].column,
        .ui.column.grid > [class*="ten wide widescreen"].column {
          width: 62.5% !important;
        }
        .ui.grid > .row > [class*="eleven wide widescreen"].column,
        .ui.grid > .column.row > [class*="eleven wide widescreen"].column,
        .ui.grid > [class*="eleven wide widescreen"].column,
        .ui.column.grid > [class*="eleven wide widescreen"].column {
          width: 68.75% !important;
        }
        .ui.grid > .row > [class*="twelve wide widescreen"].column,
        .ui.grid > .column.row > [class*="twelve wide widescreen"].column,
        .ui.grid > [class*="twelve wide widescreen"].column,
        .ui.column.grid > [class*="twelve wide widescreen"].column {
          width: 75% !important;
        }
        .ui.grid > .row > [class*="thirteen wide widescreen"].column,
        .ui.grid > .column.row > [class*="thirteen wide widescreen"].column,
        .ui.grid > [class*="thirteen wide widescreen"].column,
        .ui.column.grid > [class*="thirteen wide widescreen"].column {
          width: 81.25% !important;
        }
        .ui.grid > .row > [class*="fourteen wide widescreen"].column,
        .ui.grid > .column.row > [class*="fourteen wide widescreen"].column,
        .ui.grid > [class*="fourteen wide widescreen"].column,
        .ui.column.grid > [class*="fourteen wide widescreen"].column {
          width: 87.5% !important;
        }
        .ui.grid > .row > [class*="fifteen wide widescreen"].column,
        .ui.grid > .column.row > [class*="fifteen wide widescreen"].column,
        .ui.grid > [class*="fifteen wide widescreen"].column,
        .ui.column.grid > [class*="fifteen wide widescreen"].column {
          width: 93.75% !important;
        }
        .ui.grid > .row > [class*="sixteen wide widescreen"].column,
        .ui.grid > .column.row > [class*="sixteen wide widescreen"].column,
        .ui.grid > [class*="sixteen wide widescreen"].column,
        .ui.column.grid > [class*="sixteen wide widescreen"].column {
          width: 100% !important;
        }
      }

      /*----------------------
              Centered
      -----------------------*/

      .ui.centered.grid,
      .ui.centered.grid > .row,
      .ui.grid > .centered.row {
        text-align: center;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
      }
      .ui.centered.grid > .column:not(.aligned):not(.justified):not(.row),
      .ui.centered.grid > .row > .column:not(.aligned):not(.justified),
      .ui.grid .centered.row > .column:not(.aligned):not(.justified) {
        text-align: left;
      }
      .ui.grid > .centered.column,
      .ui.grid > .row > .centered.column {
        display: block;
        margin-left: auto;
        margin-right: auto;
      }

      /*----------------------
              Relaxed
      -----------------------*/

      .ui.relaxed.grid > .column:not(.row),
      .ui.relaxed.grid > .row > .column,
      .ui.grid > .relaxed.row > .column {
        padding-left: 1.5rem;
        padding-right: 1.5rem;
      }
      .ui[class*="very relaxed"].grid > .column:not(.row),
      .ui[class*="very relaxed"].grid > .row > .column,
      .ui.grid > [class*="very relaxed"].row > .column {
        padding-left: 2.5rem;
        padding-right: 2.5rem;
      }

      /* Coupling with UI Divider */
      .ui.relaxed.grid .row + .ui.divider,
      .ui.grid .relaxed.row + .ui.divider {
        margin-left: 1.5rem;
        margin-right: 1.5rem;
      }
      .ui[class*="very relaxed"].grid .row + .ui.divider,
      .ui.grid [class*="very relaxed"].row + .ui.divider {
        margin-left: 2.5rem;
        margin-right: 2.5rem;
      }

      /*----------------------
              Padded
      -----------------------*/

      .ui.padded.grid:not(.vertically):not(.horizontally) {
        margin: 0em !important;
      }
      [class*="horizontally padded"].ui.grid {
        margin-left: 0em !important;
        margin-right: 0em !important;
      }
      [class*="vertically padded"].ui.grid {
        margin-top: 0em !important;
        margin-bottom: 0em !important;
      }

      /*----------------------
            "Floated"
      -----------------------*/

      .ui.grid [class*="left floated"].column {
        margin-right: auto;
      }
      .ui.grid [class*="right floated"].column {
        margin-left: auto;
      }

      /*----------------------
              Divided
      -----------------------*/

      .ui.divided.grid:not([class*="vertically divided"]) > .column:not(.row),
      .ui.divided.grid:not([class*="vertically divided"]) > .row > .column {
        -webkit-box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
                box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
      }

      /* Swap from padding to margin on columns to have dividers align */
      .ui[class*="vertically divided"].grid > .column:not(.row),
      .ui[class*="vertically divided"].grid > .row > .column {
        margin-top: 1rem;
        margin-bottom: 1rem;
        padding-top: 0rem;
        padding-bottom: 0rem;
      }
      .ui[class*="vertically divided"].grid > .row {
        margin-top: 0em;
        margin-bottom: 0em;
      }

      /* No divider on first column on row */
      .ui.divided.grid:not([class*="vertically divided"]) > .column:first-child,
      .ui.divided.grid:not([class*="vertically divided"]) > .row > .column:first-child {
        -webkit-box-shadow: none;
                box-shadow: none;
      }

      /* No space on top of first row */
      .ui[class*="vertically divided"].grid > .row:first-child > .column {
        margin-top: 0em;
      }

      /* Divided Row */
      .ui.grid > .divided.row > .column {
        -webkit-box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
                box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
      }
      .ui.grid > .divided.row > .column:first-child {
        -webkit-box-shadow: none;
                box-shadow: none;
      }

      /* Vertically Divided */
      .ui[class*="vertically divided"].grid > .row {
        position: relative;
      }
      .ui[class*="vertically divided"].grid > .row:before {
        position: absolute;
        content: "";
        top: 0em;
        left: 0px;
        width: calc(100% - 2rem);
        height: 1px;
        margin: 0% 1rem;
        -webkit-box-shadow: 0px -1px 0px 0px rgba(34, 36, 38, 0.15);
                box-shadow: 0px -1px 0px 0px rgba(34, 36, 38, 0.15);
      }

      /* Padded Horizontally Divided */
      [class*="horizontally padded"].ui.divided.grid,
      .ui.padded.divided.grid:not(.vertically):not(.horizontally) {
        width: 100%;
      }

      /* First Row Vertically Divided */
      .ui[class*="vertically divided"].grid > .row:first-child:before {
        -webkit-box-shadow: none;
                box-shadow: none;
      }

      /* Inverted Divided */
      .ui.inverted.divided.grid:not([class*="vertically divided"]) > .column:not(.row),
      .ui.inverted.divided.grid:not([class*="vertically divided"]) > .row > .column {
        -webkit-box-shadow: -1px 0px 0px 0px rgba(255, 255, 255, 0.1);
                box-shadow: -1px 0px 0px 0px rgba(255, 255, 255, 0.1);
      }
      .ui.inverted.divided.grid:not([class*="vertically divided"]) > .column:not(.row):first-child,
      .ui.inverted.divided.grid:not([class*="vertically divided"]) > .row > .column:first-child {
        -webkit-box-shadow: none;
                box-shadow: none;
      }
      .ui.inverted[class*="vertically divided"].grid > .row:before {
        -webkit-box-shadow: 0px -1px 0px 0px rgba(255, 255, 255, 0.1);
                box-shadow: 0px -1px 0px 0px rgba(255, 255, 255, 0.1);
      }

      /* Relaxed */
      .ui.relaxed[class*="vertically divided"].grid > .row:before {
        margin-left: 1.5rem;
        margin-right: 1.5rem;
        width: calc(100% - 3rem);
      }
      .ui[class*="very relaxed"][class*="vertically divided"].grid > .row:before {
        margin-left: 2.5rem;
        margin-right: 2.5rem;
        width: calc(100% - 5rem);
      }

      /*----------------------
              Celled
      -----------------------*/

      .ui.celled.grid {
        width: 100%;
        margin: 1em 0em;
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5;
      }
      .ui.celled.grid > .row {
        width: 100% !important;
        margin: 0em;
        padding: 0em;
        -webkit-box-shadow: 0px -1px 0px 0px #D4D4D5;
                box-shadow: 0px -1px 0px 0px #D4D4D5;
      }
      .ui.celled.grid > .column:not(.row),
      .ui.celled.grid > .row > .column {
        -webkit-box-shadow: -1px 0px 0px 0px #D4D4D5;
                box-shadow: -1px 0px 0px 0px #D4D4D5;
      }
      .ui.celled.grid > .column:first-child,
      .ui.celled.grid > .row > .column:first-child {
        -webkit-box-shadow: none;
                box-shadow: none;
      }
      .ui.celled.grid > .column:not(.row),
      .ui.celled.grid > .row > .column {
        padding: 1em;
      }
      .ui.relaxed.celled.grid > .column:not(.row),
      .ui.relaxed.celled.grid > .row > .column {
        padding: 1.5em;
      }
      .ui[class*="very relaxed"].celled.grid > .column:not(.row),
      .ui[class*="very relaxed"].celled.grid > .row > .column {
        padding: 2em;
      }

      /* Internally Celled */
      .ui[class*="internally celled"].grid {
        -webkit-box-shadow: none;
                box-shadow: none;
        margin: 0em;
      }
      .ui[class*="internally celled"].grid > .row:first-child {
        -webkit-box-shadow: none;
                box-shadow: none;
      }
      .ui[class*="internally celled"].grid > .row > .column:first-child {
        -webkit-box-shadow: none;
                box-shadow: none;
      }

      /*----------------------
        Vertically Aligned
      -----------------------*/


      /* Top Aligned */
      .ui[class*="top aligned"].grid > .column:not(.row),
      .ui[class*="top aligned"].grid > .row > .column,
      .ui.grid > [class*="top aligned"].row > .column,
      .ui.grid > [class*="top aligned"].column:not(.row),
      .ui.grid > .row > [class*="top aligned"].column {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
            -ms-flex-direction: column;
                flex-direction: column;
        vertical-align: top;
        -ms-flex-item-align: start !important;
            align-self: flex-start !important;
      }

      /* Middle Aligned */
      .ui[class*="middle aligned"].grid > .column:not(.row),
      .ui[class*="middle aligned"].grid > .row > .column,
      .ui.grid > [class*="middle aligned"].row > .column,
      .ui.grid > [class*="middle aligned"].column:not(.row),
      .ui.grid > .row > [class*="middle aligned"].column {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
            -ms-flex-direction: column;
                flex-direction: column;
        vertical-align: middle;
        -ms-flex-item-align: center !important;
            align-self: center !important;
      }

      /* Bottom Aligned */
      .ui[class*="bottom aligned"].grid > .column:not(.row),
      .ui[class*="bottom aligned"].grid > .row > .column,
      .ui.grid > [class*="bottom aligned"].row > .column,
      .ui.grid > [class*="bottom aligned"].column:not(.row),
      .ui.grid > .row > [class*="bottom aligned"].column {
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
            -ms-flex-direction: column;
                flex-direction: column;
        vertical-align: bottom;
        -ms-flex-item-align: end !important;
            align-self: flex-end !important;
      }

      /* Stretched */
      .ui.stretched.grid > .row > .column,
      .ui.stretched.grid > .column,
      .ui.grid > .stretched.row > .column,
      .ui.grid > .stretched.column:not(.row),
      .ui.grid > .row > .stretched.column {
        display: -webkit-inline-box !important;
        display: -ms-inline-flexbox !important;
        display: inline-flex !important;
        -ms-flex-item-align: stretch;
            align-self: stretch;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
            -ms-flex-direction: column;
                flex-direction: column;
      }
      .ui.stretched.grid > .row > .column > *,
      .ui.stretched.grid > .column > *,
      .ui.grid > .stretched.row > .column > *,
      .ui.grid > .stretched.column:not(.row) > *,
      .ui.grid > .row > .stretched.column > * {
        -webkit-box-flex: 1;
            -ms-flex-positive: 1;
                flex-grow: 1;
      }

      /*----------------------
        Horizontally Centered
      -----------------------*/


      /* Left Aligned */
      .ui[class*="left aligned"].grid > .column,
      .ui[class*="left aligned"].grid > .row > .column,
      .ui.grid > [class*="left aligned"].row > .column,
      .ui.grid > [class*="left aligned"].column.column,
      .ui.grid > .row > [class*="left aligned"].column.column {
        text-align: left;
        -ms-flex-item-align: inherit;
            align-self: inherit;
      }

      /* Center Aligned */
      .ui[class*="center aligned"].grid > .column,
      .ui[class*="center aligned"].grid > .row > .column,
      .ui.grid > [class*="center aligned"].row > .column,
      .ui.grid > [class*="center aligned"].column.column,
      .ui.grid > .row > [class*="center aligned"].column.column {
        text-align: center;
        -ms-flex-item-align: inherit;
            align-self: inherit;
      }
      .ui[class*="center aligned"].grid {
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
      }

      /* Right Aligned */
      .ui[class*="right aligned"].grid > .column,
      .ui[class*="right aligned"].grid > .row > .column,
      .ui.grid > [class*="right aligned"].row > .column,
      .ui.grid > [class*="right aligned"].column.column,
      .ui.grid > .row > [class*="right aligned"].column.column {
        text-align: right;
        -ms-flex-item-align: inherit;
            align-self: inherit;
      }

      /* Justified */
      .ui.justified.grid > .column,
      .ui.justified.grid > .row > .column,
      .ui.grid > .justified.row > .column,
      .ui.grid > .justified.column.column,
      .ui.grid > .row > .justified.column.column {
        text-align: justify;
        -webkit-hyphens: auto;
            -ms-hyphens: auto;
                hyphens: auto;
      }

      /*----------------------
              Colored
      -----------------------*/

      .ui.grid > .row > .red.column,
      .ui.grid > .row > .orange.column,
      .ui.grid > .row > .yellow.column,
      .ui.grid > .row > .olive.column,
      .ui.grid > .row > .green.column,
      .ui.grid > .row > .teal.column,
      .ui.grid > .row > .blue.column,
      .ui.grid > .row > .violet.column,
      .ui.grid > .row > .purple.column,
      .ui.grid > .row > .pink.column,
      .ui.grid > .row > .brown.column,
      .ui.grid > .row > .grey.column,
      .ui.grid > .row > .black.column {
        margin-top: -1rem;
        margin-bottom: -1rem;
        padding-top: 1rem;
        padding-bottom: 1rem;
      }

      /* Red */
      .ui.grid > .red.row,
      .ui.grid > .red.column,
      .ui.grid > .row > .red.column {
        background-color: #DB2828 !important;
        color: #FFFFFF;
      }

      /* Orange */
      .ui.grid > .orange.row,
      .ui.grid > .orange.column,
      .ui.grid > .row > .orange.column {
        background-color: #F2711C !important;
        color: #FFFFFF;
      }

      /* Yellow */
      .ui.grid > .yellow.row,
      .ui.grid > .yellow.column,
      .ui.grid > .row > .yellow.column {
        background-color: #FBBD08 !important;
        color: #FFFFFF;
      }

      /* Olive */
      .ui.grid > .olive.row,
      .ui.grid > .olive.column,
      .ui.grid > .row > .olive.column {
        background-color: #B5CC18 !important;
        color: #FFFFFF;
      }

      /* Green */
      .ui.grid > .green.row,
      .ui.grid > .green.column,
      .ui.grid > .row > .green.column {
        background-color: #21BA45 !important;
        color: #FFFFFF;
      }

      /* Teal */
      .ui.grid > .teal.row,
      .ui.grid > .teal.column,
      .ui.grid > .row > .teal.column {
        background-color: #00B5AD !important;
        color: #FFFFFF;
      }

      /* Blue */
      .ui.grid > .blue.row,
      .ui.grid > .blue.column,
      .ui.grid > .row > .blue.column {
        background-color: #2185D0 !important;
        color: #FFFFFF;
      }

      /* Violet */
      .ui.grid > .violet.row,
      .ui.grid > .violet.column,
      .ui.grid > .row > .violet.column {
        background-color: #6435C9 !important;
        color: #FFFFFF;
      }

      /* Purple */
      .ui.grid > .purple.row,
      .ui.grid > .purple.column,
      .ui.grid > .row > .purple.column {
        background-color: #A333C8 !important;
        color: #FFFFFF;
      }

      /* Pink */
      .ui.grid > .pink.row,
      .ui.grid > .pink.column,
      .ui.grid > .row > .pink.column {
        background-color: #E03997 !important;
        color: #FFFFFF;
      }

      /* Brown */
      .ui.grid > .brown.row,
      .ui.grid > .brown.column,
      .ui.grid > .row > .brown.column {
        background-color: #A5673F !important;
        color: #FFFFFF;
      }

      /* Grey */
      .ui.grid > .grey.row,
      .ui.grid > .grey.column,
      .ui.grid > .row > .grey.column {
        background-color: #767676 !important;
        color: #FFFFFF;
      }

      /* Black */
      .ui.grid > .black.row,
      .ui.grid > .black.column,
      .ui.grid > .row > .black.column {
        background-color: #1B1C1D !important;
        color: #FFFFFF;
      }

      /*----------------------
            Equal Width
      -----------------------*/

      .ui[class*="equal width"].grid > .column:not(.row),
      .ui[class*="equal width"].grid > .row > .column,
      .ui.grid > [class*="equal width"].row > .column {
        display: inline-block;
        -webkit-box-flex: 1;
            -ms-flex-positive: 1;
                flex-grow: 1;
      }
      .ui[class*="equal width"].grid > .wide.column,
      .ui[class*="equal width"].grid > .row > .wide.column,
      .ui.grid > [class*="equal width"].row > .wide.column {
        -webkit-box-flex: 0;
            -ms-flex-positive: 0;
                flex-grow: 0;
      }

      /*----------------------
              Reverse
      -----------------------*/


      /* Mobile */
      @media only screen and (max-width: 767px) {
        .ui[class*="mobile reversed"].grid,
        .ui[class*="mobile reversed"].grid > .row,
        .ui.grid > [class*="mobile reversed"].row {
          -webkit-box-orient: horizontal;
          -webkit-box-direction: reverse;
              -ms-flex-direction: row-reverse;
                  flex-direction: row-reverse;
        }
        .ui[class*="mobile vertically reversed"].grid,
        .ui.stackable[class*="mobile reversed"] {
          -webkit-box-orient: vertical;
          -webkit-box-direction: reverse;
              -ms-flex-direction: column-reverse;
                  flex-direction: column-reverse;
        }
        
      /* Divided Reversed */
        .ui[class*="mobile reversed"].divided.grid:not([class*="vertically divided"]) > .column:first-child,
        .ui[class*="mobile reversed"].divided.grid:not([class*="vertically divided"]) > .row > .column:first-child {
          -webkit-box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
                  box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
        }
        .ui[class*="mobile reversed"].divided.grid:not([class*="vertically divided"]) > .column:last-child,
        .ui[class*="mobile reversed"].divided.grid:not([class*="vertically divided"]) > .row > .column:last-child {
          -webkit-box-shadow: none;
                  box-shadow: none;
        }
        
      /* Vertically Divided Reversed */
        .ui.grid[class*="vertically divided"][class*="mobile vertically reversed"] > .row:first-child:before {
          -webkit-box-shadow: 0px -1px 0px 0px rgba(34, 36, 38, 0.15);
                  box-shadow: 0px -1px 0px 0px rgba(34, 36, 38, 0.15);
        }
        .ui.grid[class*="vertically divided"][class*="mobile vertically reversed"] > .row:last-child:before {
          -webkit-box-shadow: none;
                  box-shadow: none;
        }
        
      /* Celled Reversed */
        .ui[class*="mobile reversed"].celled.grid > .row > .column:first-child {
          -webkit-box-shadow: -1px 0px 0px 0px #D4D4D5;
                  box-shadow: -1px 0px 0px 0px #D4D4D5;
        }
        .ui[class*="mobile reversed"].celled.grid > .row > .column:last-child {
          -webkit-box-shadow: none;
                  box-shadow: none;
        }
      }

      /* Tablet */
      @media only screen and (min-width: 768px) and (max-width: 991px) {
        .ui[class*="tablet reversed"].grid,
        .ui[class*="tablet reversed"].grid > .row,
        .ui.grid > [class*="tablet reversed"].row {
          -webkit-box-orient: horizontal;
          -webkit-box-direction: reverse;
              -ms-flex-direction: row-reverse;
                  flex-direction: row-reverse;
        }
        .ui[class*="tablet vertically reversed"].grid {
          -webkit-box-orient: vertical;
          -webkit-box-direction: reverse;
              -ms-flex-direction: column-reverse;
                  flex-direction: column-reverse;
        }
        
      /* Divided Reversed */
        .ui[class*="tablet reversed"].divided.grid:not([class*="vertically divided"]) > .column:first-child,
        .ui[class*="tablet reversed"].divided.grid:not([class*="vertically divided"]) > .row > .column:first-child {
          -webkit-box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
                  box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
        }
        .ui[class*="tablet reversed"].divided.grid:not([class*="vertically divided"]) > .column:last-child,
        .ui[class*="tablet reversed"].divided.grid:not([class*="vertically divided"]) > .row > .column:last-child {
          -webkit-box-shadow: none;
                  box-shadow: none;
        }
        
      /* Vertically Divided Reversed */
        .ui.grid[class*="vertically divided"][class*="tablet vertically reversed"] > .row:first-child:before {
          -webkit-box-shadow: 0px -1px 0px 0px rgba(34, 36, 38, 0.15);
                  box-shadow: 0px -1px 0px 0px rgba(34, 36, 38, 0.15);
        }
        .ui.grid[class*="vertically divided"][class*="tablet vertically reversed"] > .row:last-child:before {
          -webkit-box-shadow: none;
                  box-shadow: none;
        }
        
      /* Celled Reversed */
        .ui[class*="tablet reversed"].celled.grid > .row > .column:first-child {
          -webkit-box-shadow: -1px 0px 0px 0px #D4D4D5;
                  box-shadow: -1px 0px 0px 0px #D4D4D5;
        }
        .ui[class*="tablet reversed"].celled.grid > .row > .column:last-child {
          -webkit-box-shadow: none;
                  box-shadow: none;
        }
      }

      /* Computer */
      @media only screen and (min-width: 992px) {
        .ui[class*="computer reversed"].grid,
        .ui[class*="computer reversed"].grid > .row,
        .ui.grid > [class*="computer reversed"].row {
          -webkit-box-orient: horizontal;
          -webkit-box-direction: reverse;
              -ms-flex-direction: row-reverse;
                  flex-direction: row-reverse;
        }
        .ui[class*="computer vertically reversed"].grid {
          -webkit-box-orient: vertical;
          -webkit-box-direction: reverse;
              -ms-flex-direction: column-reverse;
                  flex-direction: column-reverse;
        }
        
      /* Divided Reversed */
        .ui[class*="computer reversed"].divided.grid:not([class*="vertically divided"]) > .column:first-child,
        .ui[class*="computer reversed"].divided.grid:not([class*="vertically divided"]) > .row > .column:first-child {
          -webkit-box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
                  box-shadow: -1px 0px 0px 0px rgba(34, 36, 38, 0.15);
        }
        .ui[class*="computer reversed"].divided.grid:not([class*="vertically divided"]) > .column:last-child,
        .ui[class*="computer reversed"].divided.grid:not([class*="vertically divided"]) > .row > .column:last-child {
          -webkit-box-shadow: none;
                  box-shadow: none;
        }
        
      /* Vertically Divided Reversed */
        .ui.grid[class*="vertically divided"][class*="computer vertically reversed"] > .row:first-child:before {
          -webkit-box-shadow: 0px -1px 0px 0px rgba(34, 36, 38, 0.15);
                  box-shadow: 0px -1px 0px 0px rgba(34, 36, 38, 0.15);
        }
        .ui.grid[class*="vertically divided"][class*="computer vertically reversed"] > .row:last-child:before {
          -webkit-box-shadow: none;
                  box-shadow: none;
        }
        
      /* Celled Reversed */
        .ui[class*="computer reversed"].celled.grid > .row > .column:first-child {
          -webkit-box-shadow: -1px 0px 0px 0px #D4D4D5;
                  box-shadow: -1px 0px 0px 0px #D4D4D5;
        }
        .ui[class*="computer reversed"].celled.grid > .row > .column:last-child {
          -webkit-box-shadow: none;
                  box-shadow: none;
        }
      }

      /*-------------------
            Doubling
      --------------------*/


      /* Tablet Only */
      @media only screen and (min-width: 768px) and (max-width: 991px) {
        .ui.doubling.grid {
          width: auto;
        }
        .ui.grid > .doubling.row,
        .ui.doubling.grid > .row {
          margin: 0em !important;
          padding: 0em !important;
        }
        .ui.grid > .doubling.row > .column,
        .ui.doubling.grid > .row > .column {
          display: inline-block !important;
          padding-top: 1rem !important;
          padding-bottom: 1rem !important;
          -webkit-box-shadow: none !important;
                  box-shadow: none !important;
          margin: 0em;
        }
        .ui[class*="two column"].doubling.grid > .row > .column,
        .ui[class*="two column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="two column"].doubling.row.row > .column {
          width: 100% !important;
        }
        .ui[class*="three column"].doubling.grid > .row > .column,
        .ui[class*="three column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="three column"].doubling.row.row > .column {
          width: 50% !important;
        }
        .ui[class*="four column"].doubling.grid > .row > .column,
        .ui[class*="four column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="four column"].doubling.row.row > .column {
          width: 50% !important;
        }
        .ui[class*="five column"].doubling.grid > .row > .column,
        .ui[class*="five column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="five column"].doubling.row.row > .column {
          width: 33.33333333% !important;
        }
        .ui[class*="six column"].doubling.grid > .row > .column,
        .ui[class*="six column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="six column"].doubling.row.row > .column {
          width: 33.33333333% !important;
        }
        .ui[class*="seven column"].doubling.grid > .row > .column,
        .ui[class*="seven column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="seven column"].doubling.row.row > .column {
          width: 33.33333333% !important;
        }
        .ui[class*="eight column"].doubling.grid > .row > .column,
        .ui[class*="eight column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="eight column"].doubling.row.row > .column {
          width: 25% !important;
        }
        .ui[class*="nine column"].doubling.grid > .row > .column,
        .ui[class*="nine column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="nine column"].doubling.row.row > .column {
          width: 25% !important;
        }
        .ui[class*="ten column"].doubling.grid > .row > .column,
        .ui[class*="ten column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="ten column"].doubling.row.row > .column {
          width: 20% !important;
        }
        .ui[class*="eleven column"].doubling.grid > .row > .column,
        .ui[class*="eleven column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="eleven column"].doubling.row.row > .column {
          width: 20% !important;
        }
        .ui[class*="twelve column"].doubling.grid > .row > .column,
        .ui[class*="twelve column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="twelve column"].doubling.row.row > .column {
          width: 16.66666667% !important;
        }
        .ui[class*="thirteen column"].doubling.grid > .row > .column,
        .ui[class*="thirteen column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="thirteen column"].doubling.row.row > .column {
          width: 16.66666667% !important;
        }
        .ui[class*="fourteen column"].doubling.grid > .row > .column,
        .ui[class*="fourteen column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="fourteen column"].doubling.row.row > .column {
          width: 14.28571429% !important;
        }
        .ui[class*="fifteen column"].doubling.grid > .row > .column,
        .ui[class*="fifteen column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="fifteen column"].doubling.row.row > .column {
          width: 14.28571429% !important;
        }
        .ui[class*="sixteen column"].doubling.grid > .row > .column,
        .ui[class*="sixteen column"].doubling.grid > .column:not(.row),
        .ui.grid > [class*="sixteen column"].doubling.row.row > .column {
          width: 12.5% !important;
        }
      }

      /* Mobile Only */
      @media only screen and (max-width: 767px) {
        .ui.grid > .doubling.row,
        .ui.doubling.grid > .row {
          margin: 0em !important;
          padding: 0em !important;
        }
        .ui.grid > .doubling.row > .column,
        .ui.doubling.grid > .row > .column {
          padding-top: 1rem !important;
          padding-bottom: 1rem !important;
          margin: 0em !important;
          -webkit-box-shadow: none !important;
                  box-shadow: none !important;
        }
        .ui[class*="two column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="two column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="two column"].doubling:not(.stackable).row.row > .column {
          width: 100% !important;
        }
        .ui[class*="three column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="three column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="three column"].doubling:not(.stackable).row.row > .column {
          width: 50% !important;
        }
        .ui[class*="four column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="four column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="four column"].doubling:not(.stackable).row.row > .column {
          width: 50% !important;
        }
        .ui[class*="five column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="five column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="five column"].doubling:not(.stackable).row.row > .column {
          width: 50% !important;
        }
        .ui[class*="six column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="six column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="six column"].doubling:not(.stackable).row.row > .column {
          width: 50% !important;
        }
        .ui[class*="seven column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="seven column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="seven column"].doubling:not(.stackable).row.row > .column {
          width: 50% !important;
        }
        .ui[class*="eight column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="eight column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="eight column"].doubling:not(.stackable).row.row > .column {
          width: 50% !important;
        }
        .ui[class*="nine column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="nine column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="nine column"].doubling:not(.stackable).row.row > .column {
          width: 33.33333333% !important;
        }
        .ui[class*="ten column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="ten column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="ten column"].doubling:not(.stackable).row.row > .column {
          width: 33.33333333% !important;
        }
        .ui[class*="eleven column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="eleven column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="eleven column"].doubling:not(.stackable).row.row > .column {
          width: 33.33333333% !important;
        }
        .ui[class*="twelve column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="twelve column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="twelve column"].doubling:not(.stackable).row.row > .column {
          width: 33.33333333% !important;
        }
        .ui[class*="thirteen column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="thirteen column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="thirteen column"].doubling:not(.stackable).row.row > .column {
          width: 33.33333333% !important;
        }
        .ui[class*="fourteen column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="fourteen column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="fourteen column"].doubling:not(.stackable).row.row > .column {
          width: 25% !important;
        }
        .ui[class*="fifteen column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="fifteen column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="fifteen column"].doubling:not(.stackable).row.row > .column {
          width: 25% !important;
        }
        .ui[class*="sixteen column"].doubling:not(.stackable).grid > .row > .column,
        .ui[class*="sixteen column"].doubling:not(.stackable).grid > .column:not(.row),
        .ui.grid > [class*="sixteen column"].doubling:not(.stackable).row.row > .column {
          width: 25% !important;
        }
      }

      /*-------------------
            Stackable
      --------------------*/

      @media only screen and (max-width: 767px) {
        .ui.stackable.grid {
          width: auto;
          margin-left: 0em !important;
          margin-right: 0em !important;
        }
        .ui.stackable.grid > .row > .wide.column,
        .ui.stackable.grid > .wide.column,
        .ui.stackable.grid > .column.grid > .column,
        .ui.stackable.grid > .column.row > .column,
        .ui.stackable.grid > .row > .column,
        .ui.stackable.grid > .column:not(.row),
        .ui.grid > .stackable.stackable.row > .column {
          width: 100% !important;
          margin: 0em 0em !important;
          -webkit-box-shadow: none !important;
                  box-shadow: none !important;
          padding: 1rem 1rem !important;
        }
        .ui.stackable.grid:not(.vertically) > .row {
          margin: 0em;
          padding: 0em;
        }
        
      /* Coupling */
        .ui.container > .ui.stackable.grid > .column,
        .ui.container > .ui.stackable.grid > .row > .column {
          padding-left: 0em !important;
          padding-right: 0em !important;
        }
        
      /* Don't pad inside segment or nested grid */
        .ui.grid .ui.stackable.grid,
        .ui.segment:not(.vertical) .ui.stackable.page.grid {
          margin-left: -1rem !important;
          margin-right: -1rem !important;
        }
        
      /* Divided Stackable */
        .ui.stackable.divided.grid > .row:first-child > .column:first-child,
        .ui.stackable.celled.grid > .row:first-child > .column:first-child,
        .ui.stackable.divided.grid > .column:not(.row):first-child,
        .ui.stackable.celled.grid > .column:not(.row):first-child {
          border-top: none !important;
        }
        .ui.inverted.stackable.celled.grid > .column:not(.row),
        .ui.inverted.stackable.divided.grid > .column:not(.row),
        .ui.inverted.stackable.celled.grid > .row > .column,
        .ui.inverted.stackable.divided.grid > .row > .column {
          border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        .ui.stackable.celled.grid > .column:not(.row),
        .ui.stackable.divided:not(.vertically).grid > .column:not(.row),
        .ui.stackable.celled.grid > .row > .column,
        .ui.stackable.divided:not(.vertically).grid > .row > .column {
          border-top: 1px solid rgba(34, 36, 38, 0.15);
          -webkit-box-shadow: none !important;
                  box-shadow: none !important;
          padding-top: 2rem !important;
          padding-bottom: 2rem !important;
        }
        .ui.stackable.celled.grid > .row {
          -webkit-box-shadow: none !important;
                  box-shadow: none !important;
        }
        .ui.stackable.divided:not(.vertically).grid > .column:not(.row),
        .ui.stackable.divided:not(.vertically).grid > .row > .column {
          padding-left: 0em !important;
          padding-right: 0em !important;
        }
      }

      /*----------------------
          Only (Device)
      -----------------------*/


      /* These include arbitrary class repetitions for forced specificity */

      /* Mobile Only Hide */
      @media only screen and (max-width: 767px) {
        .ui[class*="tablet only"].grid.grid.grid:not(.mobile),
        .ui.grid.grid.grid > [class*="tablet only"].row:not(.mobile),
        .ui.grid.grid.grid > [class*="tablet only"].column:not(.mobile),
        .ui.grid.grid.grid > .row > [class*="tablet only"].column:not(.mobile) {
          display: none !important;
        }
        .ui[class*="computer only"].grid.grid.grid:not(.mobile),
        .ui.grid.grid.grid > [class*="computer only"].row:not(.mobile),
        .ui.grid.grid.grid > [class*="computer only"].column:not(.mobile),
        .ui.grid.grid.grid > .row > [class*="computer only"].column:not(.mobile) {
          display: none !important;
        }
        .ui[class*="large screen only"].grid.grid.grid:not(.mobile),
        .ui.grid.grid.grid > [class*="large screen only"].row:not(.mobile),
        .ui.grid.grid.grid > [class*="large screen only"].column:not(.mobile),
        .ui.grid.grid.grid > .row > [class*="large screen only"].column:not(.mobile) {
          display: none !important;
        }
        .ui[class*="widescreen only"].grid.grid.grid:not(.mobile),
        .ui.grid.grid.grid > [class*="widescreen only"].row:not(.mobile),
        .ui.grid.grid.grid > [class*="widescreen only"].column:not(.mobile),
        .ui.grid.grid.grid > .row > [class*="widescreen only"].column:not(.mobile) {
          display: none !important;
        }
      }

      /* Tablet Only Hide */
      @media only screen and (min-width: 768px) and (max-width: 991px) {
        .ui[class*="mobile only"].grid.grid.grid:not(.tablet),
        .ui.grid.grid.grid > [class*="mobile only"].row:not(.tablet),
        .ui.grid.grid.grid > [class*="mobile only"].column:not(.tablet),
        .ui.grid.grid.grid > .row > [class*="mobile only"].column:not(.tablet) {
          display: none !important;
        }
        .ui[class*="computer only"].grid.grid.grid:not(.tablet),
        .ui.grid.grid.grid > [class*="computer only"].row:not(.tablet),
        .ui.grid.grid.grid > [class*="computer only"].column:not(.tablet),
        .ui.grid.grid.grid > .row > [class*="computer only"].column:not(.tablet) {
          display: none !important;
        }
        .ui[class*="large screen only"].grid.grid.grid:not(.mobile),
        .ui.grid.grid.grid > [class*="large screen only"].row:not(.mobile),
        .ui.grid.grid.grid > [class*="large screen only"].column:not(.mobile),
        .ui.grid.grid.grid > .row > [class*="large screen only"].column:not(.mobile) {
          display: none !important;
        }
        .ui[class*="widescreen only"].grid.grid.grid:not(.mobile),
        .ui.grid.grid.grid > [class*="widescreen only"].row:not(.mobile),
        .ui.grid.grid.grid > [class*="widescreen only"].column:not(.mobile),
        .ui.grid.grid.grid > .row > [class*="widescreen only"].column:not(.mobile) {
          display: none !important;
        }
      }

      /* Computer Only Hide */
      @media only screen and (min-width: 992px) and (max-width: 1199px) {
        .ui[class*="mobile only"].grid.grid.grid:not(.computer),
        .ui.grid.grid.grid > [class*="mobile only"].row:not(.computer),
        .ui.grid.grid.grid > [class*="mobile only"].column:not(.computer),
        .ui.grid.grid.grid > .row > [class*="mobile only"].column:not(.computer) {
          display: none !important;
        }
        .ui[class*="tablet only"].grid.grid.grid:not(.computer),
        .ui.grid.grid.grid > [class*="tablet only"].row:not(.computer),
        .ui.grid.grid.grid > [class*="tablet only"].column:not(.computer),
        .ui.grid.grid.grid > .row > [class*="tablet only"].column:not(.computer) {
          display: none !important;
        }
        .ui[class*="large screen only"].grid.grid.grid:not(.mobile),
        .ui.grid.grid.grid > [class*="large screen only"].row:not(.mobile),
        .ui.grid.grid.grid > [class*="large screen only"].column:not(.mobile),
        .ui.grid.grid.grid > .row > [class*="large screen only"].column:not(.mobile) {
          display: none !important;
        }
        .ui[class*="widescreen only"].grid.grid.grid:not(.mobile),
        .ui.grid.grid.grid > [class*="widescreen only"].row:not(.mobile),
        .ui.grid.grid.grid > [class*="widescreen only"].column:not(.mobile),
        .ui.grid.grid.grid > .row > [class*="widescreen only"].column:not(.mobile) {
          display: none !important;
        }
      }

      /* Large Screen Only Hide */
      @media only screen and (min-width: 1200px) and (max-width: 1919px) {
        .ui[class*="mobile only"].grid.grid.grid:not(.computer),
        .ui.grid.grid.grid > [class*="mobile only"].row:not(.computer),
        .ui.grid.grid.grid > [class*="mobile only"].column:not(.computer),
        .ui.grid.grid.grid > .row > [class*="mobile only"].column:not(.computer) {
          display: none !important;
        }
        .ui[class*="tablet only"].grid.grid.grid:not(.computer),
        .ui.grid.grid.grid > [class*="tablet only"].row:not(.computer),
        .ui.grid.grid.grid > [class*="tablet only"].column:not(.computer),
        .ui.grid.grid.grid > .row > [class*="tablet only"].column:not(.computer) {
          display: none !important;
        }
        .ui[class*="widescreen only"].grid.grid.grid:not(.mobile),
        .ui.grid.grid.grid > [class*="widescreen only"].row:not(.mobile),
        .ui.grid.grid.grid > [class*="widescreen only"].column:not(.mobile),
        .ui.grid.grid.grid > .row > [class*="widescreen only"].column:not(.mobile) {
          display: none !important;
        }
      }

      /* Widescreen Only Hide */
      @media only screen and (min-width: 1920px) {
        .ui[class*="mobile only"].grid.grid.grid:not(.computer),
        .ui.grid.grid.grid > [class*="mobile only"].row:not(.computer),
        .ui.grid.grid.grid > [class*="mobile only"].column:not(.computer),
        .ui.grid.grid.grid > .row > [class*="mobile only"].column:not(.computer) {
          display: none !important;
        }
        .ui[class*="tablet only"].grid.grid.grid:not(.computer),
        .ui.grid.grid.grid > [class*="tablet only"].row:not(.computer),
        .ui.grid.grid.grid > [class*="tablet only"].column:not(.computer),
        .ui.grid.grid.grid > .row > [class*="tablet only"].column:not(.computer) {
          display: none !important;
        }
      }


      /*******************************
              Theme Overrides
      *******************************/



      /*******************************
              Site Overrides
      *******************************/

  </style>

  <!--- Header --->
  <style>
     /*
      * # Semantic UI - 2.4.2
      * https://github.com/Semantic-Org/Semantic-UI
      * http://www.semantic-ui.com/
      *
      * Copyright 2014 Contributors
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */
      /*!
      * # Semantic UI - Header
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


      /*******************************
              Theme Overrides
      *******************************/



      /*******************************
              Site Overrides
      *******************************/

  </style>

  <!--- Card --->
  <style>
     /*
      * # Semantic UI - 2.4.2
      * https://github.com/Semantic-Org/Semantic-UI
      * http://www.semantic-ui.com/
      *
      * Copyright 2014 Contributors
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */
      /*!
      * # Semantic UI - Item
      * http://github.com/semantic-org/semantic-ui/
      *
      *
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */


      /*******************************
                  Standard
      *******************************/


      /*--------------
            Card
      ---------------*/

      .ui.cards > .card,
      .ui.card {
        max-width: 100%;
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
            -ms-flex-direction: column;
                flex-direction: column;
        width: 290px;
        min-height: 0px;
        background: #FFFFFF;
        padding: 0em;
        border: none;
        border-radius: 0.28571429rem;
        -webkit-box-shadow: 0px 1px 3px 0px #D4D4D5, 0px 0px 0px 1px #D4D4D5;
                box-shadow: 0px 1px 3px 0px #D4D4D5, 0px 0px 0px 1px #D4D4D5;
        -webkit-transition: -webkit-box-shadow 0.1s ease, -webkit-transform 0.1s ease;
        transition: -webkit-box-shadow 0.1s ease, -webkit-transform 0.1s ease;
        transition: box-shadow 0.1s ease, transform 0.1s ease;
        transition: box-shadow 0.1s ease, transform 0.1s ease, -webkit-box-shadow 0.1s ease, -webkit-transform 0.1s ease;
        z-index: '';
      }
      .ui.card {
        margin: 1em 0em;
      }
      .ui.cards > .card a,
      .ui.card a {
        cursor: pointer;
      }
      .ui.card:first-child {
        margin-top: 0em;
      }
      .ui.card:last-child {
        margin-bottom: 0em;
      }

      /*--------------
            Cards
      ---------------*/

      .ui.cards {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin: -0.875em -0.5em;
        -ms-flex-wrap: wrap;
            flex-wrap: wrap;
      }
      .ui.cards > .card {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        margin: 0.875em 0.5em;
        float: none;
      }

      /* Clearing */
      .ui.cards:after,
      .ui.card:after {
        display: block;
        content: ' ';
        height: 0px;
        clear: both;
        overflow: hidden;
        visibility: hidden;
      }

      /* Consecutive Card Groups Preserve Row Spacing */
      .ui.cards ~ .ui.cards {
        margin-top: 0.875em;
      }

      /*--------------
        Rounded Edges
      ---------------*/

      .ui.cards > .card > :first-child,
      .ui.card > :first-child {
        border-radius: 0.28571429rem 0.28571429rem 0em 0em !important;
        border-top: none !important;
      }
      .ui.cards > .card > :last-child,
      .ui.card > :last-child {
        border-radius: 0em 0em 0.28571429rem 0.28571429rem !important;
      }
      .ui.cards > .card > :only-child,
      .ui.card > :only-child {
        border-radius: 0.28571429rem !important;
      }

      /*--------------
          Images
      ---------------*/

      .ui.cards > .card > .image,
      .ui.card > .image {
        position: relative;
        display: block;
        -webkit-box-flex: 0;
            -ms-flex: 0 0 auto;
                flex: 0 0 auto;
        padding: 0em;
        background: rgba(0, 0, 0, 0.05);
      }
      .ui.cards > .card > .image > img,
      .ui.card > .image > img {
        display: block;
        width: 100%;
        height: auto;
        border-radius: inherit;
      }
      .ui.cards > .card > .image:not(.ui) > img,
      .ui.card > .image:not(.ui) > img {
        border: none;
      }

      /*--------------
          Content
      ---------------*/

      .ui.cards > .card > .content,
      .ui.card > .content {
        -webkit-box-flex: 1;
            -ms-flex-positive: 1;
                flex-grow: 1;
        border: none;
        border-top: 1px solid rgba(34, 36, 38, 0.1);
        background: none;
        margin: 0em;
        padding: 1em 1em;
        -webkit-box-shadow: none;
                box-shadow: none;
        font-size: 1em;
        border-radius: 0em;
      }
      .ui.cards > .card > .content:after,
      .ui.card > .content:after {
        display: block;
        content: ' ';
        height: 0px;
        clear: both;
        overflow: hidden;
        visibility: hidden;
      }
      .ui.cards > .card > .content > .header,
      .ui.card > .content > .header {
        display: block;
        margin: '';
        font-family: 'Lato', 'Helvetica Neue', Arial, Helvetica, sans-serif;
        color: rgba(0, 0, 0, 0.85);
      }

      /* Default Header Size */
      .ui.cards > .card > .content > .header:not(.ui),
      .ui.card > .content > .header:not(.ui) {
        font-weight: bold;
        font-size: 1.28571429em;
        margin-top: -0.21425em;
        line-height: 1.28571429em;
      }
      .ui.cards > .card > .content > .meta + .description,
      .ui.cards > .card > .content > .header + .description,
      .ui.card > .content > .meta + .description,
      .ui.card > .content > .header + .description {
        margin-top: 0.5em;
      }

      /*----------------
      Floated Content
      -----------------*/

      .ui.cards > .card [class*="left floated"],
      .ui.card [class*="left floated"] {
        float: left;
      }
      .ui.cards > .card [class*="right floated"],
      .ui.card [class*="right floated"] {
        float: right;
      }

      /*--------------
          Aligned
      ---------------*/

      .ui.cards > .card [class*="left aligned"],
      .ui.card [class*="left aligned"] {
        text-align: left;
      }
      .ui.cards > .card [class*="center aligned"],
      .ui.card [class*="center aligned"] {
        text-align: center;
      }
      .ui.cards > .card [class*="right aligned"],
      .ui.card [class*="right aligned"] {
        text-align: right;
      }

      /*--------------
        Content Image
      ---------------*/

      .ui.cards > .card .content img,
      .ui.card .content img {
        display: inline-block;
        vertical-align: middle;
        width: '';
      }
      .ui.cards > .card img.avatar,
      .ui.cards > .card .avatar img,
      .ui.card img.avatar,
      .ui.card .avatar img {
        width: 2em;
        height: 2em;
        border-radius: 500rem;
      }

      /*--------------
        Description
      ---------------*/

      .ui.cards > .card > .content > .description,
      .ui.card > .content > .description {
        clear: both;
        color: rgba(0, 0, 0, 0.68);
      }

      /*--------------
          Paragraph
      ---------------*/

      .ui.cards > .card > .content p,
      .ui.card > .content p {
        margin: 0em 0em 0.5em;
      }
      .ui.cards > .card > .content p:last-child,
      .ui.card > .content p:last-child {
        margin-bottom: 0em;
      }

      /*--------------
            Meta
      ---------------*/

      .ui.cards > .card .meta,
      .ui.card .meta {
        font-size: 1em;
        color: rgba(0, 0, 0, 0.4);
      }
      .ui.cards > .card .meta *,
      .ui.card .meta * {
        margin-right: 0.3em;
      }
      .ui.cards > .card .meta :last-child,
      .ui.card .meta :last-child {
        margin-right: 0em;
      }
      .ui.cards > .card .meta [class*="right floated"],
      .ui.card .meta [class*="right floated"] {
        margin-right: 0em;
        margin-left: 0.3em;
      }

      /*--------------
            Links
      ---------------*/


      /* Generic */
      .ui.cards > .card > .content a:not(.ui),
      .ui.card > .content a:not(.ui) {
        color: '';
        -webkit-transition: color 0.1s ease;
        transition: color 0.1s ease;
      }
      .ui.cards > .card > .content a:not(.ui):hover,
      .ui.card > .content a:not(.ui):hover {
        color: '';
      }

      /* Header */
      .ui.cards > .card > .content > a.header,
      .ui.card > .content > a.header {
        color: rgba(0, 0, 0, 0.85);
      }
      .ui.cards > .card > .content > a.header:hover,
      .ui.card > .content > a.header:hover {
        color: #1e70bf;
      }

      /* Meta */
      .ui.cards > .card .meta > a:not(.ui),
      .ui.card .meta > a:not(.ui) {
        color: rgba(0, 0, 0, 0.4);
      }
      .ui.cards > .card .meta > a:not(.ui):hover,
      .ui.card .meta > a:not(.ui):hover {
        color: rgba(0, 0, 0, 0.87);
      }

      /*--------------
          Buttons
      ---------------*/

      .ui.cards > .card > .buttons,
      .ui.card > .buttons,
      .ui.cards > .card > .button,
      .ui.card > .button {
        margin: 0px -1px;
        width: calc(100% +  2px );
      }

      /*--------------
            Dimmer
      ---------------*/

      .ui.cards > .card .dimmer,
      .ui.card .dimmer {
        background-color: '';
        z-index: 10;
      }

      /*--------------
          Labels
      ---------------*/


      /*-----Star----- */


      /* Icon */
      .ui.cards > .card > .content .star.icon,
      .ui.card > .content .star.icon {
        cursor: pointer;
        opacity: 0.75;
        -webkit-transition: color 0.1s ease;
        transition: color 0.1s ease;
      }
      .ui.cards > .card > .content .star.icon:hover,
      .ui.card > .content .star.icon:hover {
        opacity: 1;
        color: #FFB70A;
      }
      .ui.cards > .card > .content .active.star.icon,
      .ui.card > .content .active.star.icon {
        color: #FFE623;
      }

      /*-----Like----- */


      /* Icon */
      .ui.cards > .card > .content .like.icon,
      .ui.card > .content .like.icon {
        cursor: pointer;
        opacity: 0.75;
        -webkit-transition: color 0.1s ease;
        transition: color 0.1s ease;
      }
      .ui.cards > .card > .content .like.icon:hover,
      .ui.card > .content .like.icon:hover {
        opacity: 1;
        color: #FF2733;
      }
      .ui.cards > .card > .content .active.like.icon,
      .ui.card > .content .active.like.icon {
        color: #FF2733;
      }

      /*----------------
        Extra Content
      -----------------*/

      .ui.cards > .card > .extra,
      .ui.card > .extra {
        max-width: 100%;
        min-height: 0em !important;
        -webkit-box-flex: 0;
            -ms-flex-positive: 0;
                flex-grow: 0;
        border-top: 1px solid rgba(0, 0, 0, 0.05) !important;
        position: static;
        background: none;
        width: auto;
        margin: 0em 0em;
        padding: 0.75em 1em;
        top: 0em;
        left: 0em;
        color: rgba(0, 0, 0, 0.4);
        -webkit-box-shadow: none;
                box-shadow: none;
        -webkit-transition: color 0.1s ease;
        transition: color 0.1s ease;
      }
      .ui.cards > .card > .extra a:not(.ui),
      .ui.card > .extra a:not(.ui) {
        color: rgba(0, 0, 0, 0.4);
      }
      .ui.cards > .card > .extra a:not(.ui):hover,
      .ui.card > .extra a:not(.ui):hover {
        color: #1e70bf;
      }


      /*******************************
                Variations
      *******************************/


      /*-------------------
            Raised
      --------------------*/

      .ui.raised.cards > .card,
      .ui.raised.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 4px 0px rgba(34, 36, 38, 0.12), 0px 2px 10px 0px rgba(34, 36, 38, 0.15);
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 4px 0px rgba(34, 36, 38, 0.12), 0px 2px 10px 0px rgba(34, 36, 38, 0.15);
      }
      .ui.raised.cards a.card:hover,
      .ui.link.cards .raised.card:hover,
      a.ui.raised.card:hover,
      .ui.link.raised.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 4px 0px rgba(34, 36, 38, 0.15), 0px 2px 10px 0px rgba(34, 36, 38, 0.25);
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 4px 0px rgba(34, 36, 38, 0.15), 0px 2px 10px 0px rgba(34, 36, 38, 0.25);
      }
      .ui.raised.cards > .card,
      .ui.raised.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 4px 0px rgba(34, 36, 38, 0.12), 0px 2px 10px 0px rgba(34, 36, 38, 0.15);
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 4px 0px rgba(34, 36, 38, 0.12), 0px 2px 10px 0px rgba(34, 36, 38, 0.15);
      }

      /*-------------------
            Centered
      --------------------*/

      .ui.centered.cards {
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
      }
      .ui.centered.card {
        margin-left: auto;
        margin-right: auto;
      }

      /*-------------------
              Fluid
      --------------------*/

      .ui.fluid.card {
        width: 100%;
        max-width: 9999px;
      }

      /*-------------------
              Link
      --------------------*/

      .ui.cards a.card,
      .ui.link.cards .card,
      a.ui.card,
      .ui.link.card {
        -webkit-transform: none;
                transform: none;
      }
      .ui.cards a.card:hover,
      .ui.link.cards .card:hover,
      a.ui.card:hover,
      .ui.link.card:hover {
        cursor: pointer;
        z-index: 5;
        background: #FFFFFF;
        border: none;
        -webkit-box-shadow: 0px 1px 3px 0px #BCBDBD, 0px 0px 0px 1px #D4D4D5;
                box-shadow: 0px 1px 3px 0px #BCBDBD, 0px 0px 0px 1px #D4D4D5;
        -webkit-transform: translateY(-3px);
                transform: translateY(-3px);
      }

      /*-------------------
            Colors
      --------------------*/


      /* Red */
      .ui.red.cards > .card,
      .ui.cards > .red.card,
      .ui.red.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #DB2828, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #DB2828, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.red.cards > .card:hover,
      .ui.cards > .red.card:hover,
      .ui.red.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #d01919, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #d01919, 0px 1px 3px 0px #BCBDBD;
      }

      /* Orange */
      .ui.orange.cards > .card,
      .ui.cards > .orange.card,
      .ui.orange.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #F2711C, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #F2711C, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.orange.cards > .card:hover,
      .ui.cards > .orange.card:hover,
      .ui.orange.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #f26202, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #f26202, 0px 1px 3px 0px #BCBDBD;
      }

      /* Yellow */
      .ui.yellow.cards > .card,
      .ui.cards > .yellow.card,
      .ui.yellow.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #FBBD08, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #FBBD08, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.yellow.cards > .card:hover,
      .ui.cards > .yellow.card:hover,
      .ui.yellow.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #eaae00, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #eaae00, 0px 1px 3px 0px #BCBDBD;
      }

      /* Olive */
      .ui.olive.cards > .card,
      .ui.cards > .olive.card,
      .ui.olive.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #B5CC18, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #B5CC18, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.olive.cards > .card:hover,
      .ui.cards > .olive.card:hover,
      .ui.olive.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #a7bd0d, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #a7bd0d, 0px 1px 3px 0px #BCBDBD;
      }

      /* Green */
      .ui.green.cards > .card,
      .ui.cards > .green.card,
      .ui.green.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #21BA45, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #21BA45, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.green.cards > .card:hover,
      .ui.cards > .green.card:hover,
      .ui.green.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #16ab39, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #16ab39, 0px 1px 3px 0px #BCBDBD;
      }

      /* Teal */
      .ui.teal.cards > .card,
      .ui.cards > .teal.card,
      .ui.teal.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #00B5AD, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #00B5AD, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.teal.cards > .card:hover,
      .ui.cards > .teal.card:hover,
      .ui.teal.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #009c95, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #009c95, 0px 1px 3px 0px #BCBDBD;
      }

      /* Blue */
      .ui.blue.cards > .card,
      .ui.cards > .blue.card,
      .ui.blue.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #2185D0, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #2185D0, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.blue.cards > .card:hover,
      .ui.cards > .blue.card:hover,
      .ui.blue.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #1678c2, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #1678c2, 0px 1px 3px 0px #BCBDBD;
      }

      /* Violet */
      .ui.violet.cards > .card,
      .ui.cards > .violet.card,
      .ui.violet.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #6435C9, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #6435C9, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.violet.cards > .card:hover,
      .ui.cards > .violet.card:hover,
      .ui.violet.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #5829bb, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #5829bb, 0px 1px 3px 0px #BCBDBD;
      }

      /* Purple */
      .ui.purple.cards > .card,
      .ui.cards > .purple.card,
      .ui.purple.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #A333C8, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #A333C8, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.purple.cards > .card:hover,
      .ui.cards > .purple.card:hover,
      .ui.purple.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #9627ba, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #9627ba, 0px 1px 3px 0px #BCBDBD;
      }

      /* Pink */
      .ui.pink.cards > .card,
      .ui.cards > .pink.card,
      .ui.pink.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #E03997, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #E03997, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.pink.cards > .card:hover,
      .ui.cards > .pink.card:hover,
      .ui.pink.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #e61a8d, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #e61a8d, 0px 1px 3px 0px #BCBDBD;
      }

      /* Brown */
      .ui.brown.cards > .card,
      .ui.cards > .brown.card,
      .ui.brown.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #A5673F, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #A5673F, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.brown.cards > .card:hover,
      .ui.cards > .brown.card:hover,
      .ui.brown.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #975b33, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #975b33, 0px 1px 3px 0px #BCBDBD;
      }

      /* Grey */
      .ui.grey.cards > .card,
      .ui.cards > .grey.card,
      .ui.grey.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #767676, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #767676, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.grey.cards > .card:hover,
      .ui.cards > .grey.card:hover,
      .ui.grey.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #838383, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #838383, 0px 1px 3px 0px #BCBDBD;
      }

      /* Black */
      .ui.black.cards > .card,
      .ui.cards > .black.card,
      .ui.black.card {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #1B1C1D, 0px 1px 3px 0px #D4D4D5;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #1B1C1D, 0px 1px 3px 0px #D4D4D5;
      }
      .ui.black.cards > .card:hover,
      .ui.cards > .black.card:hover,
      .ui.black.card:hover {
        -webkit-box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #27292a, 0px 1px 3px 0px #BCBDBD;
                box-shadow: 0px 0px 0px 1px #D4D4D5, 0px 2px 0px 0px #27292a, 0px 1px 3px 0px #BCBDBD;
      }

      /*--------------
        Card Count
      ---------------*/

      .ui.one.cards {
        margin-left: 0em;
        margin-right: 0em;
      }
      .ui.one.cards > .card {
        width: 100%;
      }
      .ui.two.cards {
        margin-left: -1em;
        margin-right: -1em;
      }
      .ui.two.cards > .card {
        width: calc( 50%  -  2em );
        margin-left: 1em;
        margin-right: 1em;
      }
      .ui.three.cards {
        margin-left: -1em;
        margin-right: -1em;
      }
      .ui.three.cards > .card {
        width: calc( 33.33333333%  -  2em );
        margin-left: 1em;
        margin-right: 1em;
      }
      .ui.four.cards {
        margin-left: -0.75em;
        margin-right: -0.75em;
      }
      .ui.four.cards > .card {
        width: calc( 25%  -  1.5em );
        margin-left: 0.75em;
        margin-right: 0.75em;
      }
      .ui.five.cards {
        margin-left: -0.75em;
        margin-right: -0.75em;
      }
      .ui.five.cards > .card {
        width: calc( 20%  -  1.5em );
        margin-left: 0.75em;
        margin-right: 0.75em;
      }
      .ui.six.cards {
        margin-left: -0.75em;
        margin-right: -0.75em;
      }
      .ui.six.cards > .card {
        width: calc( 16.66666667%  -  1.5em );
        margin-left: 0.75em;
        margin-right: 0.75em;
      }
      .ui.seven.cards {
        margin-left: -0.5em;
        margin-right: -0.5em;
      }
      .ui.seven.cards > .card {
        width: calc( 14.28571429%  -  1em );
        margin-left: 0.5em;
        margin-right: 0.5em;
      }
      .ui.eight.cards {
        margin-left: -0.5em;
        margin-right: -0.5em;
      }
      .ui.eight.cards > .card {
        width: calc( 12.5%  -  1em );
        margin-left: 0.5em;
        margin-right: 0.5em;
        font-size: 11px;
      }
      .ui.nine.cards {
        margin-left: -0.5em;
        margin-right: -0.5em;
      }
      .ui.nine.cards > .card {
        width: calc( 11.11111111%  -  1em );
        margin-left: 0.5em;
        margin-right: 0.5em;
        font-size: 10px;
      }
      .ui.ten.cards {
        margin-left: -0.5em;
        margin-right: -0.5em;
      }
      .ui.ten.cards > .card {
        width: calc( 10%  -  1em );
        margin-left: 0.5em;
        margin-right: 0.5em;
      }

      /*-------------------
            Doubling
      --------------------*/


      /* Mobile Only */
      @media only screen and (max-width: 767px) {
        .ui.two.doubling.cards {
          margin-left: 0em;
          margin-right: 0em;
        }
        .ui.two.doubling.cards > .card {
          width: 100%;
          margin-left: 0em;
          margin-right: 0em;
        }
        .ui.three.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.three.doubling.cards > .card {
          width: calc( 50%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.four.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.four.doubling.cards > .card {
          width: calc( 50%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.five.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.five.doubling.cards > .card {
          width: calc( 50%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.six.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.six.doubling.cards > .card {
          width: calc( 50%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.seven.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.seven.doubling.cards > .card {
          width: calc( 33.33333333%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.eight.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.eight.doubling.cards > .card {
          width: calc( 33.33333333%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.nine.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.nine.doubling.cards > .card {
          width: calc( 33.33333333%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.ten.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.ten.doubling.cards > .card {
          width: calc( 33.33333333%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
      }

      /* Tablet Only */
      @media only screen and (min-width: 768px) and (max-width: 991px) {
        .ui.two.doubling.cards {
          margin-left: 0em;
          margin-right: 0em;
        }
        .ui.two.doubling.cards > .card {
          width: 100%;
          margin-left: 0em;
          margin-right: 0em;
        }
        .ui.three.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.three.doubling.cards > .card {
          width: calc( 50%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.four.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.four.doubling.cards > .card {
          width: calc( 50%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.five.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.five.doubling.cards > .card {
          width: calc( 33.33333333%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.six.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.six.doubling.cards > .card {
          width: calc( 33.33333333%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.eight.doubling.cards {
          margin-left: -1em;
          margin-right: -1em;
        }
        .ui.eight.doubling.cards > .card {
          width: calc( 33.33333333%  -  2em );
          margin-left: 1em;
          margin-right: 1em;
        }
        .ui.eight.doubling.cards {
          margin-left: -0.75em;
          margin-right: -0.75em;
        }
        .ui.eight.doubling.cards > .card {
          width: calc( 25%  -  1.5em );
          margin-left: 0.75em;
          margin-right: 0.75em;
        }
        .ui.nine.doubling.cards {
          margin-left: -0.75em;
          margin-right: -0.75em;
        }
        .ui.nine.doubling.cards > .card {
          width: calc( 25%  -  1.5em );
          margin-left: 0.75em;
          margin-right: 0.75em;
        }
        .ui.ten.doubling.cards {
          margin-left: -0.75em;
          margin-right: -0.75em;
        }
        .ui.ten.doubling.cards > .card {
          width: calc( 20%  -  1.5em );
          margin-left: 0.75em;
          margin-right: 0.75em;
        }
      }

      /*-------------------
            Stackable
      --------------------*/

      @media only screen and (max-width: 767px) {
        .ui.stackable.cards {
          display: block !important;
        }
        .ui.stackable.cards .card:first-child {
          margin-top: 0em !important;
        }
        .ui.stackable.cards > .card {
          display: block !important;
          height: auto !important;
          margin: 1em 1em;
          padding: 0 !important;
          width: calc( 100%  -  2em ) !important;
        }
      }

      /*--------------
            Size
      ---------------*/

      .ui.cards > .card {
        font-size: 1em;
      }


      /*******************************
              Theme Overrides
      *******************************/



      /*******************************
          User Variable Overrides
      *******************************/

  </style>

  <!--- Label --->
  <style>
     /*
      * # Semantic UI - 2.4.2
      * https://github.com/Semantic-Org/Semantic-UI
      * http://www.semantic-ui.com/
      *
      * Copyright 2014 Contributors
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */
      /*!
      * # Semantic UI - Label
      * http://github.com/semantic-org/semantic-ui/
      *
      *
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */


      /*******************************
                  Label
      *******************************/

      .ui.label {
        display: inline-block;
        line-height: 1;
        vertical-align: baseline;
        margin: 0em 0.14285714em;
        background-color: #E8E8E8;
        background-image: none;
        padding: 0.5833em 0.833em;
        color: rgba(0, 0, 0, 0.6);
        text-transform: none;
        font-weight: bold;
        border: 0px solid transparent;
        border-radius: 0.28571429rem;
        -webkit-transition: background 0.1s ease;
        transition: background 0.1s ease;
      }
      .ui.label:first-child {
        margin-left: 0em;
      }
      .ui.label:last-child {
        margin-right: 0em;
      }

      /* Link */
      a.ui.label {
        cursor: pointer;
      }

      /* Inside Link */
      .ui.label > a {
        cursor: pointer;
        color: inherit;
        opacity: 0.5;
        -webkit-transition: 0.1s opacity ease;
        transition: 0.1s opacity ease;
      }
      .ui.label > a:hover {
        opacity: 1;
      }

      /* Image */
      .ui.label > img {
        width: auto !important;
        vertical-align: middle;
        height: 2.1666em !important;
      }

      /* Icon */
      .ui.label > .icon {
        width: auto;
        margin: 0em 0.75em 0em 0em;
      }

      /* Detail */
      .ui.label > .detail {
        display: inline-block;
        vertical-align: top;
        font-weight: bold;
        margin-left: 1em;
        opacity: 0.8;
      }
      .ui.label > .detail .icon {
        margin: 0em 0.25em 0em 0em;
      }

      /* Removable label */
      .ui.label > .close.icon,
      .ui.label > .delete.icon {
        cursor: pointer;
        margin-right: 0em;
        margin-left: 0.5em;
        font-size: 0.92857143em;
        opacity: 0.5;
        -webkit-transition: background 0.1s ease;
        transition: background 0.1s ease;
      }
      .ui.label > .delete.icon:hover {
        opacity: 1;
      }

      /*-------------------
            Group
      --------------------*/

      .ui.labels > .label {
        margin: 0em 0.5em 0.5em 0em;
      }

      /*-------------------
            Coupling
      --------------------*/

      .ui.header > .ui.label {
        margin-top: -0.29165em;
      }

      /* Remove border radius on attached segment */
      .ui.attached.segment > .ui.top.left.attached.label,
      .ui.bottom.attached.segment > .ui.top.left.attached.label {
        border-top-left-radius: 0;
      }
      .ui.attached.segment > .ui.top.right.attached.label,
      .ui.bottom.attached.segment > .ui.top.right.attached.label {
        border-top-right-radius: 0;
      }
      .ui.top.attached.segment > .ui.bottom.left.attached.label {
        border-bottom-left-radius: 0;
      }
      .ui.top.attached.segment > .ui.bottom.right.attached.label {
        border-bottom-right-radius: 0;
      }

      /* Padding on next content after a label */
      .ui.top.attached.label:first-child + :not(.attached),
      .ui.top.attached.label + [class*="right floated"] + * {
        margin-top: 2rem !important;
      }
      .ui.bottom.attached.label:first-child ~ :last-child:not(.attached) {
        margin-top: 0em;
        margin-bottom: 2rem !important;
      }


      /*******************************
                  Types
      *******************************/

      .ui.image.label {
        width: auto !important;
        margin-top: 0em;
        margin-bottom: 0em;
        max-width: 9999px;
        vertical-align: baseline;
        text-transform: none;
        background: #E8E8E8;
        padding: 0.5833em 0.833em 0.5833em 0.5em;
        border-radius: 0.28571429rem;
        -webkit-box-shadow: none;
                box-shadow: none;
      }
      .ui.image.label img {
        display: inline-block;
        vertical-align: top;
        height: 2.1666em;
        margin: -0.5833em 0.5em -0.5833em -0.5em;
        border-radius: 0.28571429rem 0em 0em 0.28571429rem;
      }
      .ui.image.label .detail {
        background: rgba(0, 0, 0, 0.1);
        margin: -0.5833em -0.833em -0.5833em 0.5em;
        padding: 0.5833em 0.833em;
        border-radius: 0em 0.28571429rem 0.28571429rem 0em;
      }

      /*-------------------
              Tag
      --------------------*/

      .ui.tag.labels .label,
      .ui.tag.label {
        margin-left: 1em;
        position: relative;
        padding-left: 1.5em;
        padding-right: 1.5em;
        border-radius: 0em 0.28571429rem 0.28571429rem 0em;
        -webkit-transition: none;
        transition: none;
      }
      .ui.tag.labels .label:before,
      .ui.tag.label:before {
        position: absolute;
        -webkit-transform: translateY(-50%) translateX(50%) rotate(-45deg);
                transform: translateY(-50%) translateX(50%) rotate(-45deg);
        top: 50%;
        right: 100%;
        content: '';
        background-color: inherit;
        background-image: none;
        width: 1.56em;
        height: 1.56em;
        -webkit-transition: none;
        transition: none;
      }
      .ui.tag.labels .label:after,
      .ui.tag.label:after {
        position: absolute;
        content: '';
        top: 50%;
        left: -0.25em;
        margin-top: -0.25em;
        background-color: #FFFFFF !important;
        width: 0.5em;
        height: 0.5em;
        -webkit-box-shadow: 0 -1px 1px 0 rgba(0, 0, 0, 0.3);
                box-shadow: 0 -1px 1px 0 rgba(0, 0, 0, 0.3);
        border-radius: 500rem;
      }

      /*-------------------
          Corner Label
      --------------------*/

      .ui.corner.label {
        position: absolute;
        top: 0em;
        right: 0em;
        margin: 0em;
        padding: 0em;
        text-align: center;
        border-color: #E8E8E8;
        width: 4em;
        height: 4em;
        z-index: 1;
        -webkit-transition: border-color 0.1s ease;
        transition: border-color 0.1s ease;
      }

      /* Icon Label */
      .ui.corner.label {
        background-color: transparent !important;
      }
      .ui.corner.label:after {
        position: absolute;
        content: "";
        right: 0em;
        top: 0em;
        z-index: -1;
        width: 0em;
        height: 0em;
        background-color: transparent !important;
        border-top: 0em solid transparent;
        border-right: 4em solid transparent;
        border-bottom: 4em solid transparent;
        border-left: 0em solid transparent;
        border-right-color: inherit;
        -webkit-transition: border-color 0.1s ease;
        transition: border-color 0.1s ease;
      }
      .ui.corner.label .icon {
        cursor: default;
        position: relative;
        top: 0.64285714em;
        left: 0.78571429em;
        font-size: 1.14285714em;
        margin: 0em;
      }

      /* Left Corner */
      .ui.left.corner.label,
      .ui.left.corner.label:after {
        right: auto;
        left: 0em;
      }
      .ui.left.corner.label:after {
        border-top: 4em solid transparent;
        border-right: 4em solid transparent;
        border-bottom: 0em solid transparent;
        border-left: 0em solid transparent;
        border-top-color: inherit;
      }
      .ui.left.corner.label .icon {
        left: -0.78571429em;
      }

      /* Segment */
      .ui.segment > .ui.corner.label {
        top: -1px;
        right: -1px;
      }
      .ui.segment > .ui.left.corner.label {
        right: auto;
        left: -1px;
      }

      /*-------------------
            Ribbon
      --------------------*/

      .ui.ribbon.label {
        position: relative;
        margin: 0em;
        min-width: -webkit-max-content;
        min-width: -moz-max-content;
        min-width: max-content;
        border-radius: 0em 0.28571429rem 0.28571429rem 0em;
        border-color: rgba(0, 0, 0, 0.15);
      }
      .ui.ribbon.label:after {
        position: absolute;
        content: '';
        top: 100%;
        left: 0%;
        background-color: transparent !important;
        border-style: solid;
        border-width: 0em 1.2em 1.2em 0em;
        border-color: transparent;
        border-right-color: inherit;
        width: 0em;
        height: 0em;
      }

      /* Positioning */
      .ui.ribbon.label {
        left: calc(-1rem - 1.2em);
        margin-right: -1.2em;
        padding-left: calc(1rem + 1.2em);
        padding-right: 1.2em;
      }
      .ui[class*="right ribbon"].label {
        left: calc(100% + 1rem + 1.2em);
        padding-left: 1.2em;
        padding-right: calc(1rem + 1.2em);
      }

      /* Right Ribbon */
      .ui[class*="right ribbon"].label {
        text-align: left;
        -webkit-transform: translateX(-100%);
                transform: translateX(-100%);
        border-radius: 0.28571429rem 0em 0em 0.28571429rem;
      }
      .ui[class*="right ribbon"].label:after {
        left: auto;
        right: 0%;
        border-style: solid;
        border-width: 1.2em 1.2em 0em 0em;
        border-color: transparent;
        border-top-color: inherit;
      }

      /* Inside Table */
      .ui.image > .ribbon.label,
      .ui.card .image > .ribbon.label {
        position: absolute;
        top: 1rem;
      }
      .ui.card .image > .ui.ribbon.label,
      .ui.image > .ui.ribbon.label {
        left: calc(--0.05rem - 1.2em);
      }
      .ui.card .image > .ui[class*="right ribbon"].label,
      .ui.image > .ui[class*="right ribbon"].label {
        left: calc(100% + -0.05rem + 1.2em);
        padding-left: 0.833em;
      }

      /* Inside Table */
      .ui.table td > .ui.ribbon.label {
        left: calc(-0.78571429em - 1.2em);
      }
      .ui.table td > .ui[class*="right ribbon"].label {
        left: calc(100% + 0.78571429em + 1.2em);
        padding-left: 0.833em;
      }

      /*-------------------
            Attached
      --------------------*/

      .ui[class*="top attached"].label,
      .ui.attached.label {
        width: 100%;
        position: absolute;
        margin: 0em;
        top: 0em;
        left: 0em;
        padding: 0.75em 1em;
        border-radius: 0.21428571rem 0.21428571rem 0em 0em;
      }
      .ui[class*="bottom attached"].label {
        top: auto;
        bottom: 0em;
        border-radius: 0em 0em 0.21428571rem 0.21428571rem;
      }
      .ui[class*="top left attached"].label {
        width: auto;
        margin-top: 0em !important;
        border-radius: 0.21428571rem 0em 0.28571429rem 0em;
      }
      .ui[class*="top right attached"].label {
        width: auto;
        left: auto;
        right: 0em;
        border-radius: 0em 0.21428571rem 0em 0.28571429rem;
      }
      .ui[class*="bottom left attached"].label {
        width: auto;
        top: auto;
        bottom: 0em;
        border-radius: 0em 0.28571429rem 0em 0.21428571rem;
      }
      .ui[class*="bottom right attached"].label {
        top: auto;
        bottom: 0em;
        left: auto;
        right: 0em;
        width: auto;
        border-radius: 0.28571429rem 0em 0.21428571rem 0em;
      }


      /*******************************
                  States
      *******************************/


      /*-------------------
            Disabled
      --------------------*/

      .ui.label.disabled {
        opacity: 0.5;
      }

      /*-------------------
              Hover
      --------------------*/

      a.ui.labels .label:hover,
      a.ui.label:hover {
        background-color: #E0E0E0;
        border-color: #E0E0E0;
        background-image: none;
        color: rgba(0, 0, 0, 0.8);
      }
      .ui.labels a.label:hover:before,
      a.ui.label:hover:before {
        color: rgba(0, 0, 0, 0.8);
      }

      /*-------------------
              Active
      --------------------*/

      .ui.active.label {
        background-color: #D0D0D0;
        border-color: #D0D0D0;
        background-image: none;
        color: rgba(0, 0, 0, 0.95);
      }
      .ui.active.label:before {
        background-color: #D0D0D0;
        background-image: none;
        color: rgba(0, 0, 0, 0.95);
      }

      /*-------------------
          Active Hover
      --------------------*/

      a.ui.labels .active.label:hover,
      a.ui.active.label:hover {
        background-color: #C8C8C8;
        border-color: #C8C8C8;
        background-image: none;
        color: rgba(0, 0, 0, 0.95);
      }
      .ui.labels a.active.label:ActiveHover:before,
      a.ui.active.label:ActiveHover:before {
        background-color: #C8C8C8;
        background-image: none;
        color: rgba(0, 0, 0, 0.95);
      }

      /*-------------------
            Visible
      --------------------*/

      .ui.labels.visible .label,
      .ui.label.visible:not(.dropdown) {
        display: inline-block !important;
      }

      /*-------------------
            Hidden
      --------------------*/

      .ui.labels.hidden .label,
      .ui.label.hidden {
        display: none !important;
      }


      /*******************************
                Variations
      *******************************/


      /*-------------------
            Colors
      --------------------*/


      /*--- Red ---*/

      .ui.red.labels .label,
      .ui.red.label {
        background-color: #DB2828 !important;
        border-color: #DB2828 !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.red.labels .label:hover,
      a.ui.red.label:hover {
        background-color: #d01919 !important;
        border-color: #d01919 !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.red.corner.label,
      .ui.red.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.red.ribbon.label {
        border-color: #b21e1e !important;
      }

      /* Basic */
      .ui.basic.red.label {
        background: none #FFFFFF !important;
        color: #DB2828 !important;
        border-color: #DB2828 !important;
      }
      .ui.basic.red.labels a.label:hover,
      a.ui.basic.red.label:hover {
        background-color: #FFFFFF !important;
        color: #d01919 !important;
        border-color: #d01919 !important;
      }

      /*--- Orange ---*/

      .ui.orange.labels .label,
      .ui.orange.label {
        background-color: #F2711C !important;
        border-color: #F2711C !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.orange.labels .label:hover,
      a.ui.orange.label:hover {
        background-color: #f26202 !important;
        border-color: #f26202 !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.orange.corner.label,
      .ui.orange.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.orange.ribbon.label {
        border-color: #cf590c !important;
      }

      /* Basic */
      .ui.basic.orange.label {
        background: none #FFFFFF !important;
        color: #F2711C !important;
        border-color: #F2711C !important;
      }
      .ui.basic.orange.labels a.label:hover,
      a.ui.basic.orange.label:hover {
        background-color: #FFFFFF !important;
        color: #f26202 !important;
        border-color: #f26202 !important;
      }

      /*--- Yellow ---*/

      .ui.yellow.labels .label,
      .ui.yellow.label {
        background-color: #FBBD08 !important;
        border-color: #FBBD08 !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.yellow.labels .label:hover,
      a.ui.yellow.label:hover {
        background-color: #eaae00 !important;
        border-color: #eaae00 !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.yellow.corner.label,
      .ui.yellow.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.yellow.ribbon.label {
        border-color: #cd9903 !important;
      }

      /* Basic */
      .ui.basic.yellow.label {
        background: none #FFFFFF !important;
        color: #FBBD08 !important;
        border-color: #FBBD08 !important;
      }
      .ui.basic.yellow.labels a.label:hover,
      a.ui.basic.yellow.label:hover {
        background-color: #FFFFFF !important;
        color: #eaae00 !important;
        border-color: #eaae00 !important;
      }

      /*--- Olive ---*/

      .ui.olive.labels .label,
      .ui.olive.label {
        background-color: #B5CC18 !important;
        border-color: #B5CC18 !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.olive.labels .label:hover,
      a.ui.olive.label:hover {
        background-color: #a7bd0d !important;
        border-color: #a7bd0d !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.olive.corner.label,
      .ui.olive.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.olive.ribbon.label {
        border-color: #198f35 !important;
      }

      /* Basic */
      .ui.basic.olive.label {
        background: none #FFFFFF !important;
        color: #B5CC18 !important;
        border-color: #B5CC18 !important;
      }
      .ui.basic.olive.labels a.label:hover,
      a.ui.basic.olive.label:hover {
        background-color: #FFFFFF !important;
        color: #a7bd0d !important;
        border-color: #a7bd0d !important;
      }

      /*--- Green ---*/

      .ui.green.labels .label,
      .ui.green.label {
        background-color: #21BA45 !important;
        border-color: #21BA45 !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.green.labels .label:hover,
      a.ui.green.label:hover {
        background-color: #16ab39 !important;
        border-color: #16ab39 !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.green.corner.label,
      .ui.green.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.green.ribbon.label {
        border-color: #198f35 !important;
      }

      /* Basic */
      .ui.basic.green.label {
        background: none #FFFFFF !important;
        color: #21BA45 !important;
        border-color: #21BA45 !important;
      }
      .ui.basic.green.labels a.label:hover,
      a.ui.basic.green.label:hover {
        background-color: #FFFFFF !important;
        color: #16ab39 !important;
        border-color: #16ab39 !important;
      }

      /*--- Teal ---*/

      .ui.teal.labels .label,
      .ui.teal.label {
        background-color: #00B5AD !important;
        border-color: #00B5AD !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.teal.labels .label:hover,
      a.ui.teal.label:hover {
        background-color: #009c95 !important;
        border-color: #009c95 !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.teal.corner.label,
      .ui.teal.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.teal.ribbon.label {
        border-color: #00827c !important;
      }

      /* Basic */
      .ui.basic.teal.label {
        background: none #FFFFFF !important;
        color: #00B5AD !important;
        border-color: #00B5AD !important;
      }
      .ui.basic.teal.labels a.label:hover,
      a.ui.basic.teal.label:hover {
        background-color: #FFFFFF !important;
        color: #009c95 !important;
        border-color: #009c95 !important;
      }

      /*--- Blue ---*/

      .ui.blue.labels .label,
      .ui.blue.label {
        background-color: #2185D0 !important;
        border-color: #2185D0 !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.blue.labels .label:hover,
      a.ui.blue.label:hover {
        background-color: #1678c2 !important;
        border-color: #1678c2 !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.blue.corner.label,
      .ui.blue.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.blue.ribbon.label {
        border-color: #1a69a4 !important;
      }

      /* Basic */
      .ui.basic.blue.label {
        background: none #FFFFFF !important;
        color: #2185D0 !important;
        border-color: #2185D0 !important;
      }
      .ui.basic.blue.labels a.label:hover,
      a.ui.basic.blue.label:hover {
        background-color: #FFFFFF !important;
        color: #1678c2 !important;
        border-color: #1678c2 !important;
      }

      /*--- Violet ---*/

      .ui.violet.labels .label,
      .ui.violet.label {
        background-color: #6435C9 !important;
        border-color: #6435C9 !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.violet.labels .label:hover,
      a.ui.violet.label:hover {
        background-color: #5829bb !important;
        border-color: #5829bb !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.violet.corner.label,
      .ui.violet.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.violet.ribbon.label {
        border-color: #502aa1 !important;
      }

      /* Basic */
      .ui.basic.violet.label {
        background: none #FFFFFF !important;
        color: #6435C9 !important;
        border-color: #6435C9 !important;
      }
      .ui.basic.violet.labels a.label:hover,
      a.ui.basic.violet.label:hover {
        background-color: #FFFFFF !important;
        color: #5829bb !important;
        border-color: #5829bb !important;
      }

      /*--- Purple ---*/

      .ui.purple.labels .label,
      .ui.purple.label {
        background-color: #A333C8 !important;
        border-color: #A333C8 !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.purple.labels .label:hover,
      a.ui.purple.label:hover {
        background-color: #9627ba !important;
        border-color: #9627ba !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.purple.corner.label,
      .ui.purple.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.purple.ribbon.label {
        border-color: #82299f !important;
      }

      /* Basic */
      .ui.basic.purple.label {
        background: none #FFFFFF !important;
        color: #A333C8 !important;
        border-color: #A333C8 !important;
      }
      .ui.basic.purple.labels a.label:hover,
      a.ui.basic.purple.label:hover {
        background-color: #FFFFFF !important;
        color: #9627ba !important;
        border-color: #9627ba !important;
      }

      /*--- Pink ---*/

      .ui.pink.labels .label,
      .ui.pink.label {
        background-color: #E03997 !important;
        border-color: #E03997 !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.pink.labels .label:hover,
      a.ui.pink.label:hover {
        background-color: #e61a8d !important;
        border-color: #e61a8d !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.pink.corner.label,
      .ui.pink.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.pink.ribbon.label {
        border-color: #c71f7e !important;
      }

      /* Basic */
      .ui.basic.pink.label {
        background: none #FFFFFF !important;
        color: #E03997 !important;
        border-color: #E03997 !important;
      }
      .ui.basic.pink.labels a.label:hover,
      a.ui.basic.pink.label:hover {
        background-color: #FFFFFF !important;
        color: #e61a8d !important;
        border-color: #e61a8d !important;
      }

      /*--- Brown ---*/

      .ui.brown.labels .label,
      .ui.brown.label {
        background-color: #A5673F !important;
        border-color: #A5673F !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.brown.labels .label:hover,
      a.ui.brown.label:hover {
        background-color: #975b33 !important;
        border-color: #975b33 !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.brown.corner.label,
      .ui.brown.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.brown.ribbon.label {
        border-color: #805031 !important;
      }

      /* Basic */
      .ui.basic.brown.label {
        background: none #FFFFFF !important;
        color: #A5673F !important;
        border-color: #A5673F !important;
      }
      .ui.basic.brown.labels a.label:hover,
      a.ui.basic.brown.label:hover {
        background-color: #FFFFFF !important;
        color: #975b33 !important;
        border-color: #975b33 !important;
      }

      /*--- Grey ---*/

      .ui.grey.labels .label,
      .ui.grey.label {
        background-color: #767676 !important;
        border-color: #767676 !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.grey.labels .label:hover,
      a.ui.grey.label:hover {
        background-color: #838383 !important;
        border-color: #838383 !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.grey.corner.label,
      .ui.grey.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.grey.ribbon.label {
        border-color: #805031 !important;
      }

      /* Basic */
      .ui.basic.grey.label {
        background: none #FFFFFF !important;
        color: #767676 !important;
        border-color: #767676 !important;
      }
      .ui.basic.grey.labels a.label:hover,
      a.ui.basic.grey.label:hover {
        background-color: #FFFFFF !important;
        color: #838383 !important;
        border-color: #838383 !important;
      }

      /*--- Black ---*/

      .ui.black.labels .label,
      .ui.black.label {
        background-color: #1B1C1D !important;
        border-color: #1B1C1D !important;
        color: #FFFFFF !important;
      }

      /* Link */
      .ui.black.labels .label:hover,
      a.ui.black.label:hover {
        background-color: #27292a !important;
        border-color: #27292a !important;
        color: #FFFFFF !important;
      }

      /* Corner */
      .ui.black.corner.label,
      .ui.black.corner.label:hover {
        background-color: transparent !important;
      }

      /* Ribbon */
      .ui.black.ribbon.label {
        border-color: #805031 !important;
      }

      /* Basic */
      .ui.basic.black.label {
        background: none #FFFFFF !important;
        color: #1B1C1D !important;
        border-color: #1B1C1D !important;
      }
      .ui.basic.black.labels a.label:hover,
      a.ui.basic.black.label:hover {
        background-color: #FFFFFF !important;
        color: #27292a !important;
        border-color: #27292a !important;
      }

      /*-------------------
              Basic
      --------------------*/

      .ui.basic.label {
        background: none #FFFFFF;
        border: 1px solid rgba(34, 36, 38, 0.15);
        color: rgba(0, 0, 0, 0.87);
        -webkit-box-shadow: none;
                box-shadow: none;
      }

      /* Link */
      a.ui.basic.label:hover {
        text-decoration: none;
        background: none #FFFFFF;
        color: #1e70bf;
        -webkit-box-shadow: 1px solid rgba(34, 36, 38, 0.15);
                box-shadow: 1px solid rgba(34, 36, 38, 0.15);
        -webkit-box-shadow: none;
                box-shadow: none;
      }

      /* Pointing */
      .ui.basic.pointing.label:before {
        border-color: inherit;
      }

      /*-------------------
            Fluid
      --------------------*/

      .ui.label.fluid,
      .ui.fluid.labels > .label {
        width: 100%;
        -webkit-box-sizing: border-box;
                box-sizing: border-box;
      }

      /*-------------------
            Inverted
      --------------------*/

      .ui.inverted.labels .label,
      .ui.inverted.label {
        color: rgba(255, 255, 255, 0.9) !important;
      }

      /*-------------------
          Horizontal
      --------------------*/

      .ui.horizontal.labels .label,
      .ui.horizontal.label {
        margin: 0em 0.5em 0em 0em;
        padding: 0.4em 0.833em;
        min-width: 3em;
        text-align: center;
      }

      /*-------------------
            Circular
      --------------------*/

      .ui.circular.labels .label,
      .ui.circular.label {
        min-width: 2em;
        min-height: 2em;
        padding: 0.5em !important;
        line-height: 1em;
        text-align: center;
        border-radius: 500rem;
      }
      .ui.empty.circular.labels .label,
      .ui.empty.circular.label {
        min-width: 0em;
        min-height: 0em;
        overflow: hidden;
        width: 0.5em;
        height: 0.5em;
        vertical-align: baseline;
      }

      /*-------------------
            Pointing
      --------------------*/

      .ui.pointing.label {
        position: relative;
      }
      .ui.attached.pointing.label {
        position: absolute;
      }
      .ui.pointing.label:before {
        background-color: inherit;
        background-image: inherit;
        border-width: none;
        border-style: solid;
        border-color: inherit;
      }

      /* Arrow */
      .ui.pointing.label:before {
        position: absolute;
        content: '';
        -webkit-transform: rotate(45deg);
                transform: rotate(45deg);
        background-image: none;
        z-index: 2;
        width: 0.6666em;
        height: 0.6666em;
        -webkit-transition: background 0.1s ease;
        transition: background 0.1s ease;
      }

      /*--- Above ---*/

      .ui.pointing.label,
      .ui[class*="pointing above"].label {
        margin-top: 1em;
      }
      .ui.pointing.label:before,
      .ui[class*="pointing above"].label:before {
        border-width: 1px 0px 0px 1px;
        -webkit-transform: translateX(-50%) translateY(-50%) rotate(45deg);
                transform: translateX(-50%) translateY(-50%) rotate(45deg);
        top: 0%;
        left: 50%;
      }

      /*--- Below ---*/

      .ui[class*="bottom pointing"].label,
      .ui[class*="pointing below"].label {
        margin-top: 0em;
        margin-bottom: 1em;
      }
      .ui[class*="bottom pointing"].label:before,
      .ui[class*="pointing below"].label:before {
        border-width: 0px 1px 1px 0px;
        top: auto;
        right: auto;
        -webkit-transform: translateX(-50%) translateY(-50%) rotate(45deg);
                transform: translateX(-50%) translateY(-50%) rotate(45deg);
        top: 100%;
        left: 50%;
      }

      /*--- Left ---*/

      .ui[class*="left pointing"].label {
        margin-top: 0em;
        margin-left: 0.6666em;
      }
      .ui[class*="left pointing"].label:before {
        border-width: 0px 0px 1px 1px;
        -webkit-transform: translateX(-50%) translateY(-50%) rotate(45deg);
                transform: translateX(-50%) translateY(-50%) rotate(45deg);
        bottom: auto;
        right: auto;
        top: 50%;
        left: 0em;
      }

      /*--- Right ---*/

      .ui[class*="right pointing"].label {
        margin-top: 0em;
        margin-right: 0.6666em;
      }
      .ui[class*="right pointing"].label:before {
        border-width: 1px 1px 0px 0px;
        -webkit-transform: translateX(50%) translateY(-50%) rotate(45deg);
                transform: translateX(50%) translateY(-50%) rotate(45deg);
        top: 50%;
        right: 0%;
        bottom: auto;
        left: auto;
      }

      /* Basic Pointing */

      /*--- Above ---*/

      .ui.basic.pointing.label:before,
      .ui.basic[class*="pointing above"].label:before {
        margin-top: -1px;
      }

      /*--- Below ---*/

      .ui.basic[class*="bottom pointing"].label:before,
      .ui.basic[class*="pointing below"].label:before {
        bottom: auto;
        top: 100%;
        margin-top: 1px;
      }

      /*--- Left ---*/

      .ui.basic[class*="left pointing"].label:before {
        top: 50%;
        left: -1px;
      }

      /*--- Right ---*/

      .ui.basic[class*="right pointing"].label:before {
        top: 50%;
        right: -1px;
      }

      /*------------------
        Floating Label
      -------------------*/

      .ui.floating.label {
        position: absolute;
        z-index: 100;
        top: -1em;
        left: 100%;
        margin: 0em 0em 0em -1.5em !important;
      }

      /*-------------------
              Sizes
      --------------------*/

      .ui.mini.labels .label,
      .ui.mini.label {
        font-size: 0.64285714rem;
      }
      .ui.tiny.labels .label,
      .ui.tiny.label {
        font-size: 0.71428571rem;
      }
      .ui.small.labels .label,
      .ui.small.label {
        font-size: 0.78571429rem;
      }
      .ui.labels .label,
      .ui.label {
        font-size: 0.85714286rem;
      }
      .ui.large.labels .label,
      .ui.large.label {
        font-size: 1rem;
      }
      .ui.big.labels .label,
      .ui.big.label {
        font-size: 1.28571429rem;
      }
      .ui.huge.labels .label,
      .ui.huge.label {
        font-size: 1.42857143rem;
      }
      .ui.massive.labels .label,
      .ui.massive.label {
        font-size: 1.71428571rem;
      }


      /*******************************
              Theme Overrides
      *******************************/



      /*******************************
              Site Overrides
      *******************************/

  </style>

  <!--- Comment -->
  <style>
     /*
      * # Semantic UI - 2.4.2
      * https://github.com/Semantic-Org/Semantic-UI
      * http://www.semantic-ui.com/
      *
      * Copyright 2014 Contributors
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */
      /*!
      * # Semantic UI - Comment
      * http://github.com/semantic-org/semantic-ui/
      *
      *
      * Released under the MIT license
      * http://opensource.org/licenses/MIT
      *
      */


      /*******************************
                  Standard
      *******************************/


      /*--------------
          Comments
      ---------------*/

      .ui.comments {
        margin: 1.5em 0em;
        max-width: 650px;
      }
      .ui.comments:first-child {
        margin-top: 0em;
      }
      .ui.comments:last-child {
        margin-bottom: 0em;
      }

      /*--------------
          Comment
      ---------------*/

      .ui.comments .comment {
        position: relative;
        background: none;
        margin: 0.5em 0em 0em;
        padding: 0.5em 0em 0em;
        border: none;
        border-top: none;
        line-height: 1.2;
      }
      .ui.comments .comment:first-child {
        margin-top: 0em;
        padding-top: 0em;
      }

      /*--------------------
          Nested Comments
      ---------------------*/

      .ui.comments .comment .comments {
        margin: 0em 0em 0.5em 0.5em;
        padding: 1em 0em 1em 1em;
      }
      .ui.comments .comment .comments:before {
        position: absolute;
        top: 0px;
        left: 0px;
      }
      .ui.comments .comment .comments .comment {
        border: none;
        border-top: none;
        background: none;
      }

      /*--------------
          Avatar
      ---------------*/

      .ui.comments .comment .avatar {
        display: block;
        width: 2.5em;
        height: auto;
        float: left;
        margin: 0.2em 0em 0em;
      }
      .ui.comments .comment img.avatar,
      .ui.comments .comment .avatar img {
        display: block;
        margin: 0em auto;
        width: 100%;
        height: 100%;
        border-radius: 0.25rem;
      }

      /*--------------
          Content
      ---------------*/

      .ui.comments .comment > .content {
        display: block;
      }

      /* If there is an avatar move content over */
      .ui.comments .comment > .avatar ~ .content {
        margin-left: 3.5em;
      }

      /*--------------
          Author
      ---------------*/

      .ui.comments .comment .author {
        font-size: 1em;
        color: rgba(0, 0, 0, 0.87);
        font-weight: bold;
      }
      .ui.comments .comment a.author {
        cursor: pointer;
      }
      .ui.comments .comment a.author:hover {
        color: #1e70bf;
      }

      /*--------------
          Metadata
      ---------------*/

      .ui.comments .comment .metadata {
        display: inline-block;
        margin-left: 0.5em;
        color: rgba(0, 0, 0, 0.4);
        font-size: 0.875em;
      }
      .ui.comments .comment .metadata > * {
        display: inline-block;
        margin: 0em 0.5em 0em 0em;
      }
      .ui.comments .comment .metadata > :last-child {
        margin-right: 0em;
      }

      /*--------------------
          Comment Text
      ---------------------*/

      .ui.comments .comment .text {
        margin: 0.25em 0em 0.5em;
        font-size: 1em;
        word-wrap: break-word;
        color: rgba(0, 0, 0, 0.87);
        line-height: 1.3;
      }

      /*--------------------
          User Actions
      ---------------------*/

      .ui.comments .comment .actions {
        font-size: 0.875em;
      }
      .ui.comments .comment .actions a {
        cursor: pointer;
        display: inline-block;
        margin: 0em 0.75em 0em 0em;
        color: rgba(0, 0, 0, 0.4);
      }
      .ui.comments .comment .actions a:last-child {
        margin-right: 0em;
      }
      .ui.comments .comment .actions a.active,
      .ui.comments .comment .actions a:hover {
        color: rgba(0, 0, 0, 0.8);
      }

      /*--------------------
            Reply Form
      ---------------------*/

      .ui.comments > .reply.form {
        margin-top: 1em;
      }
      .ui.comments .comment .reply.form {
        width: 100%;
        margin-top: 1em;
      }
      .ui.comments .reply.form textarea {
        font-size: 1em;
        height: 12em;
      }


      /*******************************
                  State
      *******************************/

      .ui.collapsed.comments,
      .ui.comments .collapsed.comments,
      .ui.comments .collapsed.comment {
        display: none;
      }


      /*******************************
                Variations
      *******************************/


      /*--------------------
              Threaded
      ---------------------*/

      .ui.threaded.comments .comment .comments {
        margin: -1.5em 0 -1em 1.25em;
        padding: 3em 0em 2em 2.25em;
        -webkit-box-shadow: -1px 0px 0px rgba(34, 36, 38, 0.15);
                box-shadow: -1px 0px 0px rgba(34, 36, 38, 0.15);
      }

      /*--------------------
              Minimal
      ---------------------*/

      .ui.minimal.comments .comment .actions {
        opacity: 0;
        position: absolute;
        top: 0px;
        right: 0px;
        left: auto;
        -webkit-transition: opacity 0.2s ease;
        transition: opacity 0.2s ease;
        -webkit-transition-delay: 0.1s;
                transition-delay: 0.1s;
      }
      .ui.minimal.comments .comment > .content:hover > .actions {
        opacity: 1;
      }

      /*-------------------
              Sizes
      --------------------*/

      .ui.mini.comments {
        font-size: 0.78571429rem;
      }
      .ui.tiny.comments {
        font-size: 0.85714286rem;
      }
      .ui.small.comments {
        font-size: 0.92857143rem;
      }
      .ui.comments {
        font-size: 1rem;
      }
      .ui.large.comments {
        font-size: 1.14285714rem;
      }
      .ui.big.comments {
        font-size: 1.28571429rem;
      }
      .ui.huge.comments {
        font-size: 1.42857143rem;
      }
      .ui.massive.comments {
        font-size: 1.71428571rem;
      }


      /*******************************
              Theme Overrides
      *******************************/



      /*******************************
          User Variable Overrides
      *******************************/

  </style>

</head>
<body>
  
  @yield('content')

  <style type="text/css">

    /* Some basic formatting */
    code {
      background-color: #E0E0E0;
      padding: 0.25em 0.3em;
      font-family: 'Lato';
      font-weight: bold;
    }
    .container {
      padding: 5em 0em;
    }
    .ui.dividing.header,
    .first {
      margin-top: 5em;
    }

    .ui.dividing.header:first-child {
      margin-top: 0em;
    }

    h1,
    h3 {
      margin-top: 10em;
    }

    img {
      display: block;
      max-width: 100%;
    }
    img + img {
      margin-top: 0.5em;
    }

    /* Shows content box (not negative margins) */
    .grid {
      position: relative;
    }
    .grid:before {
      position: absolute;
      top: 1rem;
      left: 1rem;
      background-color: #F0F0F0;
      content: '';
      width: calc(100% - 2rem);
      height: calc(100% - 2rem);
      box-shadow: 0px 0px 0px 1px #DDDDDD inset;
    }
    .ui.divided.grid:before,
    .celled.grid:before {
      display: none;
    }
    .ui.aligned .column:after {
      display: none !important;
    }
    .grid .column:not(.row):not(.grid):after {
      background-color: rgba(86, 61, 124, .15);
      box-shadow: 0px 0px 0px 1px rgba(86, 61, 124, 0.2) inset;
      content: "";
      display: block;
      min-height: 50px;
    }
    @media only screen and (max-width: 768px) {
      .stackable.grid:before {
        width: 100%;
        left: 0em;
      }
    }
  </style>

</body>

</html>
