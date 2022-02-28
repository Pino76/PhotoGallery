@extends('templates.default')

@section('content')
    <h1>Create New Album</h1>
    @include('partials.inputerrors')
    <form method="POST" action="{{route('albums.store')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="album_name">Name</label>
            <input type="text" value="{{old('album_name')}}" class="form-control" name="album_name" id="album_name">
        </div>

        @include('albums.partials.fileupload')

        @include('albums.partials.category_combo')
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description">{{old('description')}}</textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-primary">Salva</button>
        </div>
    </form>
@endsection
