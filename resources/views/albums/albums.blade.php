@extends('templates.layout')

@section('content')
    <h1>Albums</h1>
    @if(session()->has('message'))
        @component('components.alert-info')
            {{session()->get("message")}}
        @endcomponent
    @endif



    <table class="table table-striped">
        <thead>
        <tr>
            <th>Album name</th>
            <th>Thumb</th>
            <th>Creator</th>
            <th>Categories</th>
            <th>Created Date</th>
            <th>&nbsp;&nbsp;</th>
        </tr>
        </thead>


        @foreach($albums AS $album)
            <tr id="tr{{$album->id}}">
                <td> {{$album->id}} ) - {{$album->album_name}} [ {{$album->photos_count}} - pictures ]</td>

                <td>
                    @if($album->album_thumb)
                        <img src="{{asset($album->path)}}" alt="{{$album->album_name}}" title="{{$album->album_name}}" width="100" >
                    @endif
                </td>
                <td>{{$album->user->name}}</td>
                <td>
                    <ul>
                    @forelse($album->categories AS $category)
                            <li>{{$category->category_name}}</li>
                    @empty
                        <li>No Category</li>
                    @endforelse
                    </ul>
                </td>
                <td>{{$album->created_at->format('d/m/Y')}}</td>
                <td>
                    <div class="row">
                        <div class="col-3">
                            <a href="{{route('photos.create')}}?album_id={{$album->id}}" class="btn btn-success" title="add picture"><span class="fa fa-plus-square-o"></span></a>
                        </div>
                        <div class="col-3">
                            @if($album->photos_count)
                                <a href="{{route('album.getImages',$album->id)}}" id="showImg" class="btn btn-primary" title="show images"><span class="fa fa-search"></span></a>
                            @else
                                <span class="fa fa-search"></span>
                            @endif
                        </div>
                        <div class="col-3">
                            <a href="{{route('album.edit' , $album->id)}}" id="edit" class="btn btn-info" title="edit"> <span class="fa fa-pencil"></span></a>
                        </div>
                        <div class="col-3">
                            <form id="form{{$album->id}}" method="post" action="{{route('album.delete' , $album->id)}}">
                                @csrf
                                @method('DELETE')
                                <button id="{{$album->id}}" class="btn btn-danger" title="delete">
                                    <span class="fa fa-minus"></span>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        <tr>
            <td class="" colspan="6">
                <div >
                    <div style="margin: 0 auto; width: 10%;">{{$albums->links('vendor.pagination.bootstrap-4')}}</div>
                </div>
            </td>
        </tr>
    </table>
@endsection

@section('footer')
    @parent
    <script>
        $(function () {
            $("div.alert").fadeOut(6000);
            $('table').on('click', 'button.btn-danger', function (evt) {
                evt.preventDefault();
                var id = evt.currentTarget.id;
                var form = $("#form" + id);
                var urlAlbum = form.attr('action');
                var tr = $("#tr" + id);
                $.ajax(
                    urlAlbum,
                    {
                        data:{
                            _token: '{{csrf_token()}}'
                        },
                        method: 'DELETE',
                        complete: function(resp){
                            if(resp.responseText == 1){
                                tr.remove();
                            }
                        }
                    })
            });
        });
    </script>
@endsection
