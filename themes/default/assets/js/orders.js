// Generated by CoffeeScript 1.6.3
(function() {
  $(function() {
    var $orderButton, $orderConfirm, $overlay, $shakeElement, check_button;
    $('.information').tooltip({
      animation: false
    });
    if ($('#Orders_confirm').size() > 0) {
      $orderConfirm = $('#Orders_confirm');
      $shakeElement = $('#snake-element');
      $orderButton = $('.order-button').css({
        position: 'relative'
      });
      $overlay = $('<div />').css({
        position: "absolute",
        top: $orderButton.position().top,
        left: $orderButton.position().left,
        width: $orderButton.outerWidth(),
        height: $orderButton.outerHeight(),
        zIndex: 500,
        backgroundColor: "#fff",
        opacity: 0
      });
      $orderButton.parents('div').append($overlay);
      $overlay.click(function(e) {
        var clearShake;
        $shakeElement.addClass('shake animated');
        clearShake = function() {
          return $shakeElement.removeClass('shake animated');
        };
        return setTimeout(clearShake, 500);
      });
      check_button = function() {
        if ($orderConfirm.prop('checked')) {
          $orderButton.removeAttr('disabled').css({
            zIndex: 500
          });
          return $overlay.css({
            display: 'none',
            zIndex: 0
          });
        } else {
          $orderButton.attr('disabled', 'disabled').css({
            zIndex: 0
          });
          return $overlay.css({
            display: 'block',
            zIndex: 500
          });
        }
      };
      $orderConfirm.click(function(e) {
        return check_button();
      });
      return check_button();
    }
  });

}).call(this);

/*
//@ sourceMappingURL=orders.map
*/
