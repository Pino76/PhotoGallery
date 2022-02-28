@extends('templates.default')

@section('content')

    <div class="row">
        @forelse($images AS $image)
            <div class="col-sm-4 col-md-3 col-lg-2">
                <div class="card m-2">
                    <a href="{{asset($image->path)}}" data-lightbox="{{$album->album_name}}">
                        <img class="card-img-top img-fluid rounded" src="{{asset($image->path)}}" title="{{$image->name}}" alt="{{$image->name}}">
                    </a>
                    <div class="card-body">
                        <h5 class="card-title">{{$image->name}}</h5>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-sm-4 col-md-3 col-lg-2">
                <div class="card m-2">
                    <h5>Non ci sono foto nella gallery</h5>
                </div>
            </div>
        @endforelse
        {{$images->links('vendor.pagination.bootstrap-4')}}
    </div>

@endsection
