@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-9 col-lg-9">
    @if(count($posts) > 0)
                    <h1 class="float-left">Posts</h1>
                    <div class="filter-links float-right">
                        <span>Filter: </span>
                        <a href="/posts/?rating=true">By rating</a> |
                        <a href="/posts/?title=true">By title</a> |
                        <a href="/posts">Reset</a>
                    </div>
                    <div style="clear:both;"></div>
                    <div class="row">
                            @foreach($posts as $post)
                                <div class="col-md-12 col-lg-12">
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
                                        <div class="right-side float-right">
                                            <a href="/posts/continent/{{$post->continent->id}}" class="mr-4">{{$post->continent->name}}</a>
                                            <ul class="raiting mt-2">
                                                @for ($i = 0; $i < 5; $i++)
                                                    <li @if($post->rating > $i) class="colored" @endif></li>
                                                @endfor
                                            </ul>
                                        </div>
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
                                </div>
                            @endforeach
                        </div>
                        <div class="float-right">
                            {{$posts->links()}}
                        </div>
                        @else
                            <p>No posts found</p>
                        @endif
            </div>
            @include('inc.sidebar')
        </div>
@endsection