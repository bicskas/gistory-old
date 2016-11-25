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
                        <h3 class="text-center">Saját projektek</h3>
                        @foreach($lista as $n => $l)
                            <div class="col-sm-6" id="item_{!! $l->id !!}">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h5>{!! $l->cim !!}</h5></div>
                                    <div class="panel-body">
                                        {!! $l->leiras != "" ? $l->leiras : 'Ehhez a projekthez nem tartozik leírás' !!}
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
                            @if(($n+1)%2 == 0)
                                <div class="clearfix"></div>
                            @endif
                        @endforeach
                    </div>
                    <div class="row">
                        <h3 class="text-center">Velem megosztott projektek</h3>

                        @foreach($shared as $n => $l)
                            <div class="col-sm-6" id="item_{!! $l->id !!}">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h5>{!! $l->cim !!}</h5></div>
                                    <div class="panel-body">
                                        {!! $l->leiras != '' ? $l->leiras : 'Ehhez a projekthez nem tartozik leírás' !!}
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
                            @if(($n+1)%2 == 0)
                                <div class="clearfix"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="panel-footer">

                </div>
            </div>
        </div>
    </section>


@endsection
