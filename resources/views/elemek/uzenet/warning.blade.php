@if (Session::has('figyelmeztet'))
	<div class="bg-white">
		<div class="container">
			<br>
			<div class="alert alert-warning alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				{{ Session::get('figyelmeztet') }}
			</div>
		</div>
	</div>
@endif