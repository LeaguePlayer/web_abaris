// Generated by CoffeeScript 1.6.3
(function() {
  $(function() {
    $.detailGridBinding = function() {
      var callback, options;
      callback = function() {
        $('#Adaptabillity_auto_model_id').select2();
        $('#adaptabilliti-form .btn').unbind('click').bind('click', function(e) {
          var form;
          form = $(this).parents('form');
          $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(data) {
              $('.fancybox-inner').html(data);
              $.fancybox.reposition();
              return callback();
            }
          });
          return false;
        });
        return $('#adapt-grid .remove').unbind('click').bind('click', function(e) {
          var auto_model_id, detail_id, tr;
          tr = $(this).parents('tr');
          detail_id = tr.data('detail_id');
          auto_model_id = tr.data('auto_model_id');
          $.ajax({
            url: '/admin/details/adaptabilliti/?detail_id=' + detail_id,
            type: 'POST',
            data: {
              Adaptabillity: {
                action: 'delete',
                auto_model_id: auto_model_id
              }
            },
            success: function(data) {
              return tr.fadeOut(500, function() {
                this.remove();
                $('.fancybox-inner').html(data);
                $.fancybox.reposition();
                return callback();
              });
            }
          });
          return false;
        });
      };
      options = {
        afterShow: function() {
          return callback();
        },
        width: 500
      };
      return $.bindModal('a.link-modal', options);
    };
    return $.detailGridBinding();
  });

}).call(this);

/*
//@ sourceMappingURL=details.map
*/
