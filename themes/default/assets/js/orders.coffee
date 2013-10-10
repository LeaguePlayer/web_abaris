$ ->
	$('.information').tooltip
		animation: false


	console.log $('.order-button')
	$('.order-button').click (e) ->
		form = $(@).parents('form').attr 'action'
		$.ajax
			url: form.attr 'action'
			type: 'POST',
			data: form.serialize()
			success: (data) ->
				$.show_abaris_box data
		false

