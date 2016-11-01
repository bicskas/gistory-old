@extends('layout/default')

@section('content')
    <section id="login" class="container">
        {!! Form::open(['method' => 'POST']) !!}

        <div class="form-group">
            <?php $id = 'email' ?>
            {!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
            {!! Form::email($id, null, ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id), 'required']) !!}
        </div>

        <div class="form-group">
            <?php $id = 'password' ?>
            {!! Form::label($id, labels($id), ['class' => 'control-label']) !!}
            {!! Form::password($id, ['id' => $id, 'class' => 'form-control', 'placeholder' => labels($id), 'required']) !!}
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Bejelentkezés</button>
            <a href="/auth/register" class="btn btn-warning btn-sm">Regisztráció</a>
        </div>
        {!! Form::close() !!}

    </section>
@endsection
