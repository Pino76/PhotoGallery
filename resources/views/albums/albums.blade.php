@php
    /**
 *
 * @var $album App\Models\Album;
 *
 */
@endphp
@extends('templates.default')

@section('content')

    <h1>Albums</h1>
    @if(session()->has('message'))
        <x-alert-info>{{ session()->get('message') }}</x-alert-info>
    @endif

    <table class="table table-striped table-dark albums">
        <thead>
        <tr class="align-middle">
            <th>Album Name</th>
            <th>Thumb</th>
            <th>Categories</th>
            <th>Author</th>
            <th>Date</th>
            <th>&nbsp;&nbsp;</th>
        </tr>
        </thead>
        @foreach($albums AS $album)
            <tr id="tr-{{$album->id}}" class="align-middle">

                <td>{{$album->id}} - {{$album->album_name}}</td>
                <td>
                    @if($album->album_thumb)
                        <img width="120" src="{{asset($album->path)}}"  title="{{$album->album_name}}" alt="{{$album->album_name}}">
                    @endif
                </td>
                <td>
                    @if($album->categories->count())
                       <ul>
                           @foreach($album->categories AS $cat)
                               <li>{{$cat->category_name}}</li>
                           @endforeach
                       </ul>
                    @else
                        Non ci sono categorie per questo album
                    @endif
                </td>
                <td>{{$album->user->name}}</td>
                <td>{{$album->created_at->format('d-m-Y')}}</td>
                <td>
                    <div class="row">
                        <div class="col-3">
                            @if($album->photos_count)
                                <a title="view images" href="{{route('albums.images', $album)}}" class="btn btn-secondary"><i class="bi bi-zoom-in"></i> {{$album->photos_count}}</a>
                            @else
                                <i class="bi bi-zoom-in"></i>
                            @endif
                        </div>
                        <div class="col-3">
                            <a title="add new image" href="{{route('photos.create')}}?album_id={{$album->id}}" class="btn btn-primary"><i class="bi bi-plus-circle"></i></a>
                        </div>
                        <div class="col-3">
                            <a title="update" href="{{route('albums.edit',$album)}}" class="btn btn-info"><i class="bi bi-pen"></i></a>
                        </div>
                        <div class="col-3">
                            <form id="form{{$album->id}}" method="POST" action="{{route('albums.destroy',$album->id)}}" class="form-inline">
                                @method('DELETE')

                                @csrf
                                <button id="{{$album->id}}" class="btn btn-danger"><i class="bi bi-trash" id="{{$album->id}}"></i></button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6">
                <div class="row">
                    <div class="col-md-8 offset-md-2 d-flex justify-content-center">
                        {{$albums->links('vendor.pagination.bootstrap-4')}}
                    </div>
                </div>
            </td>
        </tr>
    </table>

@endsection

@section('footer')
    @parent
    <script>

        $(function(){

            $(".alert.alert-info").fadeOut(5000);
            $("table").on("click" , "button.btn-danger" , function(evt){

                evt.preventDefault();
                var id = evt.target.id;

                var urlAlbum = $("#form"+id).attr('action');

                var tr = $("#tr-"+id);


                $.ajax(
                    urlAlbum,
                    {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': "{{@csrf_token()}}"
                        },

                        complete: function (resp) {

                            if (resp.responseText == 1) {
                                //   alert(resp.responseText)
                                tr.remove();
                                // $(li).remove();
                            } else {
                                alert('Problem contacting server');
                            }
                        }
                    }
                )
            })
        })
    </script>

@endsection
