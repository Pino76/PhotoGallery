@extends("templates.layout")

@section('content')

    <h1>Modifica Album</h1>

    <form method="POST" action="/albums/{{$album->id}}">
        {{csrf_field()}}
       <input type="hidden" name="_method" value="PATCH">
        <div class="form-group">
            <label for="nome">Name</label>
            <input type="text" name="name" id="name" value="{{$album->album_name}}" class="form-control" placeholder="Album Name">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description"  class="form-control" placeholder="Album Description">
                {{$album->description}}
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
