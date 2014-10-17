(function( incom, $, undefined ) {

  $(document).ready(function() {
    init();
  });

  var init = function() {
    handleTabs();
    addColourPicker();
  };

  var handleTabs = function() {
    $( "#tabs" ).tabs();
  };

  var addColourPicker = function() {
    $('#incom_picker_bgcolor').farbtastic('#incom_picker_input_bgcolor');
// Picker No 2:    $('#incom_picker_bgcolor').farbtastic('#incom_picker_input_bgcolor');
  };

  $('input[type="number"]').keyup(function () {
      if (this.value !== this.value.replace(/[^0-9\.]/g, '')) {
         this.value = this.value.replace(/[^0-9\.]/g, '');
      }
  });

}( window.incom = window.incom || {}, jQuery ));
