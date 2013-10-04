# @.init_scroller = () ->
# 	if $('.scroller').length > 0
# 		$('.scroller').baron
# 			scroller: '.scroller'
# 			container: '.scroll-container'
# 			bar: '.scroller__bar'
# 			track: '.scroller__track'
# 			barOnCls: 'baron'

$ ->
	$('.grid-items .catalog-grid-row').on 'click', (e) ->
		if $(e.target).hasClass('spinner-up') or $(e.target).hasClass('spinner-down')
			return false

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
		$.fancybox.open $(selector), options

	$(".catalog-grid-row").hover(
		() -> 
			$(@).addClass 'active' if !$(@).hasClass('no-hover')
		() -> $(this).removeClass 'active'
	)

	$.cart_push = (product_id, options = {}) ->
		$.ajax
			url: '/user/cart/put'
			type: 'GET'
			dataType: 'json'
			data:
				id: product_id
			success: (data) ->
				if (!data.error)
					$.show_abaris_box data.html, options
				else
					$.show_abaris_box data.error, options

	$.pluralize = (n, labels = false) ->
		i = ( n % 10 == 1 && n % 100 != 11 ? 0 : (n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20) ? 1 : 2) )
		if labels != false
			return labels[i]
		else
			return i

	$('.information').tooltip
		animation: false