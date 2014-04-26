(function( incom, $, undefined ) {

  $(document).ready(function($) {
    $( "#tabs" ).tabs();
  });

  var $selectCommentType = $( 'select[name=select_comment_type]' );
  var $classHideDisqus = $( '.hide-disqus' );

  if ( $selectCommentType.val() !== 'disqus' ) {
     $classHideDisqus.hide();
  }

  $selectCommentType.change(function () {
    if ( $( this ).val() === 'disqus' ) {
      $classHideDisqus.show( 'fast' );
    } else {
       $classHideDisqus.hide( 'middle' );
    }
  });

}( window.incom = window.incom || {}, jQuery ));
