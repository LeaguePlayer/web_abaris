$ ->
	$('.spinner').spinner
		min: 1
		value: 1
		icons:
			down: "spinner-down"
			up: "spinner-up"
	# fixed scroll header
	$('.catalog-grid-header').scrollToFixed
		limit: 0
		# limit: $('.subtotal').offset().top - $('.subtotal').height()

	$('.pay-icon').on 'click', (e) ->
		x = e.clientX
		y = e.clientY
		$.show_abaris_box '.sto-modal', 
			# margin: 200
			beforeShow: () -> 
				$('.blue-button').on 'click', () ->
					$.fancybox.close()

	counters = $('.selected_count')
	selectedCount = $('#cart-details-list input:checkbox:checked').size()
	$('#cart-details-list input:checkbox').change () ->
		if $(@).prop 'checked'
			selectedCount += 1
		else
			selectedCount -= 1
		counters.text selectedCount


	class Cart
	instance = new A