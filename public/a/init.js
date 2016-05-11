function ck_editorok () {
	$(".ckeditor:not(.attached)").each(function(){
		if(!$(this).attr("id").length){
			return false;
		}

		CKEDITOR.on( 'instanceCreated', function( event ) {
			var editor = event.editor,
				element = editor.element;
			if (element.data( 'basictoolbar' ) === 'true' ) {
				editor.on( 'configLoaded', function() {
					editor.config.removePlugins = 'colorbutton,find,flash,font,forms,iframe,image,newpage,removeformat,smiley,specialchar,stylescombo,templates';
					editor.config.toolbarGroups = [
						{ name: 'editing',		groups: [ 'basicstyles', 'links' ] },
						{ name: 'undo' },
						{ name: 'clipboard',	groups: [ 'selection', 'clipboard' ] },
						{ name: 'about' }
					];
					editor.config.allowedContent = true;
				});
			} else if(element.data('ck-csakszinek')) {
				editor.on( 'configLoaded', function() {
					editor.config.toolbar = [
						['TextColor'],
						['Bold','Italic','Underline','Strike'],
						['Styles','Font','FontSize'],
						['RemoveFormat']
					];

					if(element.data("height")) {
						editor.config.height = element.data("height");
					}
				});
			}
		});
		CKEDITOR.replace($(this).attr("id"), {
			customConfig: '/a/ckeditor_config.js'
		});
		$(this).addClass('attached');
	});
}

$(document).on('click', '.confirm', function() {
	return confirm('Biztos benne?');
});

$(document).ajaxStart(function () {
	$('.ajax_loader').show();
});

$(document).ajaxStop(function () {
	$('.ajax_loader').hide();
});

$(document).ready(function(){

//	$('[data-toggle="tooltip"]').tooltip({
//		container: 'body'
//	});

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

	function rendezheto() {
		$('.rendezheto').sortable({
			update: function (event, ui) {
				var $this = $(this);
				$.post($this.data('action'), {
					data: $this.sortable('serialize')
				});
			}
		});
	}
	rendezheto();

	$('.dropdown .active').parents('.dropdown').addClass('active');
	$('.dropdown').each(function() {
		if ($(this).find('li').length == 0) {
			$(this).remove();
		}
	});

	$('.not-required [required]').each(function() {
		$(this).removeAttr('required');
	});

	// kötelető mezőkhöz piros csillag
	$('[required]').each(function() {
		$(this).parents('.form-group').find('label').first().append('&nbsp;<span class="text-danger" title="Kötelező mező">*</span>');
	});

	// hibás mezők jelölése + tab fül
	$(':input').on('invalid', function() {
		window.scrollTo(0, 0);

		var $this = $(this),
			id = $this.parents('.tab-pane').attr('id');

		$('a[href="#' + id + '"]').addClass('bg-danger text-danger');
		$this
			.after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>' +
				'<span class="sr-only">(kötelező mező)</span>')
			.parents('.form-group').addClass('has-error has-feedback');
	});

	// hibás mezők jelölése küldés után
	$('.alert.alert-danger[data-danger-fields]').each(function() {
		var mezo;
		$.each($(this).data('danger-fields'), function(i, field) {
			mezo = field.toString().split('.').join('');
			$('#' + mezo)
				.after('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>')
				.parents('.form-group').addClass('has-error has-feedback');
		});
	});

	$('.datetimepicker').datetimepicker({
		language: 'hu',
		weekStart: 1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 0,
		maxView: 4,
		format: 'yyyy-mm-dd hh:ii'
	});

	$('.datepicker').datetimepicker({
		language: 'hu',
		weekStart: 1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		maxView: 4,
		format: 'yyyy-mm-dd'
	});

	$('.collapse').on('show.bs.collapse', function() {
		$('[href=#'+$(this).attr('id')+']').addClass('active').blur();
	});
	$('.collapse').on('hide.bs.collapse', function() {
		$('[href=#'+$(this).attr('id')+']').removeClass('active').blur();
	});

	// tab active
	var $navtabs = $('.nav-tabs');
	if ($navtabs.find('li.active:visible').length == 0) {
		var $tab = $navtabs.find('li a[href^="#"]:visible').first();
		$tab.tab('show');
	}

	$('form.ajax').ajaxForm({
		deletagion: true,
		target: '#result'
	});

	Dropzone.options.dropzone = {
		queuecomplete: function() {
			var $this = $(this.element);
			$($this.data('ajaxtarget')).load($this.data('ajaxurl'), function() {
				rendezheto();
			});
		},
		dictDefaultMessage: '<button type="button" class="btn btn-success"><span class="glyphicon glyphicon-upload"></span> Kattintson vagy húzza ide a feltölteni kívánt fájlokat</button>'
	};

	ck_editorok();
	
	function menu_tipus() {
		var $this = $(this),
			value = $this.val();
		
		if (value == 'szoveg') {
			$('#szoveg_id').attr('required', 'required').prop('required', 'required').parents('.form-group').slideDown();
		} else {
			$('#szoveg_id').removeAttr('required').removeProp('required').parents('.form-group').slideUp();
		}
	}
	$('.menu_tipus').each(menu_tipus);
	$('.menu_tipus').on('change', menu_tipus);

	$('.bs-select').selectpicker({
		noneSelectedText: '(válasszon)',
		liveSearch: true,
		liveSearchPlaceholder: '(keresés)'
	});

	$('.jcrop').each(function() {
		var $this = $(this),
			name = $this.data('name') || '_kivagasok',
			aspectRatio = $this.data('aspect-ratio') || 1,
			selection = $this.data('selection'),
			$input = $('<input type="hidden" name="' + name + '[' + aspectRatio + ']">');

		$this.parent().append($input);
		setTimeout(function() { // hack!
			$this.Jcrop({
				trueSize: [
					$this.get(0).naturalWidth,
					$this.get(0).naturalHeight
				],
				keySupport: false,
				aspectRatio: aspectRatio,
				onChange: function(c) {
					$input.val(JSON.stringify(c));
				},
				onSelect: function(c) {
					$input.val(JSON.stringify(c));
				},
				setSelect: [
					selection.x,
					selection.y,
					selection.x2,
					selection.y2
				],
				boxWidth: $this.width(),
				bgColor: ''
			});
		}, 400);
	});

});
