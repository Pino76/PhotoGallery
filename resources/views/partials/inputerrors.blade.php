@if(count($errors))
    <div class="alert alert-danger">
        @foreach($errors->all() AS $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
@endif
