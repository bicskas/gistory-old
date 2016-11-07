@extends('layout.default')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title pull-left">{!! $model->name !!} csoport szerkesztése</h3>
                <div class="pull-right">
                    <a href="/{{$aktiv_oldal}}" class="btn-info btn btn-xs">
                        <span class="glyphicon glyphicon-arrow-left"></span> Vissza
                    </a>
                </div>
            </div>
            <div class="panel-body">
                <div class="well">
                    Tulajdonos: {!! $model->owner->name !!}

                    @if(Auth::user()->id == $model->owner->id)
                        {!! Form::open(['id' => 'addteam','route' => ['addteam',$model->id],'method' => 'POST', 'class' => 'form-inline pull-right']) !!}
                        <div class="form-group">
                            <?php $id = 'email' ?>
                            {!! Form::label($id, 'Új tag hozzáadása', ['class' => 'control-label']) !!}
                            {!! Form::text($id, Input::get($id), ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id).' cím']) !!}
                        </div>
                        <div class="form-group">
                        {!! Form::submit("Hozzáad",['class' => 'btn btn-success']) !!}
                        </div>
                        {!! Form::close() !!}
                    @endif

                </div>

                <hr>
                <h4>Tagok</h4>
                @foreach($model->users as $user)
                    {!! $user->name !!}
                @endforeach
            </div>
            <div class="panel-footer">
            </div>
        </div>
    </div>
@endsection