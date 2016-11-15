@extends('layout.default')

@section('content')
    <section id="subprokects">
        <div class="container">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Alprojektek</h1>
                    <a class="btn btn-primary btn-xs text-right" href="/project/{!! $projectid !!}/subproject/create">
                        <span class="glyphicon glyphicon-plus"></span> Új hozzáadása
                    </a>
                    <a href="/project" class="btn-info btn btn-xs">
                        <span class="glyphicon glyphicon-arrow-left"></span> Vissza a projecthez
                    </a>

                </div>
                <div class="panel-body">

                    <div class="row">
                        @foreach($lista as $l)
                            <div class="col-sm-6" id="item_{!! $l->id !!}">
                                <div class="panel panel-default">
                                    <div class="panel-heading">{!! $l->nev !!}</div>
                                    <div class="panel-body">
                                        {!! $l->leiras !!}
                                        <br>
                                        <ul>
                                            <li>Csúcsok száma: {!! $l->node()->count() !!} db</li>
                                            <li>Élek száma: {!! $l->edge()->count() !!} db</li>
                                            <li>Klaszter: {!! $l->clustering !!}</li>
                                        </ul>
                                    </div>
                                    <div class="panel-footer">
                                        <a class="btn btn-default btn-xs text-right"
                                           href="/project/{!! $projectid !!}/subproject/{!! $l->id !!}/edit">
                                            <span class="glyphicon glyphicon-pencil"></span> Szerkesztés
                                        </a>
                                        <a class="btn btn-primary btn-xs text-right"
                                           href="/network/{!! $l->project->id !!}/{!! $l->id !!}">
                                            <span class="glyphicon glyphicon-plus"></span> Kapcsolatok
                                        </a>
                                        <a class="btn btn-danger btn-xs torol" title="Töröl"
                                           href="{{$l->createLink($projectid)}}">
                                            <span class="glyphicon glyphicon-trash"></span> Töröl
                                        </a>
                                    </div>
                                </div>
                            </div>

                        @endforeach

                        @if(count($lista) > 1)
                            <div class="col-sm-6" id="item_osszes">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Összehasoníltás</div>
                                    <div class="panel-body">
                                        {!! $l->leiras !!}
                                    </div>
                                    <div class="panel-footer">
                                        <a class="btn btn-primary btn-xs text-right"
                                           href="/network/compare/{{$projectid}}">
                                            <span class="glyphicon glyphicon-plus"></span> Öszehasonlítás
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </section>


@endsection
