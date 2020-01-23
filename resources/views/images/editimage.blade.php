@extends('templates.layout')

@section('content')

    @if($photo->id)
        <h1>Modifica Immagine</h1>
        <form action="{{route('photos.update' , $photo->id)}}" method="POST" enctype="multipart/form-data">
            {{method_field('PATCH')}}
    @else
        <h1>Nuova Immagine</h1>
        <form action="{{route('photos.store')}}" method="POST" enctype="multipart/form-data">
    @endif
        @include('partials.inputerrors')
        <div class="form-group">
            <label for="nome">Name</label>
            <input type="text" name="name" id="name" value="{{old('name', $photo->name)}}" class="form-control" placeholder="Image Name">
        </div>
        <div class="form-group">
            <select name="album_id" id="album_id">
                <option value="">SELECT</option>
                @foreach($albums AS $item)
                    <option {{$item->id==$album->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->album_name}}</option>
                @endforeach
            </select>
        </div>

        {{@csrf_field()}}

        @include('images.partial.fileupload')

        <div class="form-group">
            <label for="nome">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Description">
                  {{old('description' , $photo->description)}}
            </textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>

    </form>

@endsection
