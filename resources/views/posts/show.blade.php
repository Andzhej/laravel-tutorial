@extends('layouts.app')

@section('content')
    <a href="/posts" class="btn btn-outline-secondary">Go back</a>
    <div class="post-navigation-buttons float-right">
        @if($prev)
            <a href="/posts/{{$prev->id}}" class="btn btn-outline-secondary">Previous post</a>
        @endif
        @if($next)
            <a href="/posts/{{$next->id}}" class="btn btn-outline-secondary">Next post</a>
        @endif
            <a href="/posts/{{$random->id}}" class="btn btn-outline-secondary">Random post</a>
    </div>
    <h1 class="mt-3">{{$post->title}}</h1>
    @if($post->cover_image)
        <img class="mb-3" style="width:100%" src='/storage/cover_images/{{$post->cover_image}}'>
    @else
        <img class="mb-3" style="width:100%" src='/images/noimage.png'>
    @endif
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
        <div class="col-md-3 col-sm-3 offset-md-5">
            <div class="tags">
                @if(count($post->tags) > 1)
                <ul class="tag-list">
                    @foreach($post->tags as $tag)
                        <li>{{$tag}}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>
        <div class="col-md-1 col-sm-1">
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