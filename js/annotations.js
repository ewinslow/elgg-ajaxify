/**
 * Deletes an annotation
 * 
 * @param id The annotation's id
 * @return {XMLHttpRequest}
 */
elgg.delete_annotation = function(id) {
	if (id < 1 || !confirm(elgg.echo('delete:confirm'))) {
		return false;
	}
	
	$('.annotation[data-id='+id+']').slideUp();
	
	return elgg.action('ajax/annotation/delete', {annotation_id: id});
};