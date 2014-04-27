(function( incom, $, undefined ) {

  var $selectCommentType = $( 'select[name=select_comment_type]' );
  var classHidePraefix = '.hide-';
  var commentSystems = {
    // Comment Systems
    classDisqus: 'disqus',
    classWP: 'wp',
  };


  $(document).ready(function() {
    init();
  });


  var init = function() {
    handleSelect();
    handleTabs();
    addColourPicker();
  };

  var handleSelect = function() {
    // In general, hide specific elements
    handleSelectCommentType();

    // Handle change event
    $selectCommentType.change(function () {
      var $element = $( this );
      for ( var system in commentSystems ) {
        handleChangeCommentType( $element, commentSystems[system] );
      }
    });
  };

  var handleSelectCommentType = function() {
    for ( var system in commentSystems ) {
      var $classHide = $( classHidePraefix+commentSystems[system] );
      if ( $selectCommentType.val() !== commentSystems[system] ) {
        $classHide.hide();
      }
    }
  };

  var handleChangeCommentType = function( element, commentType ) {
    var $classHide = $( classHidePraefix+commentType );
    if ( element.val() === commentType ) {
      $classHide.show( 'fast' );
    }
    else {
       $classHide.hide( 'middle' );
    }
  };

  var handleTabs = function() {
    $( "#tabs" ).tabs();
  };

  var addColourPicker = function() {
    $('#incom_picker_bgcolor').farbtastic('#incom_picker_input_bgcolor');
// Picker No 2:    $('#incom_picker_bgcolor').farbtastic('#incom_picker_input_bgcolor');
  };

}( window.incom = window.incom || {}, jQuery ));
