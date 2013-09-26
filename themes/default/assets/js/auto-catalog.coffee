$ ->
	searchByFirstLetter = ->
		$('#BrandFirstLettet').change () ->
			vinText = $('#VIN:text').val()
			$.ajax
				url: window.location.href
				type: 'GET'
				data:
					chooseLetter: $(this).val()
				success: (data) ->
					$('.auto-catalog').first().replaceWith data
					$('#VIN:text').val vinText
					searchByFirstLetter()
			false

	searchByFirstLetter()