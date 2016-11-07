@extends('layout.default')

@section('content')
    <section id="network">
        <div class="container">
            <article id="edges-form">
                <div class="row">
                    <h5>Új él hozzáadása</h5>
                    {!! Form::open(['class' => 'form-horizontal','url' => "/network/$projectid/$subproject->id/edge"]) !!}
                    <div class="form-group col-sm-7">
                        {{ Form::label('nev1', 'Név') }}
                        {{ Form::text('nev1','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','id'=>'nev1','data-projectid' => $projectid]) }}
                    </div>

                    <div class="form-group col-sm-7">
                        {{ Form::label('nev2', 'Név') }}
                        {{ Form::text('nev2','',['required' => 'required','class' => 'form-control','placeholder' => 'Név','id'=>'nev2','data-projectid' => $projectid]) }}
                    </div>
                  {{--  <div class="form-group col-sm-7">
                        {!! Form::radio('type','0',true,['id' => 'undirect']) !!}
                        {!! Form::label('undirect','Irányítatlan') !!}

                        {!! Form::radio('type','1',false,['id' => 'direct']) !!}
                        {!! Form::label('direct','Irányított') !!}
                    </div>--}}
                    <div class="form-group col-sm-7">
                        {!! Form::submit('Él hozzáadása',['class' => 'btn btn-primary']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </article>


            <hr style="border-color: #bbb">
            <article id="letezok">
                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#node" aria-controls="node" role="tab" data-toggle="tab">Csúcsok</a></li>
                        <li role="presentation">
                            <a href="#edge" aria-controls="edge" role="tab" data-toggle="tab">Élek</a>
                        </li>
                        <li role="presentation">
                            <a href="#download" aria-controls="download" role="tab" data-toggle="tab">Letöltés</a>
                        </li>
                        <li role="presentation">
                            <a href="#svg-kep" aria-controls="download" role="tab" data-toggle="tab">SVG</a>
                        </li>
                        <li role="presentation">
                            <a href="#statisztika" aria-controls="download" role="tab"
                               data-toggle="tab">Statisztikák</a>
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
                                <a href="/download/{{$projectid}}/nodes" class="btn btn-primary btn-block">Csúcsok
                                    letöltése</a>
                                <a href="/download/{{$projectid}}/edges" class="btn btn-primary btn-block">Élek
                                    letöltése</a>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane" id="svg-kep">
                            <div id="svg" data-json="/{{$file}}"></div>
                            <div id="force" data-json="/{{$forcefile}}">
                                {{--<svg width="960" height="600"></svg>--}}
                                <svg width="1140" height="800"></svg>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="statisztika">
                            <div id="bar" data-nevek="{{$nevek}}" data-degree="{!! $degree !!}">
                                <svg class="chart" ></svg>
                            </div>

                            {{--@barchart( 'MyStocks', 'bar')--}}
                        </div>
                    </div>

                </div>
            </article>
        </div>
    </section>




@endsection