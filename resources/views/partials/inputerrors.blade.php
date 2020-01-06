@if(count($errors)>0)
    <div class="alert alert-danger">
        @foreach($errors->all() AS $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
@endif
