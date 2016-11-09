jQuery(document).ready(function ($) {

	$('.alert>.close').on('click', function () {
		$(this).parent.remove();
	});

	$(document).on('click', '.confirm', function () {
		return confirm('Biztos benne?');
	});

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	// törlés gomb
	$(document).on('click', '.torol', function (e) {
		e.preventDefault();
		if (confirm('Biztos benne?')) {
			var $this = $(this);
			$.ajax({
				url: $this.attr('href'),
				method: 'DELETE',
				success: function (resp) {
					$('#item_' + resp.id).remove();
				},
				error: function () {
					alert('Hiba történt');
				}
			});
		}
	});


	/*

	 var $kereses_mezo = $('#nev1');
	 if ($kereses_mezo.length) {
	 var kepviselok = new Bloodhound({
	 datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nev'),
	 queryTokenizer: Bloodhound.tokenizers.whitespace,
	 remote: {
	 url: '/kereses/'+ $kereses_mezo.data('projectid')+'/%nev',
	 wildcard: '%nev'
	 },
	 limit: 20
	 });

	 kepviselok.initialize();

	 $('#typeahead .typeahead').typeahead(null, {
	 name: 'kepviselo-nev',
	 displayKey: 'nev',
	 source: kepviselok.ttAdapter(),
	 hint: true,
	 highlight: true,
	 minLength: 2,
	 limit: 10
	 });
	 }
	 */

	//----------------------------ábrák megjelenítése---------------

	if($('#svg').length > 0){
		circular();
	}

	if($('#force').length > 0){
		force();
	}

	if($('#bar').length > 0){
		bar();
	}

	$('.bs-select').selectpicker({
		noneSelectedText: '(válasszon)',
		liveSearch: true,
		liveSearchPlaceholder: '(keresés)'
	});

});