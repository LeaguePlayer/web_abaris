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
    $.bind_ajax_modal('.login-button', {
      afterShow: function() {
        return $.registration();
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
    return $('.fancy_run').fancybox();
  });

}).call(this);

/*
//@ sourceMappingURL=main.map
*/
