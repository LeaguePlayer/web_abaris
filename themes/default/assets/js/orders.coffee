$ ->
	$('.information').tooltip
		animation: false

	if $('#Orders_confirm').size() > 0
		$orderConfirm = $('#Orders_confirm')
		$shakeElement = $('#snake-element')
		$orderButton = $('.order-button').css
			position: 'relative'
		$overlay = $('<div />').css
			position: "absolute"
			top: $orderButton.position().top
			left: $orderButton.position().left
			width: $orderButton.outerWidth()
			height: $orderButton.outerHeight()
			zIndex: 500
			backgroundColor: "#fff"
			opacity: 0
		$orderButton.parents('div').append $overlay

		$overlay.click (e) ->
			$shakeElement.addClass('shake animated')
			clearShake = ->
				$shakeElement.removeClass('shake animated')
			setTimeout clearShake, 500

		check_button = () ->
			if $orderConfirm.prop 'checked'
				$orderButton.removeAttr('disabled').css
					zIndex: 500
				$overlay.css
					display: 'none'
					zIndex: 0
			else
				$orderButton.attr('disabled', 'disabled').css
					zIndex: 0
				$overlay.css
					display: 'block'
					zIndex: 500

		$orderConfirm.click (e) ->
			check_button()

		check_button()

#	orderButton = $('.order-button')
#	if orderButton.size() > 0
#		$parent = orderButton.parent()
#		$overlay = $('<div />')
#		$overlay.css
#			position: "absolute"
#			top: orderButton.position().top
#			left: orderButton.position().left
#			width: orderButton.outerWidth()
#			height: orderButton.outerHeight()
#			zIndex: 10000
#			backgroundColor: "#fff"
#			opacity: 0
#		.click (e) ->
#			orderButton.trigger 'click'
#
#		$parent.append $overlay
#		$shakeElement = $('#snake-element')
#		orderButton.click (e) ->
#			if orderButton.prop 'disabled'
#				$shakeElement.addClass('shake animated')
#				clearShake = ->
#					$shakeElement.removeClass('shake animated')
#				setTimeout clearShake, 500
#				return false
#
#			form = $(@).parents('form').attr 'action'
#			$.ajax
#				url: form.attr 'action'
#				type: 'POST'
#				data: form.serialize()
#				success: (data) ->
#					$.show_abaris_box data

