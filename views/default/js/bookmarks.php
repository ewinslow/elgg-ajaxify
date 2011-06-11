elgg.ajaxify.bookmarks = function(input) {
	var inputURL = $(input).val().trim();
	elgg.ajaxify.showLoading({
		DOM: $('input[name=title]'),
		width: '25px',
		height: '25px',
		manipulationMethod: 'prepend',
	});
	elgg.action('bookmarks/autofill', {
		data: {
			'address': inputURL
		},
		success: function(response) {
			elgg.ajaxify.removeLoading();
			$('input[name=title]').val(response.output.title);
		},
	});
};
