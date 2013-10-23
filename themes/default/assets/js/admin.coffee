$ ->
	alertify.set labels:
		ok     : "Ок"
		cancel : "Отмена"
	alertify.set buttonReverse: true
	alertify.set buttonFocus: "cancel"

	hide_popover = () -> $('.tooltip-msg').popover('destroy')
	setTimeout hide_popover, 5000
	

	bindCabinetEvents = ->
		if $('.print-page').size() > 0
			$('.print-page').printPage()



		$.bind_rows_check()



		form = $('.abaris-form')
		$('.choose_usertype:radio', form).click (e) ->
			if parseInt($(@).val()) == 0
				$('.organization', form).addClass('hidden')
			else
				$('.organization', form).removeClass('hidden')


		$.mask.definitions['d'] = "[0-9]"
		form.find('#Profile_phone').mask "dddddddddd"


		$.bind_ajax_modal '.view-invoice, .view-order'




		grid = $('.catalog-grid').first()
		deleteCounter = $('.subtotal .delete .selected_count')
		$('.blue-check input:checkbox').change () ->
			deleteCounter.text grid.find('.blue-check input:checkbox:checked').size()




		$.bind_ajax_modal '.pencil, .subtotal .add',
			afterShow: () ->
				bindEvents = (context) ->
					form = $('form', context)
					form.find('#UserCarsSTO_maintenance_date').datepicker()
					form.find('input:submit').click (e) ->
						$.ajax
							url: form.attr 'action'
							type: 'POST'
							data: form.serialize()
							success: (data) ->
								if $(data).find('#ajaxform').size() > 0
									context.html data
									bindEvents context
									$.fancybox.reposition()
								else
									$('#usercabinet-wrap').replaceWith data
									bindCabinetEvents()
									$.fancybox.close()
						false
				bindEvents $(@.inner)




		$('.subtotal .delete').click (e) ->
			form = $(@).parents('form')
			if ( form.find('.blue-check input:checked').size() == 0 )
				alertify.alert "Вы не выбрали ни одной записи"
			else
				alertify.confirm "Подтвердите удаление выбранных элементов", (e, str) ->
					if e
						form.append $('<input type="hidden" />').attr('name', 'action').attr('value', 'delete')
						$.ajax
							url: form.attr 'action'
							type: 'POST'
							data: form.serialize()
							success: (data) ->
								$('#usercabinet-wrap').replaceWith data
								bindCabinetEvents()
			false



	bindCabinetEvents()