@extends('layout.default')

@section('content')
    <section id="network">
        <div class="container">
            <div class="well">
                <h4>Összehasonlítás: {!! $project->cim !!}</h4>
                <div class="pull-right"><a href="/project/{!! $projectid !!}/subproject" class="btn-info btn btn-xs">
                        <span class="glyphicon glyphicon-arrow-left"></span> Vissza az alprojektekhez
                    </a></div>
            </div>
            <hr style="border-color: #bbb">
            <article id="letezok">
                <div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#chord-diff" aria-controls="download" role="tab" data-toggle="tab">Chord
                                különbség</a>
                        </li>
                        <li role="presentation">
                            <a href="#chord-same" aria-controls="download" role="tab" data-toggle="tab">Chord
                                egyezés</a>
                        </li>
                        <li role="presentation">
                            <a href="#force-graph-diff" aria-controls="download" role="tab" data-toggle="tab">Gráf
                                különbség</a>
                        </li>
                        <li role="presentation">
                            <a href="#force-graph-same" aria-controls="download" role="tab" data-toggle="tab">Gráf
                                egyezés</a>
                        </li>
                        <li role="presentation">
                            <a href="#statisztika" aria-controls="download" role="tab"
                               data-toggle="tab">Fokszámeloszlás</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane" id="chord-diff">
                            {{--<div id="svg" data-json="/{{$file_same}}"></div>--}}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="chord-same">
                            {{--<div id="svg" data-json="/{{$file_diff}}"></div>--}}
                        </div>
                        <div role="tabpanel" class="tab-pane" id="force-graph-diff">
                            <div id="force_diff" data-json="/{!! $forcefile_diff !!}">
                                <svg width="1000" height="800"></svg>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="force-graph-same">
                            <div id="force_same" data-json="/{!! $forcefile_same !!}">
                                <svg width="1000" height="800"></svg>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="statisztika">
                            {{--<div id="bar" data-nevek="{{$nevek}}" data-degree="{!! $degree !!}">--}}
                            <svg class="chart" width="1000" height="800"></svg>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </section>




@endsection