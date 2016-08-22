@extends('layout.default')

@section('content')
	<section id="network">
		<div class="container">
			<article id="edges-form">
				<div class="row">
					<h5>Új él hozzáadása</h5>
					{!! Form::open(['class' => 'form-horizontal','url' => "/network/$projectid/edge"]) !!}
					<div class="form-group col-sm-7">
						{{ Form::label('nev1', 'Név') }}
						{{ Form::text('nev1','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','id'=>'nev1','data-projectid' => $projectid]) }}
					</div>

					<div class="form-group col-sm-7">
						{{ Form::label('nev2', 'Név') }}
						{{ Form::text('nev2','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','id'=>'nev2','data-projectid' => $projectid]) }}
					</div>
					<div class="form-group col-sm-7">
						{!! Form::submit('Él hozzáadása') !!}
					</div>
					{!! Form::close() !!}
				</div>
			</article>


			<hr style="border-color: #bbb">
			<article id="letezok">
				<div>

					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active"><a href="#node" aria-controls="node" role="tab"
						                                          data-toggle="tab">Csúcsok</a></li>
						<li role="presentation"><a href="#edge" aria-controls="edge" role="tab"
						                           data-toggle="tab">Élek</a>
						</li>
						<li role="presentation"><a href="#download" aria-controls="download" role="tab"
						                           data-toggle="tab">Letöltés</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div role="tabpanel" class="tab-pane active" id="node">
							@include('elemek.network.node')
						</div>
						<div role="tabpanel" class="tab-pane" id="edge">
							@include('elemek.network.edge')
						</div>

						<div role="tabpanel" class="tab-pane" id="download">
							<div class="well" style="max-width:300px">
								<h5>70</h5>
								<a href="/download/{{$projectid}}/nodes" class="btn btn-primary btn-block">Csúcsok
									letöltése</a>
								<a href="/download/{{$projectid}}/edges" class="btn btn-primary btn-block">Élek
									letöltése</a>
							</div>
						</div>
					</div>

				</div>
			</article>
		</div>
	</section>




@endsection