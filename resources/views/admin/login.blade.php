@extends('admin/admin')

@section('content')
{!! Form::open(['url' => '/admin/auth/login', 'method' => 'POST', 'role' => 'form', 'class' => 'form-signin']) !!}
	<h2 class="form-signin-heading">Bejelentkezés</h2>
	<label for="email" class="sr-only">Email cím</label>
	<input type="text" id="email" name="email" class="form-control" placeholder="Email cím" required autofocus>
	<label for="password" class="sr-only">Jelszó</label>
	<input type="password" id="password" name="password" class="form-control" placeholder="Jelszó" required>
	<button class="btn btn-lg btn-primary btn-block" type="submit">Bejelentkezés</button>
{!! Form::close() !!}
@endsection
