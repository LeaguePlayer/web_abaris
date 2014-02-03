$ ->
	event_binding = ->
		# fixed scroll header
		$('.catalog-grid-header.scroll-fixed').scrollToFixed
			limit: 0

		$.bind_rows_check()

		class Cart
			constructor: () ->
				cartGrid = $('#cart-details-list')
				@generalSelected = cartGrid.find('.catalog-grid-row input:checkbox:checked').size()
				@activeSelected = cartGrid.find('.catalog-grid-row').not('.archived').find('input:checkbox:checked').size()
				@archiveSelected = cartGrid.find('.catalog-grid-row.archived input:checkbox:checked').size()
				cartAction = $('.subtotal.icons')
				@generalCounters = cartAction.find('.item.total-select span.text .selected_count, .item.delete span.text .selected_count')
				@activeCounters = cartAction.find('.item.active span.text .selected_count')
				@arciveCounters = cartAction.find('.item.archive span.text .selected_count')
				@cartActiveRows = $('#cart-details-list .catalog-grid-row').not('.archived')
				@totalCostCounter = $('.summ .number')
				@totalCostLabel = $('.summ').next '.text'
				@userPanelTotalCost = $('#cart-info .cost')
				@userPanelTotalCount = $('#cart-info .count')
			updateCounters: (actived = 0, archived = 0) ->
				@generalSelected += (actived + archived)
				@activeSelected += actived
				@archiveSelected += archived
				@generalCounters.text @generalSelected
				@activeCounters.text @activeSelected
				@arciveCounters.text @archiveSelected
			updateRows: () ->
				@cartActiveRows = $('#cart-details-list .catalog-grid-row').not('.archived')
			updateCost: (currentRow = false) ->
				total = 0
				discount = 0
				count = 0
				@cartActiveRows.each () ->
					count++
					currentCost = $(@).data('price') * $(@).data('count')
					withDiscountCost = currentCost - ( currentCost * $(@).data('discount') / 100 )
					total += withDiscountCost
					priceCell = $(@).find('.field.price_values')
					priceCell.find('.current_price').text accounting.formatMoney(currentCost, "", 0, " ")
					priceCell.find('.price_with_discount').text accounting.formatMoney(withDiscountCost, "", 0, " ")
				@totalCostCounter.text accounting.formatMoney(total, "", 0, " ")
				@userPanelTotalCost.text accounting.formatMoney(total, "", 0, " ")
				@userPanelTotalCount.text count


		cart = new Cart

		$('#cart-details-list input:checkbox').change () ->
			if $(@).parents('.catalog-grid-row.archived').size() > 0
				if $(@).prop 'checked'
					cart.updateCounters 0, 1
				else
					cart.updateCounters 0, -1
			else
				if $(@).prop 'checked'
					cart.updateCounters 1, 0
				else
					cart.updateCounters -1, 0


		$('.spinner').spinner
			min: 1,
			max: $(this).data('max'),
			value: 1
			icons:
				down: "spinner-down"
				up: "spinner-up"
			spin: (event, ui) ->
				$this = $(this)
				#$this.spinner 'disable'
				$.ajax
					url: '/user/cart/update'
					type: 'GET'
					dataType: 'json'
					data:
						key: $this.data('id')
						count: ui.value
					success: (data) ->
						if (!data.error)
							$this.parents('.catalog-grid-row').data 'count', ui.value
							cart.updateCost()



		$('.subtotal .delete').click (e) ->
			form = $(@).parents('form')
			if ( form.find('.blue-check input:checked').size() == 0 )
				alertify.alert "Ничего не выбрано"
			else
				alertify.confirm "Подтвердите удаление выбранных элементов", (e, str) ->
					if e
						form.append $('<input type="hidden" />').attr('name', 'CartItems[action]').attr('value', 'delete')
						$.ajax
							url: form.attr 'action'
							type: 'POST'
							data: form.serialize()
							success: (data) ->
								$('#cart-wrap').replaceWith data
								cart.updateRows()
								cart.updateCost()
								event_binding()
			false


		$('input#Cart_self_transport').change (e) ->
			$this = $(@)
			$.ajax
				url: '/user/cart/setSelfTransport',
				type: 'POST',
				data: Cart: self_transport: +$this.prop 'checked'
				dataType: 'json'
				success: (data) ->
					if !data.success
						$this.prop 'checked', false
						return
					total = data.cart_cost + data.delivery_price
					cart.totalCostCounter.text accounting.formatMoney(total, "", 0, " ")
					cart.userPanelTotalCost.text accounting.formatMoney(total, "", 0, " ")

					if +data.self_transport
						cart.totalCostLabel.text "Итого"
					else
						cart.totalCostLabel.text "Итого (доставка + #{accounting.formatMoney(data.delivery_price, "", 0, " ")} р.)"

	event_binding()