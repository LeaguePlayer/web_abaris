# @.init_scroller = () ->
# 	if $('.scroller').length > 0
# 		$('.scroller').baron
# 			scroller: '.scroller'
# 			container: '.scroll-container'
# 			bar: '.scroller__bar'
# 			track: '.scroller__track'
# 			barOnCls: 'baron'

$ ->
	$('.grid-items .catalog-grid-row').on 'click', () ->
		if $(@).find('.check').length > 0
			$(@).find('.check').removeClass('check').addClass('un-check')
			return
		if $(@).find('.un-check').length > 0
			$(@).find('.un-check').removeClass('un-check').addClass('check')
			return

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
	# @.show_box = (selector, options = {}) ->