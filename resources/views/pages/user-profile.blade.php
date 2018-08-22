@extends('layouts.app')
  
@section('content')
    <h1>User profile</h1>
    {!! Form::open(['action' => ['UserController@update', $user->id], 'enctype' => 'multipart/form-data']) !!}
    <div class="row">
        <div class="col-md-8 col-sm-8">
             <div class="form-group">
                {{Form::label('email', 'Email')}}
                {{Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email', 'autocomplete' => 'off', 'disabled'])}}
            </div>
            <div class="form-group">
                {{Form::label('name', 'Name')}}
                {{Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Name', 'autocomplete' => 'off'])}}
            </div>
            <div class="form-group">
                {{Form::label('address', 'Address')}}
                {{Form::text('address', $user->address, ['class' => 'form-control', 'placeholder' => 'Address', 'autocomplete' => 'off'])}}
            </div>
            <div class="form-group">
                {{Form::label('birthday', 'Birthday')}}
                {{Form::date('birthday', $user->birthday, ['class' => 'form-control', 'placeholder' => 'Birthday', 'autocomplete' => 'off'])}}
            </div>
            <div class="form-group">
                {{Form::label('profile_picture', 'Profile picture')}}
                {{Form::file('profile_picture', ['class' => 'form-control'])}}
            </div>
        </div>
        <div class="col-md-4 col-sm-4">
            <div class="profile-picture-iner">
                @if($user->profile_picture)
                    <img style="width:100%" src='/storage/profile_pictures/{{$user->profile_picture}}' />
                @else
                    <img style="width:100%" src='/images/noimage.jpg' />
                @endif
            </div>
        </div>
    </div>
    {{Form::submit('Update information', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}
@endsection
