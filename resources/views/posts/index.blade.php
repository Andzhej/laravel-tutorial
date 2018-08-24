@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 0)
        <div class="card-columns">
        @foreach($posts as $post)
        <div class="card mb-3">
            @if($post->cover_image)
                <div class="cover-image" style="background-image:url('/storage/cover_images/{{$post->cover_image}}');"></div>
            @else
                <div class="cover-image" style="background-image:url('/images/noimage.png');"></div>
            @endif
            <div class="card-body">
                <h4 class="card-title mt-3"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h4>
                <p>{!! $post->post_excerpt !!} <a href="/posts/{{$post->id}}">Read more</a></p>
                <small>Written at {{$post->created_at}} by <a href="/user/{{$post->user->id}}/user-posts">{{$post->user->name}}</a></small>
                <ul class="raiting mt-2">
                    @for ($i = 0; $i < 5; $i++)
                        <li @if($post->rating > $i) class="colored" @endif></li>
                    @endfor
                </ul>
                <div class="tags">
                    @if(count($post->tags) > 1)
                    <ul class="tag-list mt-2">
                        @foreach($post->tags as $tag)
                            <li>{{$tag}}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
        <div class="float-right">
            {{$posts->links()}}
        </div>
    @else
        <p>No posts found</p>
    @endif
@endsection