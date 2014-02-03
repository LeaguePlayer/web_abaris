# @.init_scroller = () ->
# 	if $('.scroller').length > 0
# 		$('.scroller').baron
# 			scroller: '.scroller'
# 			container: '.scroll-container'
# 			bar: '.scroller__bar'
# 			track: '.scroller__track'
# 			barOnCls: 'baron'

$ ->
	$.bind_rows_check = ->
		$(".catalog-grid-row").hover(
			() ->
				$(@).addClass 'active' if !$(@).hasClass('no-hover')
			() -> $(this).removeClass 'active'
		)

		$('.grid-items .catalog-grid-row').on 'click', (e) ->
			target = $(e.target)
			if target.hasClass('spinner-up') or target.hasClass('spinner-down')
				return false

			if target.is('a')
				return true

			$this = $(@)
			checkbox = $this.find('input:checkbox')
			if checkbox.prop 'checked'
				checkbox.prop 'checked', false
				$this.removeClass 'select'
			else
				checkbox.prop 'checked', true
				$this.addClass 'select'
			checkbox.trigger "change"
			false

	$.show_abaris_box = (selector, options = {}) ->
		$.extend options,
			wrapCSS: 'abaris-modal'
			padding: 5
			autoSize: true
			minWidth: 550
			fitToView: true
			modal: false
			closeBtn: true
			helpers:
				overlay:
					locked: true
		$.fancybox.open $(selector), options


	$.bind_ajax_modal = (selector, options = {}) ->
		$.extend options,
			wrapCSS: 'abaris-modal'
			padding: 5
			autoSize: true,
			minWidth: 550,
			fitToView: true
			modal: false
			closeBtn: true
			type: 'ajax'
			openEffect: 'none'
			closeEffect: 'none'
			helpers:
				overlay:
					locked: true
		$(selector).unbind('click.fb').bind 'click.fb', (e) ->
			e.preventDefault()
			$this = $(@)
			openBox = ->
				$.extend options,
					href: $this.attr 'href'
				$.fancybox.open options
			if $('.fancybox-overlay').size() > 0
				$.fancybox.close()
				$.fancybox.showLoading()
				setTimeout openBox, 500
			else
				openBox()
			false

	$.pluralize = (n, labels = false) ->
		i = ( n % 10 == 1 && n % 100 != 11 ? 0 : (n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20) ? 1 : 2) )
		if labels != false
			return labels[i]
		else
			return i

	$('.information').tooltip
		animation: false



	$.registration = () ->
		bindEvents = (context) ->
			$('.cancel-signup', context).click (e) ->
				$.fancybox.close()
				false

			$('.choose_usertype:radio', context).click (e) ->
				if parseInt($(@).val()) == 0
					$('.organization', context).addClass('hidden')
				else
					$('.organization', context).removeClass('hidden')

			$('.add-auto', context).click (e) ->
				autoBlock = $('.auto-item', context)
				counter = autoBlock.size() + 1
				newBlock = autoBlock.first().clone().addClass('clone-auto')
				newBlock.find('.row-fluid').each ->
					input = $(@).find('input').val('')
					input.attr 'id', 'UserCars_' + input.data('attribute') + '-' + counter
					input.attr 'name', 'UserCars[' + counter + '][' + input.data('attribute') + ']'
					$(@).find('label').attr 'for', input.attr 'id'
				autoBlock.last().after newBlock
				false

			form = $('form', context)
			form.find('button.next-step, button.login-submit').click (e) ->
				$.ajax
					url: form.attr 'action'
					type: form.attr 'method'
					data: form.serialize()
					success: (data) ->
						context.html data
						bindEvents context
						$.fancybox.reposition()
				false

			form.find('button.repeat-sms').click (e) ->
				$.ajax
					url: form.attr 'action'
					type: form.attr 'method'
					data: 'UpdateSmsCode': 1
					success: (data) ->
						context.html data
						bindEvents context
						$.fancybox.reposition()
				false

			form.find('.prev-step').click (e) ->
				$.ajax
					url: $(@).attr 'href'
					type: 'GET'
					success: (data) ->
						context.html data
						bindEvents context
						$.fancybox.reposition()
				false

			$.mask.definitions['d'] = "[0-9]"
			form.find('#Profile_phone').mask "+7 (ddd)-ddd-dd-dd"

		$.bind_ajax_modal '.registrationButton', afterShow: () -> bindEvents $(@.inner)

	$.registration()



	$.bind_ajax_modal '.login-button',
		afterShow: () ->
			$.registration()


	$.bind_ajax_modal 'a.feedback',
		afterShow: () ->
			clickListener = (context) ->
				$('.close-box', context).click (e) ->
					$.fancybox.close()
					false
				form = context.find('form')
				form.find('button').click (e) ->
					$.ajax
						url: form.attr 'action'
						type: 'POST'
						data: form.serialize()
						success: (data) ->
							context.html data
							clickListener context
					false
			clickListener @.inner


	$.datepicker.regional['ru'] =
		closeText: 'Закрыть',
		prevText: '&#x3c;Пред',
		nextText: 'След&#x3e;',
		currentText: 'Сегодня',
		monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
					 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
		monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
						  'Июл','Авг','Сен','Окт','Ноя','Дек'],
		dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
		dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
		dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
		weekHeader: 'Не',
		dateFormat: 'dd.mm.yy',
		firstDay: 1,
		isRTL: false,
		showMonthAfterYear: false,
		yearSuffix: ''
	$.datepicker.setDefaults $.datepicker.regional['ru']


	$('#inline_logs .log_message').each ->
		alertify.log $(@).html(), '', 1000 * 60


	$('.tooltip-msg').popover
		html: true
		trigger: 'hover'
	$('.tooltip-msg').popover('show')

