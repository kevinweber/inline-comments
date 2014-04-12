/*
 * Inline Comments
 * by Kevin Weber
 */

(function( incom, $, undefined ) {

  var o;

  /*
   * Public methods
   */

  incom.init = function( options ) {
    setOptions( options );
    initCommentsWrapper();
    initSelectElements();
  };

  /*
   * Private methods
   */

  var setOptions = function( options ) {
    // Override defaults
    o = $.extend( {
        selectors: 'p',
        // identifier: 'disqussion',
        // displayCount: true,
        // highlighted: false,
        position: 'left',
        // background: 'white',
        // maxWidth: 9999,
      },
    options);
  };

  var initCommentsWrapper = function() {
    if ( $( '#incom_wrapper' ).length === 0 ) {
      $( '<div id="incom_wrapper"></div>' ).appendTo( $('body') );
    }
    // if ( $( '#incom_thread' ).length === 0 ) {
    //   $( '<div id="incom_thread"></div>' ).appendTo( '#incom_wrapper' );
    // }
  };

  /* 
   * Select elements and increase counter per element type (instead of using one counter for all elements independent of their types).
   */
  var initSelectElements = function() {
    var selectors = splitSelectors( o.selectors );

    $( selectors ).each( function(j) {

      $( selectors[j] ).each( function(i) {
        var $element = $( this );
        var $offset = $element.offset();

        addAtt( i, $element );

        var a = $('<a/>')
          .text('+')
          .wrap('<div class="incom-bubbles" />')
          .parent()
          .appendTo('#incom_wrapper');
            a.css({
              'top': $offset.top,
              'left': o.position === 'right' ? $offset.left + $element.outerWidth() : $offset.left - a.outerWidth()
            });

      });

    });
  };

  var addAtt = function(i, element) {
    // Use the first letter of the element's name as identifier
    var identifier = element.prop('tagName').substr(0,1);

    // If element has no attribute 'data-incom', add it
    if ( !element.attr( 'data-incom') ) {
      var attProp = identifier + i;
      element.attr( 'data-incom', attProp );
    }
  };

  /*
   * Split selectors
   * @return array
   */
  var splitSelectors = function( selectors ) {
    var splitSelectors = selectors.split(',');
    return splitSelectors;
  };

}( window.incom = window.incom || {}, jQuery ));
