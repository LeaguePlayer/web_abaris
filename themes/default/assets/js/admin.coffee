$ ->
	$('.tooltip-msg').popover
		html: true
		trigger: 'hover'
	$('.tooltip-msg').popover('show')

	hide_popover = () -> $('.tooltip-msg').popover('destroy')
	setTimeout hide_popover, 5000

	form = $('.abaris-form')
	form.find(':radio').on 'change', () ->
		if $(this).attr('id') == 'ur' 
			form.find('.organization').show()
		else
			form.find('.organization').hide()