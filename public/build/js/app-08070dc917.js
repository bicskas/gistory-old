jQuery(document).ready(function ($) {

	$('.alert>.close').on('click',function () {
		$(this).parent.remove();
	});

	$(document).on('click', '.confirm', function() {
		return confirm('Biztos benne?');
	});

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	// törlés gomb
	$(document).on('click', '.torol', function(e) {
		e.preventDefault();
		if (confirm('Biztos benne?')) {
			var $this = $(this);
			$.ajax({
				url: $this.attr('href'),
				method: 'DELETE',
				success: function(resp) {
					$('#item_' + resp.id).remove();
				},
				error: function() {
					alert('Hiba történt');
				}
			});
		}
	});

});
//# sourceMappingURL=app.js.map
