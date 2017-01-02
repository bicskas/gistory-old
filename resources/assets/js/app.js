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


		var $node1_mezo = $('#nev1');
		if ($node1_mezo.length) {
			var node1 = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nev'),
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				remote: {
					url: '/kereses/keres/' + $node1_mezo.data('projectid') + '/%nev',
					wildcard: '%nev'
				},
				limit: 20
			});

			node1.initialize();

			$node1_mezo.typeahead(null, {
				name: 'node-nev',
				displayKey: 'nev',
				source: node1.ttAdapter(),
				hint: true,
				highlight: true,
				minLength: 2,
				limit: 10
			});
		}

		var $node2_mezo = $('#nev2');
		if ($node2_mezo.length) {
			var node2 = new Bloodhound({
				datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nev'),
				queryTokenizer: Bloodhound.tokenizers.whitespace,
				remote: {
					url: '/kereses/keres/' + $node2_mezo.data('projectid') + '/%nev',
					wildcard: '%nev'
				},
				limit: 20
			});

			node2.initialize();

			$node2_mezo.typeahead(null, {
				name: 'node-nev',
				displayKey: 'nev',
				source: node2.ttAdapter(),
				hint: true,
				highlight: true,
				minLength: 2,
				limit: 10
			});
		}

		//---------------------------Küszöbölés ajaxxal-----------------
		$("#fokszam-slider").slider({
			id : 'fokszam-slider-szin'
		});

		$("#fokszam-slider").on('slideStop',function () {
			console.log($("#fokszam-slider").val());


			$this = $('#kuszob-node');
			$.ajax({
				url: $this.attr('action'),
				method: 'POST',
				data: $this.serialize(),
				dataType: 'html',
				success: function (resp) {
					$('abrak-tab').html(resp);
				},
				error: function () {
					alert('Hiba történt');
				}
			});
		});


		//----------------------------ábrák megjelenítése---------------

		($('#svg').length > 0)
		{
			chord('#svg');
		}

		if ($('#svg_same').length > 0) {
			chord('#svg_same');
		}

		if ($('#svg_diff').length > 0) {
			chord('#svg_diff');
		}

		if ($('#force').length > 0) {
			force('#force');
		}

		if ($('#force_same').length > 0) {
			force('#force_same');
		}

		if ($('#force_diff').length > 0) {
			force('#force_diff');
		}

		if ($('#bar').length > 0) {
			bar();
		}

		$('.bs-select').selectpicker({
			noneSelectedText: '(válasszon)',
			liveSearch: true,
			liveSearchPlaceholder: '(keresés)'
		});

	}
);