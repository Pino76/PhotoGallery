@extends('templates.admin')
@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <h1>User insert/update</h1>

        @if(session()->has('message'))
            <div class="alert alert-info">
                <strong>{{session('message')}}</strong>
            </div>
        @endif

        @if($user->id)
       <form action="{{route('users.update' , $user->id)}}" method="POST">
           {{method_field('PATCH')}}
       @else
       <form action="{{route('users.store')}}" method="POST">
       @endif
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" value="{{ old('name') ? old('name') : $user->name }}" name="name" id="name" class="form-control" placeholder="">
                @if($errors->get('name'))
                    <div class="badge badge-danger">
                        @foreach($errors->get('name') AS $error)
                            {{$error}}<br/>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="form-group">
               <label for="email">Email</label>
               <input type="text" value="{{old('email') ? old('email') : $user->email }}" name="email" id="email" class="form-control" placeholder="">
                @if($errors->get('email'))
                    <div class="badge badge-danger">
                        @foreach($errors->get('email') AS $error)
                            {{$error}}<br/>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="form-group">
               <label for="role">Role</label>
               <select name="role" id="role" class="form-control">
                  <option value="">Seleziona</option>
                  <option value="user" {{(old('role')=='user' || $user->role == 'user' ) ? 'selected' : ''}}>User</option>
                  <option value="admin" {{(old('role')=='admin' || $user->role == 'admin' ) ? 'selected' : ''}}>Admin</option>
               </select>
                @if($errors->get('role'))
                    <div class="badge badge-danger">
                        @foreach($errors->get('role') AS $error)
                            {{$error}}<br/>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="form-group text-center">
               {{csrf_field()}}
                <a href="{{route('user-list')}}"  class="btn btn-default">Back</a>
               <button  class="btn btn-default" id="reset" type="reset">RESET</button>
               <button   class="btn btn-success"  id="save">SAVE</button>
            </div>
           <input type="hidden" name="id" value="{{$user->id}}">
       </form>
    </div>
</div>
@endsection
