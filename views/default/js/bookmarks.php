elgg.ajaxify.bookmarks = function(input) {
	var inputURL = $(input).val().trim();
	$('input[name=title]').prepend(elgg.ajaxify.ajaxLoader);
	elgg.action('bookmarks/autofill', {
		data: {
			'address': inputURL
		},
		success: function(response) {
			$(elgg.ajaxify.ajaxLoader).remove();
			$('input[name=title]').val(response.output.title);
		},
	});
};
