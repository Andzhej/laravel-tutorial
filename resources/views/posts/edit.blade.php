@extends('layouts.app')

@section('content')
    <h1>Edit post</h1>
    {!! Form::open(['action' => ['PostsController@update',  $post->id], 'enctype' => 'multipart/form-data']) !!}
        <div class="form-group">
            {{Form::label('title', 'Title')}}
            {{Form::text('title', $post->title, ['class' => 'form-control', 'placeholder' => 'Title', 'autocomplete' => 'off'])}}
        </div>
        <div class="form-group">
            {{Form::label('body', 'Body')}}
            {{Form::textarea('body', $post->body, ['id' => 'article-ckeditor','class' => 'form-control', 'placeholder' => 'Body text'])}}
        </div>
        <div class="form-group">
            {{Form::file('cover_image')}}
        </div>
        <div class="form-group">
            {{Form::label('rating', 'Rating')}}
            {{Form::selectRange('rating', 0, 5, $post->rating)}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Add Post', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection