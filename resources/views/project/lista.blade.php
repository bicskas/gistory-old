@extends('layout.default')

@section('content')
    <section id="projektek">
        <div class="container">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Projektek</h1><a class="btn btn-primary btn-xs text-right" href="/project/create">
                        <span class="glyphicon glyphicon-plus"></span> Új hozzáadása
                    </a>

                </div>
                <div class="panel-body">

                    <div class="row">
                        <h4>Saját projektek</h4>
                        @foreach($lista as $l)
                            <div class="col-sm-6" id="item_{!! $l->id !!}">
                                <div class="panel panel-default">
                                    <div class="panel-heading">{!! $l->cim !!}</div>
                                    <div class="panel-body">
                                        {!! $l->leiras !!}
                                    </div>
                                    <div class="panel-footer">
                                        <a class="btn btn-default btn-xs text-right" href="{{$l->createLink()}}/edit">
                                            <span class="glyphicon glyphicon-pencil"></span> Szerkesztés
                                        </a>

                                        <a class="btn btn-primary btn-xs text-right" href="/network/{!! $l->id !!}">
                                            <span class="glyphicon glyphicon-user"></span> Csúcsok
                                        </a>
                                        <a class="btn btn-success btn-xs text-right"
                                           href="/project/{!! $l->id !!}/subproject">
                                            <span class="glyphicon glyphicon-list-alt"></span> Alprojektek
                                        </a>
                                        <div class="pull-right">
                                            <a class="btn btn-danger btn-xs torol" title="Töröl"
                                               href="{{$l->createLink()}}">
                                                <span class="glyphicon glyphicon-trash"></span> Töröl
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                    <div class="row">
                        <h4>Velem megosztott projektek</h4>

                        @foreach($shared as $l)
                            <div class="col-sm-6" id="item_{!! $l->id !!}">
                                <div class="panel panel-default">
                                    <div class="panel-heading">{!! $l->cim !!}</div>
                                    <div class="panel-body">
                                        {!! $l->leiras !!}
                                    </div>
                                    <div class="panel-footer">
                                        <a class="btn btn-default btn-xs text-right" href="{{$l->createLink()}}/edit">
                                            <span class="glyphicon glyphicon-pencil"></span> Szerkesztés
                                        </a>

                                        <a class="btn btn-primary btn-xs text-right" href="/network/{!! $l->id !!}">
                                            <span class="glyphicon glyphicon-user"></span> Kapcsolatok
                                        </a>
                                        <a class="btn btn-success btn-xs text-right"
                                           href="/project/{!! $l->id !!}/subproject">
                                            <span class="glyphicon glyphicon-list-alt"></span> Alprojektek
                                        </a>
                                        <div class="pull-right">
                                            <a class="btn btn-danger btn-xs torol" title="Töröl"
                                               href="{{$l->createLink()}}">
                                                <span class="glyphicon glyphicon-trash"></span> Töröl
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </section>


@endsection
