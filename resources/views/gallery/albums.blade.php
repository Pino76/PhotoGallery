@extends('templates.layout')


@section('content')

<div class="card-deck" style="border:1px solid #F00">
    @foreach($albums as $album)
<div class="col-3">
    <div class="card">

        <a href="{{route('gallery.album.images' , $album->id)}}">
            <img  class="card-img-top" title="{{$album->album_name}}" src="{{asset($album->path)}}" alt="{{$album->album_name}}">
        </a>

        <div class="card-block">
            <h4 class="card-title">
                <a href="{{route('gallery.album.images' , $album->id)}}">
                    {{$album->album_name}}
                </a>
            </h4>
            <p class="card-text">
                Categories:
                @foreach($album->categories AS $cat)
                    <a href="{{route('gallery.album.category' , $cat->id)}}">{{$cat->category_name}}</a>
                @endforeach
            </p>
            <p class="card-text">
                <small class="text-muted">
                    {{$album->created_at->diffForHumans()}}
                </small>
            </p>
        </div>
    </div>
</div>
    @endforeach
</div>

@endsection
