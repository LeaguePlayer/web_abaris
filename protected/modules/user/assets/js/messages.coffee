
$ ->

	bindEvents = ->
		$.bind_rows_check()

		grid = $('.catalog-grid').first()
		deleteCounter = $('.subtotal .delete .selected_count')
		$('.blue-check input:checkbox').change () ->
			deleteCounter.text grid.find('.blue-check input:checkbox:checked').size()


		$('.subtotal .delete').click (e) ->
			form = $(@).parents('form')
			if ( form.find('.blue-check input:checked').size() == 0 )
				alertify.alert "Вы не выбрали ни одной записи"
			else
				alertify.confirm "Подтвердите удаление выбранных элементов", (e, str) ->
					if e
						form.append $('<input type="hidden" />').attr('name', 'Messages[action]').attr('value', 'delete')
						$.ajax
							url: form.attr 'action'
							type: 'POST'
							data: form.serialize()
							success: (data) ->
								$('#content-wrap').replaceWith data
								bindEvents()
			false

	bindEvents()