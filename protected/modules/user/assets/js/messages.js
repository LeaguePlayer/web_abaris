// Generated by CoffeeScript 1.6.3
(function() {
  $(function() {
    var bindEvents;
    bindEvents = function() {
      var deleteCounter, grid;
      $.bind_rows_check();
      grid = $('.catalog-grid').first();
      deleteCounter = $('.subtotal .delete .selected_count');
      $('.blue-check input:checkbox').change(function() {
        return deleteCounter.text(grid.find('.blue-check input:checkbox:checked').size());
      });
      return $('.subtotal .delete').click(function(e) {
        var form;
        form = $(this).parents('form');
        if (form.find('.blue-check input:checked').size() === 0) {
          alertify.alert("Вы не выбрали ни одной записи");
        } else {
          alertify.confirm("Подтвердите удаление выбранных элементов", function(e, str) {
            if (e) {
              form.append($('<input type="hidden" />').attr('name', 'Messages[action]').attr('value', 'delete'));
              return $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function(data) {
                  $('#content-wrap').replaceWith(data);
                  return bindEvents();
                }
              });
            }
          });
        }
        return false;
      });
    };
    return bindEvents();
  });

}).call(this);

/*
//@ sourceMappingURL=messages.map
*/
