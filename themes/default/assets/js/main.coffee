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
			autoSize: true,
			minWidth: 550,
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


	$(".catalog-grid-row").hover(
		() -> 
			$(@).addClass 'active' if !$(@).hasClass('no-hover')
		() -> $(this).removeClass 'active'
	)

	$.pluralize = (n, labels = false) ->
		i = ( n % 10 == 1 && n % 100 != 11 ? 0 : (n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20) ? 1 : 2) )
		if labels != false
			return labels[i]
		else
			return i

	$('.information').tooltip
		animation: false

	$.bind_ajax_modal '.login-button',
		afterShow: () ->
			$.registration()

