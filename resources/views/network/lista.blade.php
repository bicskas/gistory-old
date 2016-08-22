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
<<<<<<< HEAD
                        {{ Form::text('nev1','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','id'=>'nev1','data-projectid' => $projectid]) }}
=======
                        {{ Form::text('nev1','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','autocomplete' => 'off','id'=>'nev1','data-projectid' => $projectid]) }}
>>>>>>> 38a51eb836b6b5e4a2380b44295b5efc01d744e2
                    </div>

                    <div class="form-group col-sm-7">
                        {{ Form::label('nev2', 'Név') }}
<<<<<<< HEAD
                        {{ Form::text('nev2','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','id'=>'nev2','data-projectid' => $projectid]) }}
                    </div>
                    <div class="form-group col-sm-7">
                        {!! Form::submit('Él hozzáadása') !!}
=======
                        {{ Form::text('nev2','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','autocomplete' => 'off','id'=>'nev2','data-projectid' => $projectid]) }}
                    </div>
                    <div class="form-group col-sm-7">
                        {!! Form::submit() !!}
>>>>>>> 38a51eb836b6b5e4a2380b44295b5efc01d744e2
                    </div>
                    {!! Form::close() !!}
                </div>
            </article>


            <hr style="border-color: #bbb">
            <article id="letezok">
                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#node" aria-controls="home" role="tab"
                                                                  data-toggle="tab">Csúcsok</a></li>
                        <li role="presentation"><a href="#edge" aria-controls="profile" role="tab" data-toggle="tab">Élek</a>
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
                    </div>

                </div>
            </article>
        </div>
    </section>




@endsection