$ ->
	$.show_abaris_box '.login-form'
	if($('.model-desc').length > 0)
		$.show_abaris_box '.model-desc', 
			onUpdate: () ->
				@.wrap.css 'position', 'fixed'

	if $('.scroller').length > 0
		$('.scroller').baron
			scroller: '.scroller'
			container: '.scroll-container'
			bar: '.scroller__bar'
			track: '.scroller__track'
			barOnCls: 'baron'

	$('.add-auto').on 'click', () ->
		modal = $(@).closest('.inline-modal')
		item = modal.find('.auto-item').eq(0).clone().addClass 'clone-auto'
		item.find('input').val('')
		modal.find('.auto-items').append item
		$.fancybox.reposition()

	###$('.catalog-grid-row').each () ->
		max_height = 0
		$(@).find('.field').each ()->
			height = $(@).height()
			max_height = height if max_height < height
		$(@).find('.field').height(max_height)###
