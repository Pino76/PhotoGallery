@extends('templates.layout')

@section('content')
    <h1>Album List</h1>
    @if(session()->has("message"))
        @component('components.alert-info')
            {{session()->get("message")}}
        @endcomponent
    @endif
    <form>
        <input type="hidden" id="_token" name="_token" value="{{csrf_token()}}">
        <ul class="list-group">
            @forelse($albums AS $album)
                <li class="list-group-item">
                    {{$album->id}} - {{$album->album_name}}

                    <div class="float-right" style="border: 1px solid #F00">
                        @if($album->album_thumb)
                            <img src="{{$album->Path}}" alt="{{$album->album_name}}" title="{{$album->album_name}}" width="100" height="100">
                        @endif
                        <a href="/albums/{{$album->id}}" class="btn btn-primary" id="update">Update</a>
                        <a href="/albums/{{$album->id}}" class="btn btn-danger" id="delete">Delete</a>
                    </div>
                </li>
            @empty
                <h1>NON CI SONO ALBUM PRESENTI IN QUESTO CATALOGO</h1>
            @endforelse
        </ul>
    </form>
@endsection


@section('footer')
    @parent
    <script>
        $(function(){
            $(".alert-info").fadeOut(5000);
            $("ul").on("click", "a#delete", function(evt){
                evt.preventDefault();
                var urlAlbum = $(this).attr('href');
                var li = evt.target.parentNode.parentNode;
                $.ajax(
                    urlAlbum,
                    {
                        data:{
                            _token: $("#_token").val()
                        },
                        method: 'DELETE',
                        complete: function(resp){
                            if(resp.responseText == 1){
                                li.remove();
                            }
                        }
                    })
            });
        });
    </script>
@endsection


