@extends('templates.default')

@section('content')
@php
/**
 * @var $image App\Models\Photo
 * @var $album App\Models\Album
 **/
@endphp

@if(session()->has('message'))
    @component('components.alert-info')
        <x-alert-info>{{ session()->get('message') }}</x-alert-info>
    @endcomponent
@endif
<h2>Immagine per album: {{$album->album_name}}</h2>
    <table class="table table-striped">
        <tr class="thead-dark">
            <th>Id</th>
            <th>Created Date</th>
            <th>Title</th>
            <th>Album</th>
            <th>Thumbnail</th>
            <th>Actions</th>
        </tr>
        @forelse($images AS $image)
            <tr>
                <td>{{$image->id}}</td>
                <td>{{$image->created_at}}</td>
                <td>{{$image->name}}</td>
                <td>{{$album->album_name}}</td>
                <td><img width="80" src="{{asset($image->img_path)}}"/></td>
                <td>
                    <a href="{{route('photos.edit', $image->id)}}" class="btn btn-small btn-primary">Modifica</a>
                    <a href="{{route('photos.destroy', $image->id)}}" class="btn btn-small btn-danger">Delete</a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    No Images found
                </td>
            </tr>
        @endforelse
        <tr>
            <td colspan="6">
                {{$images->links('vendor.pagination.bootstrap-4')}}
            </td>
        </tr>
    </table>

@endsection

@section('footer')
    @parent
    <script>
        $(function(){
           // $(".alert.alert-info").fadeOut(5000);
            $("table").on("click" , "a.btn-danger" , function(ele){
                ele.preventDefault();
                var urlImage = $(this).attr('href');
                var tr = ele.target.parentNode.parentNode;
                $.ajax(urlImage, {
                    method:'DELETE',
                    data:{
                        '_token': '{{@csrf_token()}}'
                    },

                    complete:function (resp){
                        if(resp.responseText == 1){
                            $(tr).remove();
                        }else{
                            alert("problemi con il server");
                        }
                    }
                })
            })
        })
    </script>
@endsection
