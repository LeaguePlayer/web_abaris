// Generated by CoffeeScript 1.6.3
(function() {
  $(function() {
    var event_binding;
    event_binding = function() {
      var Cart, cart;
      $('.catalog-grid-header.scroll-fixed').scrollToFixed({
        limit: 0
      });
      $.bind_rows_check();
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
          this.userPanelTotalCost = $('#cart-info .cost');
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
            priceCell.find('.current_price').text(accounting.formatMoney(currentCost, "", 0, " "));
            return priceCell.find('.price_with_discount').text(accounting.formatMoney(withDiscountCost, "", 0, " "));
          });
          this.totalCostCounter.text(accounting.formatMoney(total, "", 0, " "));
          return this.userPanelTotalCost.text(accounting.formatMoney(total, "", 0, " "));
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
      $('.spinner').spinner({
        min: 1,
        max: $(this).data('max'),
        value: 1,
        icons: {
          down: "spinner-down",
          up: "spinner-up"
        },
        spin: function(event, ui) {
          var $this;
          $this = $(this);
          return $.ajax({
            url: '/user/cart/update',
            type: 'GET',
            dataType: 'json',
            data: {
              key: $this.data('id'),
              count: ui.value
            },
            success: function(data) {
              if (!data.error) {
                $this.parents('.catalog-grid-row').data('count', ui.value);
                return cart.updateCost();
              }
            }
          });
        }
      });
      return $('.subtotal .delete').click(function(e) {
        var form;
        form = $(this).parents('form');
        if (form.find('.blue-check input:checked').size() === 0) {
          alertify.alert("Ничего не выбрано");
        } else {
          alertify.confirm("Подтвердите удаление выбранных элементов", function(e, str) {
            if (e) {
              form.append($('<input type="hidden" />').attr('name', 'CartItems[action]').attr('value', 'delete'));
              return $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                  $('#cart-wrap').replaceWith(data);
                  cart.updateCost();
                  return event_binding();
                }
              });
            }
          });
        }
        return false;
      });
    };
    return event_binding();
  });

}).call(this);

/*
//@ sourceMappingURL=cart.map
*/
