$ ->
	$('.cancel-signup').on 'click', () -> $.fancybox.close()

	$('.add-auto').on 'click', () ->
		modal = $(@).closest('.inline-modal')
		item = modal.find('.auto-item').eq(0).clone().addClass 'clone-auto'
		item.find('input').val('')
		modal.find('.auto-items').append item
		# $.fancybox.reposition()

	open_step1 = () ->
		$.show_abaris_box '.signup-step1',
			afterShow: () ->
				step1 = $('.signup-step1')

				step1.find(':radio').on 'change', () ->
					if $(this).attr('id') == 'ur' 
						step1.find('.organization').show()
					else
						step1.find('.organization').hide()
					$.fancybox.update()

				step1.find('.next-step').on 'click', () -> 
					open_step2()

	open_step2 = () ->
		$.show_abaris_box '.signup-step2',
			afterShow: () -> 
				# open step 3
				$('.signup-step2').find('.next-step').on 'click', () -> open_step3()
				# go back
				$('.signup-step2').find('.prev-step').on 'click', () -> open_step1()
	open_step3 = () ->
		$.show_abaris_box '.signup-step3',
			autoCenter: false
			afterShow: () -> 
				# something do
				$('.signup-step3').find('.login-submit').on 'click', () -> $.fancybox.close()
	open_step1()