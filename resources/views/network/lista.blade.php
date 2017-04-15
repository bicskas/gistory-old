@extends('layout.default')

@section('content')
    <section id="network">
        <div class="container">
            <div class="well">
                <h4>Alproject: {!! $subproject->nev !!}</h4>
                <div class="pull-right">
                    <a href="/project/{!! $projectid !!}/subproject" class="btn-info btn btn-xs">
                        <span class="glyphicon glyphicon-arrow-left"></span> Vissza az alprojektekhez
                    </a>
                </div>
            </div>
            <article id="edges-form">
                <h5>Új él hozzáadása</h5>
                {!! Form::open(['class' => 'form-horizontal','url' => "/network/$projectid/$subproject->id/edge",'id' => 'typeahead']) !!}
                <div class="form-group col-sm-7">
                    {{ Form::label('nev1', 'Név') }}
                    {{ Form::text('nev1','',['required' => 'required','class' => 'form-control typeahead','placeholder' => 'Név','id'=>'nev1','data-projectid' => $projectid]) }}
                </div>

                <div class="form-group col-sm-7">
                    {{ Form::label('nev2', 'Név') }}
                    {{ Form::text('nev2','',['required' => 'required','class' => 'form-control typeahead','placeholder' => 'Név','id'=>'nev2','data-projectid' => $projectid]) }}
                </div>
                <div class="form-group col-sm-7">
                    {{ Form::label('erosseg', 'Erősség') }}
                    {{ Form::text('weight','1',['required' => 'required','class' => 'form-control','placeholder' => 'Erősség','id'=>'erosseg','data-projectid' => $projectid]) }}
                </div>
                {{--  <div class="form-group col-sm-7">
                      {!! Form::radio('type','0',true,['id' => 'undirect']) !!}
                      {!! Form::label('undirect','Irányítatlan') !!}

                      {!! Form::radio('type','1',false,['id' => 'direct']) !!}
                      {!! Form::label('direct','Irányított') !!}
                  </div>--}}
                <div class="form-group col-sm-7">
                    {!! Form::label('time','Idő') !!}
                    {!! Form::select('time',[2012,2013,2014,2015,2016],null,['class' => 'form-control bs-select-no-search','multiple']) !!}
                </div>
                <div class="form-group col-sm-7">
                    {!! Form::submit('Él hozzáadása',['class' => 'btn btn-primary']) !!}
                </div>
                {!! Form::close() !!}
                <div class="clearfix"></div>
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
                            <a href="#svg-kep" aria-controls="download" role="tab" data-toggle="tab">Chord</a>
                        </li>
                        <li role="presentation">
                            <a href="#force-graph" aria-controls="download" role="tab" data-toggle="tab">Gráf</a>
                        </li>
                        <li role="presentation">
                            <a href="#statisztika" aria-controls="download" role="tab"
                               data-toggle="tab">Eloszlások felsorolása</a>
                        </li>
                    </ul>


                    <h5>Küszöbölés a fokszámra</h5>
                    {!! Form::open(['id' => 'kuszob-node','url' => "/network/$projectid/$subproject->id/kuszob",'method' => 'POST']) !!}
                    <b>{!! min($degrees) !!} </b> <input id="fokszam-slider" name="fokszam-slider" type="text"
                                                         class="span2" value=""
                                                         data-slider-min="{!! min($degrees) !!}"
                                                         data-slider-max="{!! max($degrees) !!}"
                                                         data-slider-step="1"
                                                         data-slider-value="[{!! min($degrees) !!},{!! max($degrees) !!}]"/>
                    <b> {!! max($degrees) !!}</b>
                {!! Form::close() !!}

                <!-- Tab panes -->
                    <div class="tab-content" id="abrak-tab">
                        <div role="tabpanel" class="tab-pane active" id="node">
                            @include('elemek.network.subproject_node')
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
                            <div id="svg" class="circular" data-json="/{{$file}}"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="force-graph">
                            <div id="force" class="force" data-json="/{!! $forcefile !!}">
                                <svg width="1000" height="800"></svg>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="statisztika">
                            <div id="radar" data-radar_data="{{$radar_data}}" >
                            </div>
                            <div id="bar" data-nevek="{{$nevek}}" data-degree="{!! $degree !!}">
                                <svg class="chart" width="1000" height="800"></svg>
                            </div>
                        </div>
                    </div>

                </div>
            </article>
        </div>
    </section>




@endsection