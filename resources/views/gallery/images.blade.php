@extends('templates.layout')

@section('content')

    <div class="row">
        @forelse($images AS $image)
            <div class="col-lg-2 col-md-4 col-sm-6">
                <a href="{{asset($image->img_path)}}" data-lightbox="{{$album->album_name}}">
                    <img data-lightbox="{{$image->id.'-'.$image->name}}" src="{{asset($image->img_path)}}" alt="{{$image->name}}" class="img-fluid img-thumbnail" width="200px">
                </a>
            </div>
         @empty

            <p class="text-center">Immagini non presenti in questo album</h1>

        @endforelse
    </div>

@endsection
