@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-outline-secondary">Go back</a>
    <h1>{{$post->title}}</h1>
    <img class="mb-3" style="width:100%" src='/storage/cover_images/{{$post->cover_image}}'>
    <div>
        {!! $post->body !!}
    </div>
    <hr>
    <div class="row">
        <div class="col-md-2 col-sm-2">
            <small>Written on {{$post->created_at}} by {{$post->user->name}}</small>
        </div>
        @if($post->user->profile_picture)
        <div class="col-md-1 col-sm-1">
            <div class="profile-picture-small-container">
                <img style="width:100%;" src='/storage/profile_pictures/{{$post->user->profile_picture}}' />
            </div>
        </div>
        <div class="col-md-1 col-sm-1 offset-md-8">
            <ul class="raiting">
                @for ($i = 0; $i < 5; $i++)
                    <li @if($post->rating > $i) class="colored" @endif></li>
                @endfor
            </ul>
        </div>
        @endif
    </div>
    <hr>
    @if(!Auth::guest())
        @if(Auth::user()->id == $post->user_id)
            <a href="/posts/{{$post->id}}/edit" class="btn btn-outline-secondary">Edit</a>
            {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'class' => 'float-right']) !!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
            {!! Form::close() !!}
        @endif
    @endif
@endsection