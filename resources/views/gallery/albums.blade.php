@extends('templates.default')

@section('content')

    <div class="row">
    @foreach($albums AS $album)
        <div class="col-sm-4 col-md-3 col-lg-2">
            <div class="card m-2">
                <a href="{{route('gallery.album.images', $album->id)}}">
                    <img class="card-img-top img-fluid rounded" src="{{asset($album->path)}}" title="{{$album->album_name}}" alt="{{$album->album_name}}">
                </a>
                    <div class="card-body">
                    <h5 class="card-title">{{$album->album_name}}</h5>
                    <p class="card-title">{{$album->created_at->diffForHumans()}}</p>
                    <p class="card-text">
                        @foreach($album->categories AS $cat)
                            @if($cat->id != $category_id)
                                <a href="{{route('gallery.categories.albums', $cat->id)}}">{{$cat->category_name}}</a>
                            @else
                                {{$cat->category_name}}
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>
        </div>
    @endforeach
        {{$albums->links('vendor.pagination.bootstrap-4')}}
    </div>

@endsection
