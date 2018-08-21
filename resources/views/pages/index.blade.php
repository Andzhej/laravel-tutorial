@extends('layouts.app')
  
@section('content')
    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        <p>Laravel tutorials</p>
        @guest
        <p>
            <a href="/login" class="btn btn-success">Login</a>
            <a href="/register" class="btn btn-primary">Register</a>
        </p>
        @endguest
    </div>
@endsection
