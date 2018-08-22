@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    @if(count($posts) > 0)
        @foreach($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                            @if($post->cover_image)
                                <img style="width:100%" src='/storage/cover_images/{{$post->cover_image}}'>
                            @else
                                <img style="width:100%" src='/images/noimage.jpg'>
                            @endif
                        </div>
                        <div class="col-md-8 col-sm-8">
                            <h4 class="card-title"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h4>
                            <p>{!! $post->post_excerpt !!} <a href="/posts/{{$post->id}}">Read more</a></p>
                            <small>Written at {{$post->created_at}} by <a href="/user/{{$post->user->id}}/user-posts">{{$post->user->name}}</a></small>
                            <ul class="raiting">
                            @for ($i = 0; $i < 5; $i++)
                                <li @if($post->rating > $i) class="colored" @endif></li>
                            @endfor
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="float-right">
            {{$posts->links()}}
        </div>
    @else
        <p>No posts found</p>
    @endif
@endsection