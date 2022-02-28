@extends('templates.default')
@php
/**
* @var $photo App\Models\Photo
*
*/
@endphp
@section('content')

@include('partials.inputerrors')

    @if($photo->id)
    <h1>Modifica Immagine</h1>
    <form method="POST" action="{{route('photos.update', $photo->id)}}" enctype="multipart/form-data">
        @method('PATCH')
    @else
    <h1>Nuova Immagine</h1>
    <form method="POST" action="{{route('photos.store')}}" enctype="multipart/form-data">
    @endif
        @csrf
        <div class="form-group">
            <label for="album_name">Name</label>
            <input type="text" value="{{$photo->name}}" class="form-control" name="name" id="name">
        </div>

        <div class="form-group">
            <label for="album_name">Album</label>
            <select class="form-control"  name="album_id" id="album_id">
                <option>Seleziona</option>
                @foreach($albumList AS $item)
                    <option {{$item->id == $album->id ? 'selected' : ''}} value="{{$item->id}}">{{$item->album_name}}</option>
                @endforeach
            </select>
        </div>




        @include('images.partials.fileupload')

        <div class="form-group">
            <label for="description">Description</label>
            <textarea required class="form-control" name="description" id="description">
                {{$photo->description}}
            </textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-primary">Salva</button>
        </div>
    </form>
@endsection
