@extends('templates.admin')

@section('content')


<div class="row d-flex justify-content-center">
    <div class="col-auto col-sm-6">
        <h1>Manage User</h1>
        @if($user->id)
        <form method="POST" action="{{route('users.update' , $user->id)}}">
            @method('PATCH')
            @else
                <form method="POST" action="{{route('users.store')}}">
                    @endif

                    @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" value="{{old('name', $user->name)}}" name="name" id="name" placeholder="user's name" class="form-control">
            </div>
            @error('name')
                <div class="alert alert-danger">
                    @foreach($errors->get('name') AS $err)
                        <p>{{$err}}</p>
                    @endforeach
                </div>
            @enderror
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" value="{{old('email', $user->email)}}" name="email" id="email" placeholder="user's email" class="form-control">
            </div>
            @error('email')
                <div class="alert alert-danger">
                    @foreach($errors->get('email') AS $err)
                        <p>{{$err}}</p>
                    @endforeach
                </div>
            @enderror
            <div class="form-group">
                <label for="role">Role</label>
                <select name="user_role" id="user_role" class="form-control">
                    <option value="">SELECT</option>
                    <option {{$user->user_role == 'user' ? 'selected' : ''}} value="user">User</option>
                    <option {{$user->user_role == 'admin' ? 'selected' : ''}} value="admin">Admin</option>
                </select>
                @error('user_role')
                    <div class="alert alert-danger">
                        @foreach($errors->get('user_role') AS $err)
                            <p>{{$err}}</p>
                        @endforeach
                    </div>
                @enderror
            </div>
            <div class="form-group justify-content-center d-flex">
                <button class="btn btn-info m-2 w-25" type="reset">Reset</button>
                <button class="btn btn-primary m-2 w-25">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection
