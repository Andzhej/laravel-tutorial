@extends('layouts.app')
  
@section('content')
    <div class="jumbotron text-center">
        <h1>{{$title}}</h1>
        <p>This website tells everything about cities you should visit!</p>
        <div class="home-image mb-3">
            <img style="width:100%;" src="images/home.jpg" />
        </div>
        @guest
        <p>
            <a href="/login" class="btn btn-success">Login</a>
            <a href="/register" class="btn btn-primary">Register</a>
        </p>
        @endguest
    </div>
@endsection
