/**
 * Deletes an annotation
 * 
 * @param id The id of the annotation to delete
 * @return false Forces this to be the last action that occurs.
 */
elgg.delete_annotation = function(id) {
	if (!confirm(elgg.echo('delete:confirm'))) {
		return false;
	}
	
	$annotation = $('.annotation.editable[data-id='+id+']');
	
	$annotation.slideUp();
	
	elgg.action('ajax/annotation/delete', {
		data: {
			annotation_id: id
		},
		success: function(data) {
			if (data.status == elgg.ajax.SUCCESS) {
				elgg.system_message(data.system_messages.messages[0]);
			} else {
				elgg.register_error(data.system_messages.errors[0]);
			}
		},
		error: function(xhr) { // oops
			$annotation.slideDown();
			elgg.register_error(xhr.responseText);
		}
	});
	
	return false;
};