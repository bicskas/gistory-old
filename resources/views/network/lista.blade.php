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
                        {{ Form::text('nev1','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','autocomplete' => 'off','id'=>'nev1','data-projectid' => $projectid]) }}
                    </div>

                    <div class="form-group col-sm-7">
                        {{ Form::label('nev2', 'Név') }}
                        {{ Form::text('nev2','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','autocomplete' => 'off','id'=>'nev2','data-projectid' => $projectid]) }}
                    </div>
                    <div class="form-group col-sm-7">
                        {!! Form::submit() !!}
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