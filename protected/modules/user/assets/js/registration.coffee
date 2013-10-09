$ ->
	$('.choose_usertype:radio').click (e) ->
		if parseInt($(@).val()) == 0
			$('.organization').addClass('hidden')
		else
			$('.organization').removeClass('hidden')