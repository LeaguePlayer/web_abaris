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

	changeCategory = ->
		$('select.select_category').change (e) ->
			$.ajax
				url: window.location.href
				type: 'GET'
				data:
					cat: $(this).val()
					prevRootCat: $(this).data 'prev'
				success: (data) ->
					$('.catalog-container').first().replaceWith data
					changeCategory()
					filterListView('details-list')
			false

	changeCategory()

	filterListView = (listId) ->
		form = $("##{listId}").prev('.catalog-grid-header').find('form')
		form.submit ->
			$.fn.yiiListView.update("#{listId}", data: $(this).serialize())
			false
		form.find('input:text').keyup (e) ->
			###if e.keyCode == 13###
			form.submit()
			false

	$('.list-view').each ->
		filterListView($(this).attr 'id')


	$.bind_ajax_modal '#details-list .to_cart',
		afterShow: ->
			$('#cart-info').find('.cost').text(@.inner.find('#cost').val()).end().find('.count').text(@.inner.find('#quantity').val())
			$('.close-button', @.inner).click (e) ->
				$.fancybox.close()
				false


	###$('.catalog-grid-row').each () ->
		max_height = 0
		$(@).find('.field').each ()->
			height = $(@).height()
			max_height = height if max_height < height
		$(@).find('.field').height(max_height)###
