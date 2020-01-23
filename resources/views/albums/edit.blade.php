@extends("templates.layout")

@section('content')
    <h1>Modifica Album</h1>
    @include('partials.inputerrors')
    <form method="POST" action="{{route('album.patch' , $album->id)}}" enctype="multipart/form-data">
        {{csrf_field()}}
       <input type="hidden" name="_method" value="PATCH">
        <div class="form-group">
            <label for="nome">Name</label>
            <input type="text" name="name" id="name" value="{{old('name' , $album->album_name)}}" class="form-control" placeholder="Album Name">
        </div>

            @include("albums.partial.fileupload")

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description"  class="form-control" placeholder="Album Description">
                {{old('description' , $album->description)}}
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <a href="{{route('albums')}}" class="btn btn-secondary">Back</a>
    </form>

@endsection
