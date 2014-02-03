// Generated by CoffeeScript 1.6.3
(function() {
  $(function() {
    $.bind_rows_check = function() {
      $(".catalog-grid-row").hover(function() {
        if (!$(this).hasClass('no-hover')) {
          return $(this).addClass('active');
        }
      }, function() {
        return $(this).removeClass('active');
      });
      return $('.grid-items .catalog-grid-row').on('click', function(e) {
        var $this, checkbox, target;
        target = $(e.target);
        if (target.hasClass('spinner-up') || target.hasClass('spinner-down')) {
          return false;
        }
        if (target.is('a')) {
          return true;
        }
        $this = $(this);
        checkbox = $this.find('input:checkbox');
        if (checkbox.prop('checked')) {
          checkbox.prop('checked', false);
          $this.removeClass('select');
        } else {
          checkbox.prop('checked', true);
          $this.addClass('select');
        }
        checkbox.trigger("change");
        return false;
      });
    };
    $.show_abaris_box = function(selector, options) {
      if (options == null) {
        options = {};
      }
      $.extend(options, {
        wrapCSS: 'abaris-modal',
        padding: 5,
        autoSize: true,
        minWidth: 550,
        fitToView: true,
        modal: false,
        closeBtn: true,
        helpers: {
          overlay: {
            locked: true
          }
        }
      });
      return $.fancybox.open($(selector), options);
    };
    $.bind_ajax_modal = function(selector, options) {
      if (options == null) {
        options = {};
      }
      $.extend(options, {
        wrapCSS: 'abaris-modal',
        padding: 5,
        autoSize: true,
        minWidth: 550,
        fitToView: true,
        modal: false,
        closeBtn: true,
        type: 'ajax',
        openEffect: 'none',
        closeEffect: 'none',
        helpers: {
          overlay: {
            locked: true
          }
        }
      });
      return $(selector).unbind('click.fb').bind('click.fb', function(e) {
        var $this, openBox;
        e.preventDefault();
        $this = $(this);
        openBox = function() {
          $.extend(options, {
            href: $this.attr('href')
          });
          return $.fancybox.open(options);
        };
        if ($('.fancybox-overlay').size() > 0) {
          $.fancybox.close();
          $.fancybox.showLoading();
          setTimeout(openBox, 500);
        } else {
          openBox();
        }
        return false;
      });
    };
    $.pluralize = function(n, labels) {
      var i, _ref, _ref1;
      if (labels == null) {
        labels = false;
      }
      i = (_ref = n % 10 === 1 && n % 100 !== 11) != null ? _ref : {
        0: (_ref1 = n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20)) != null ? _ref1 : {
          1: 2
        }
      };
      if (labels !== false) {
        return labels[i];
      } else {
        return i;
      }
    };
    $('.information').tooltip({
      animation: false
    });
    $.registration = function() {
      var bindEvents;
      bindEvents = function(context) {
        var form;
        $('.cancel-signup', context).click(function(e) {
          $.fancybox.close();
          return false;
        });
        $('.choose_usertype:radio', context).click(function(e) {
          if (parseInt($(this).val()) === 0) {
            return $('.organization', context).addClass('hidden');
          } else {
            return $('.organization', context).removeClass('hidden');
          }
        });
        $('.add-auto', context).click(function(e) {
          var autoBlock, counter, newBlock;
          autoBlock = $('.auto-item', context);
          counter = autoBlock.size() + 1;
          newBlock = autoBlock.first().clone().addClass('clone-auto');
          newBlock.find('.row-fluid').each(function() {
            var input;
            input = $(this).find('input').val('');
            input.attr('id', 'UserCars_' + input.data('attribute') + '-' + counter);
            input.attr('name', 'UserCars[' + counter + '][' + input.data('attribute') + ']');
            return $(this).find('label').attr('for', input.attr('id'));
          });
          autoBlock.last().after(newBlock);
          return false;
        });
        form = $('form', context);
        form.find('button.next-step, button.login-submit').click(function(e) {
          $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function(data) {
              context.html(data);
              bindEvents(context);
              return $.fancybox.reposition();
            }
          });
          return false;
        });
        form.find('button.repeat-sms').click(function(e) {
          $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: {
              'UpdateSmsCode': 1
            },
            success: function(data) {
              context.html(data);
              bindEvents(context);
              return $.fancybox.reposition();
            }
          });
          return false;
        });
        form.find('.prev-step').click(function(e) {
          $.ajax({
            url: $(this).attr('href'),
            type: 'GET',
            success: function(data) {
              context.html(data);
              bindEvents(context);
              return $.fancybox.reposition();
            }
          });
          return false;
        });
        $.mask.definitions['d'] = "[0-9]";
        return form.find('#Profile_phone').mask("+7 (ddd)-ddd-dd-dd");
      };
      return $.bind_ajax_modal('.registrationButton', {
        afterShow: function() {
          return bindEvents($(this.inner));
        }
      });
    };
    $.registration();
    $.bind_ajax_modal('.login-button', {
      afterShow: function() {
        return $.registration();
      }
    });
    $.bind_ajax_modal('a.feedback', {
      afterShow: function() {
        var clickListener;
        clickListener = function(context) {
          var form;
          $('.close-box', context).click(function(e) {
            $.fancybox.close();
            return false;
          });
          form = context.find('form');
          return form.find('button').click(function(e) {
            $.ajax({
              url: form.attr('action'),
              type: 'POST',
              data: form.serialize(),
              success: function(data) {
                context.html(data);
                return clickListener(context);
              }
            });
            return false;
          });
        };
        return clickListener(this.inner);
      }
    });
    $.datepicker.regional['ru'] = {
      closeText: 'Закрыть',
      prevText: '&#x3c;Пред',
      nextText: 'След&#x3e;',
      currentText: 'Сегодня',
      monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
      monthNamesShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
      dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
      dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
      dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
      weekHeader: 'Не',
      dateFormat: 'dd.mm.yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['ru']);
    $('#inline_logs .log_message').each(function() {
      return alertify.log($(this).html(), '', 1000 * 60);
    });
    $('.tooltip-msg').popover({
      html: true,
      trigger: 'hover'
    });
    return $('.tooltip-msg').popover('show');
  });

}).call(this);

/*
//@ sourceMappingURL=main.map
*/
