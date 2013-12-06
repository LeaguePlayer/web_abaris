$ ->
	$.detailGridBinding = ->
		callback = () ->
			$('#Adaptabillity_auto_model_id').select2()
			$('#adaptabilliti-form .btn').unbind('click').bind 'click', (e) ->
				form = $(@).parents('form')
				$.ajax
					url: form.attr 'action'
					type: 'POST'
					data: form.serialize()
					success: (data) ->
						$('.fancybox-inner').html(data)
						$.fancybox.reposition()
						callback()
				false
			$('#adapt-grid .remove').unbind('click').bind 'click', (e) ->
				tr = $(@).parents('tr')
				detail_id = tr.data('detail_id')
				auto_model_id = tr.data('auto_model_id')
				$.ajax
					url: '/admin/details/adaptabilliti/?detail_id='+detail_id
					type: 'POST'
					data:
						Adaptabillity:
							action: 'delete'
							auto_model_id: auto_model_id
					success: (data) ->
						tr.fadeOut 500, ->
							@.remove()
							$('.fancybox-inner').html(data)
							$.fancybox.reposition()
							callback()
				false

		options =
			afterShow: () -> callback()
			width: 500
		$.bindModal 'a.link-modal', options

	$.detailGridBinding()