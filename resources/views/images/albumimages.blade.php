@extends('templates.layout')
@section('content')
    <h1>Images for {{$album->album_name}}</h1>
    @if(session()->has('message'))
        @component('components.alert-info')
            {{session()->get("message")}}
        @endcomponent
    @endif
    <table class="table table-striped">
        <tr class="thead-dark">
            <th>Created Date</th>
            <th>Title</th>
            <th>Album</th>
            <th>Thumbnail</th>
            <th>Action</th>
        </tr>
        @forelse($images AS $image)
            <tr>
                <td>{{$image->created_at->format('d/m/Y')}}</td>
                <td>{{$image->name}}</td>
                <td><a href="{{route('albums')}}">{{$album->album_name}}</a></td>
                <td><img src="{{asset($image->img_path)}}"  width="121"></td>
                <td width="150px">
                    <a href="{{route('photos.destroy' , $image->id)}}" class="btn btn-sm btn-danger"><span class="fa fa-minus"></span></a>
                    <a href="{{route('photos.edit' , $image->id)}}" class="btn  btn-sm btn-primary"><span class="fa fa-pencil"></span></a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">NON ci sono Album</td>
            </tr>
        @endforelse
        <tr>

            <td colspan="6">
                <div style="width: 55%; margin: 0 auto">
                    {{$images->links('vendor.pagination.bootstrap-4')}}
                </div>
            </td>

        </tr>
    </table>
@endsection

@section('footer')
    @parent
    <script>
        $(function(){
            $('table').on('click','a.btn-danger',function(ele){
                ele.preventDefault();

                var urlImg = $(this).attr('href');
                var tr = ele.target.parentNode.parentNode;
                $.ajax(
                    urlImg,
                    {
                        method: 'DELETE',
                        data : {
                            '_token' : '{{csrf_token()}}'
                        },
                        complete : function (resp) {
                            if(resp.responseText == 1){
                                tr.parentNode.removeChild(tr);

                            }else {
                                alert('Problemi con la cancellazione del record');
                            }
                        }
                    })
            });
        });
    </script>
@endsection



