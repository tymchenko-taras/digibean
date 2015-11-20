$(function() {
	$('body').on('submit', 'form.ajax_form', function(event){
		var form = $(this);
		var url = form.attr('action') ? form.attr('action') : undefined;
		var data = form.serialize() + '&ajax=on';

		$.ajax({
			'url': url,
			'type': form.attr('method') || 'post',
			'data': data,
			'success': function(response){
				if(response){
					form.parent().replaceWith(response);
				}
			},
			'error': function(){
			}
		});
		event.cancel();
		return false;
	});
});