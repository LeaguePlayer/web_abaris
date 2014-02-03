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

	filterListView = (listId) ->
		form = $("##{listId}").parent().find('.catalog-grid-header form')
		if form.size() == 0
			return false

		form.submit ->
			$.fn.yiiListView.update "#{listId}",
				data: $(this).serialize()
			$.scrollTo('#top-grid')
			false
		form.find('input:text').keyup (e) ->
			form.submit()
			false
		#.change (e) ->
		#	form.submit()
		#	false

	catalog_events = ->
		if $('.catalog-grid-row').size() > 0
			$('.catalog-grid-header.scroll-fixed').scrollToFixed
				limit: 0

		$('.list-view').each ->
			filterListView($(this).attr 'id')

		$.bind_ajax_modal '#details-list .to_cart',
			afterShow: ->
				$('#cart-info').find('.cost').text(@.inner.find('#cost').val()).end().find('.count').text(@.inner.find('#quantity').val())
				$('.close-button', @.inner).click (e) ->
					$.fancybox.close()
					false

		$.bind_ajax_modal '.view_brand'

	catalog_events()

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
					catalog_events()
					changeCategory()
					filterListView('details-list')
			false


	$.bind_ajax_modal 'a.send_question',
		afterShow: () ->
			content = $(@.inner)
			$(content).on 'click', 'a.close-box', (e) ->
				$.fancybox.close()
				false

			$(content).on 'click', 'button.next-step', (e) ->
				form = $('form', content)
				$.ajax
					url: form.attr 'action'
					type: 'POST'
					data: form.serialize()
					success: (data) ->
						content.html data
				false


	changeCategory()
