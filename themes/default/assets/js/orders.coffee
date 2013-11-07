$ ->
	$('.information').tooltip
		animation: false

	buttonFinish = $('button.finish').attr('disabled', 'disabled')
	$('#Orders_confirm').click (e) ->
		if $(@).prop 'checked'
			buttonFinish.removeAttr 'disabled'
		else
			buttonFinish.attr 'disabled', 'disabled'


	orderButton = $('.order-button')
	if orderButton.size() > 0
		$parent = orderButton.parent()
		$overlay = $('<div />')
		$overlay.css
			position: "absolute"
			top: $parent.position().top
			left: $parent.position().left
			width: $parent.outerWidth()
			height: $parent.outerHeight()
			zIndex: 10000
			backgroundColor: "#fff"
			opacity: 0
		.click (e) ->
			orderButton.trigger 'click'

		$parent.append $overlay
		$shakeElement = $('#snake-element')
		orderButton.click (e) ->
			if orderButton.prop 'disabled'
				$shakeElement.addClass('shake animated')
				clearShake = ->
					$shakeElement.removeClass('shake animated')
				setTimeout clearShake, 500
				return false

			form = $(@).parents('form').attr 'action'
			$.ajax
				url: form.attr 'action'
				type: 'POST'
				data: form.serialize()
				success: (data) ->
					$.show_abaris_box data

