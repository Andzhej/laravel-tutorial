@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="clearfix">
                    {!! Form::open(['action' => ['HomeController@search'], 'class' => 'float-left form-inline']) !!}
                        <div class="form-group">
                            {{Form::text('title', (!empty($search_title) ? $search_title : ''), ['class' => 'form-control mr-2', 'placeholder' => 'Search by title', 'autocomplete' => 'off'])}}
                            {{Form::submit('Seach', ['class' => 'btn btn-success'])}}
                            <a href="/home" class="btn btn-warning ml-2">Reset</a>
                        </div>
                        {!! Form::close() !!}
                        <a class="btn btn-primary float-right " href="/posts/create">Create Post</a>
                    </div>
                    <h3 class="mt-2">Your blog posts</h3>
                    @if(count($posts) > 0)
                        <table class="table table-striped">
                            <tr>
                                <th>Title</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach($posts as $post)
                                <tr>
                                    <td>{{$post->title}}</td>
                                    <td><a href="/posts/{{$post->id}}/edit" class="btn btn-outline-secondary">Edit</a></td>
                                    <td>
                                        {!! Form::open(['action' => ['PostsController@destroy', $post->id], 'class' => 'float-right']) !!}
                                        {{Form::hidden('_method', 'DELETE')}}
                                        {{Form::submit('Delete', ['class' => 'btn btn-danger'])}}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    <div class="float-right">
                        {{$posts->links()}}
                    </div>
                    @else
                    <p>You have no posts</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
