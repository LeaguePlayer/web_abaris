$ ->
	$('.information').tooltip
		animation: false

	buttonFinish = $('button.finish').attr('disabled', 'disabled')
	$('#Orders_confirm').click (e) ->
		if $(@).prop 'checked'
			buttonFinish.removeAttr 'disabled'
		else
			buttonFinish.attr 'disabled', 'disabled'

	$('.order-button').click (e) ->
		form = $(@).parents('form').attr 'action'
		$.ajax
			url: form.attr 'action'
			type: 'POST'
			data: form.serialize()
			success: (data) ->
				$.show_abaris_box data

