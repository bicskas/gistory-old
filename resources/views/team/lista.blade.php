@extends('layout.default')

@section('content')
    <section id="projektek">
        <div class="container">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h1>Csoportok</h1><a class="btn btn-primary btn-xs text-right" href="/team/create">
                        <span class="glyphicon glyphicon-plus"></span> Új hozzáadása
                    </a>

                </div>
                <div class="panel-body">

                    <div class="row">
                        <h3 class="text-center">Saját csoportok</h3>
                        @foreach($lista as $l)
                            <div class="col-sm-6" id="item_{!! $l->id !!}">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h5>{!! $l->name !!}</h5></div>
                                    <div class="panel-body">
                                        {!! $l->leiras !!}
                                    </div>
                                    <div class="panel-footer">
                                        <a class="btn btn-primary btn-xs text-right" href="/team/{!! $l->id !!}">
                                            <span class="glyphicon glyphicon-user"></span> Tagok
                                        </a>
                                        <a class="btn btn-danger btn-xs torol" title="Töröl" href="{{$l->createLink()}}">
                                            <span class="glyphicon glyphicon-trash"></span> Töröl
                                        </a>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                    <div class="row">
                        <h3 class="text-center">Csoport tagságok</h3>
                        @foreach($teams as $l)
                            <div class="col-sm-6" id="item_{!! $l->id !!}">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><h5>{!! $l->name !!}</h5></div>
                                    <div class="panel-body">
                                        {!! $l->leiras !!}
                                    </div>
                                    <div class="panel-footer">
                                        <a class="btn btn-primary btn-xs text-right" href="/team/{!! $l->id !!}">
                                            <span class="glyphicon glyphicon-user"></span> Tagok
                                        </a>
                                        <a class="btn btn-danger btn-xs torol" title="Töröl" href="{{$l->createLink()}}">
                                            <span class="glyphicon glyphicon-trash"></span> Töröl
                                        </a>
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
