(function( incom, $, undefined ) {

  var $selectCommentType = $( 'select[name=select_comment_type]' );

  var classHidePraefix = '.hide-';

  // Comment Systems
  var classHideDisqus = 'disqus';
  var classHideWP = 'wp';
  // Array with all comment systems
  var arrClassHide = [ classHideDisqus, classHideWP ];


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
      for (var i = arrClassHide.length - 1; i >= 0; i--) {
        handleChangeCommentType( $element, arrClassHide[i] );
      }
    });
  };

  var handleSelectCommentType = function() {
    for (var i = arrClassHide.length - 1; i >= 0; i--) {
      var $classHide = $( classHidePraefix+arrClassHide[i] );
      if ( $selectCommentType.val() !== arrClassHide[i] ) {
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
