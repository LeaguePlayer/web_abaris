// Generated by CoffeeScript 1.6.3
(function() {
  $(function() {
    var Cart, cart;
    $('.catalog-grid-header').scrollToFixed({
      limit: 0
    });
    $('.pay-icon').on('click', function(e) {
      var x, y;
      x = e.clientX;
      y = e.clientY;
      return $.show_abaris_box('.sto-modal', {
        beforeShow: function() {
          return $('.blue-button').on('click', function() {
            return $.fancybox.close();
          });
        }
      });
    });
    Cart = (function() {
      function Cart() {
        var cartAction, cartGrid;
        cartGrid = $('#cart-details-list');
        this.generalSelected = cartGrid.find('.catalog-grid-row input:checkbox:checked').size();
        this.activeSelected = cartGrid.find('.catalog-grid-row').not('.archived').find('input:checkbox:checked').size();
        this.archiveSelected = cartGrid.find('.catalog-grid-row.archived input:checkbox:checked').size();
        cartAction = $('.subtotal.icons');
        this.generalCounters = cartAction.find('.item.total-select span.text .selected_count, .item.delete span.text .selected_count');
        this.activeCounters = cartAction.find('.item.active span.text .selected_count');
        this.arciveCounters = cartAction.find('.item.archive span.text .selected_count');
        this.cartActiveRows = $('#cart-details-list .catalog-grid-row').not('.archived');
        this.totalCostCounter = $('.summ .number');
      }

      Cart.prototype.updateCounters = function(actived, archived) {
        if (actived == null) {
          actived = 0;
        }
        if (archived == null) {
          archived = 0;
        }
        this.generalSelected += actived + archived;
        this.activeSelected += actived;
        this.archiveSelected += archived;
        this.generalCounters.text(this.generalSelected);
        this.activeCounters.text(this.activeSelected);
        return this.arciveCounters.text(this.archiveSelected);
      };

      Cart.prototype.updateCost = function(currentRow) {
        var discount, total;
        if (currentRow == null) {
          currentRow = false;
        }
        total = 0;
        discount = 0;
        this.cartActiveRows.each(function() {
          var currentCost, priceCell, withDiscountCost;
          currentCost = $(this).data('price') * $(this).data('count');
          withDiscountCost = currentCost - (currentCost * $(this).data('discount') / 100);
          total += withDiscountCost;
          priceCell = $(this).find('.field.price_values');
          priceCell.find('.current_price').text(currentCost);
          return priceCell.find('.price_with_discount').text(withDiscountCost);
        });
        return this.totalCostCounter.text(total);
      };

      return Cart;

    })();
    cart = new Cart;
    $('#cart-details-list input:checkbox').change(function() {
      if ($(this).parents('.catalog-grid-row.archived').size() > 0) {
        if ($(this).prop('checked')) {
          return cart.updateCounters(0, 1);
        } else {
          return cart.updateCounters(0, -1);
        }
      } else {
        if ($(this).prop('checked')) {
          return cart.updateCounters(1, 0);
        } else {
          return cart.updateCounters(-1, 0);
        }
      }
    });
    return $('.spinner').spinner({
      min: 1,
      value: 1,
      icons: {
        down: "spinner-down",
        up: "spinner-up"
      },
      spin: function(event, ui) {
        $(event.target).parents('.catalog-grid-row').data('count', ui.value);
        return cart.updateCost();
      }
    });
  });

}).call(this);

/*
//@ sourceMappingURL=cart.map
*/
