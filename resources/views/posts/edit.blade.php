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
        <div class="row">
            <div class="col-md-4 col-lg-4">
                <div class="form-group">
                    {{Form::select('continent', $continents, $post->continent_id, ['class' => 'form-control'])}}
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="btn btn-primary">
                Cover image
                {{Form::file('cover_image', ['class' => 'd-none'])}}
            </label>
        </div>
        <div class="form-group">
            {{Form::label('rating', 'Rating')}}
            {{Form::selectRange('rating', 0, 5, $post->rating)}}
        </div>
        <div class="form-group">
            {{Form::label('tags', 'Tags')}}
            <small>( Seperate with Enter key, max 8 tags, max 25 symbols/tag )</small>
            {{Form::text('tags', $post->tags)}}
        </div>
        {{Form::hidden('_method', 'PUT')}}
        {{Form::submit('Update Post', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection