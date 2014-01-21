$ ->
#	$.registration = () ->
#		bindEvents = (context) ->
#			$('.cancel-signup', context).click (e) ->
#				$.fancybox.close()
#				false
#
#			$('.choose_usertype:radio', context).click (e) ->
#				if parseInt($(@).val()) == 0
#					$('.organization', context).addClass('hidden')
#				else
#					$('.organization', context).removeClass('hidden')
#
#			$('.add-auto', context).click (e) ->
#				autoBlock = $('.auto-item', context)
#				counter = autoBlock.size() + 1
#				newBlock = autoBlock.first().clone().addClass('clone-auto')
#				newBlock.find('.row-fluid').each ->
#					input = $(@).find('input').val('')
#					input.attr 'id', 'UserCars_' + input.data('attribute') + '-' + counter
#					input.attr 'name', 'UserCars[' + counter + '][' + input.data('attribute') + ']'
#					$(@).find('label').attr 'for', input.attr 'id'
#				autoBlock.last().after newBlock
#				false
#
#			form = $('form', context)
#			form.find('button.next-step, button.login-submit').click (e) ->
#				$.ajax
#					url: form.attr 'action'
#					type: form.attr 'method'
#					data: form.serialize()
#					success: (data) ->
#						context.html data
#						bindEvents context
#						$.fancybox.reposition()
#				false
#
#			form.find('button.repeat-sms').click (e) ->
#				$.ajax
#					url: form.attr 'action'
#					type: form.attr 'method'
#					data: 'UpdateSmsCode': 1
#					success: (data) ->
#						context.html data
#						bindEvents context
#						$.fancybox.reposition()
#				false
#
#			form.find('.prev-step').click (e) ->
#				$.ajax
#					url: $(@).attr 'href'
#					type: 'GET'
#					success: (data) ->
#						context.html data
#						bindEvents context
#						$.fancybox.reposition()
#				false
#
#			$.mask.definitions['d'] = "[0-9]"
#			form.find('#Profile_phone').mask "dddddddddd"
#
#		$.bind_ajax_modal '.registrationButton', afterShow: () -> bindEvents $(@.inner)
#
#	$.registration()