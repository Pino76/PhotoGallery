@extends('templates.layout')

@section('content')
<div class="row">
    <div class="col-8">
        <table class="table table-striped">
            <tr>
                <th>Id</th>
                <th>Category Name</th>
                <th>Created Date</th>
                <th>Number of Albums</th>
                <th>Actions</th>
            </tr>
            @forelse($categories as $categoryI)
            <tr>
                <td>{{$categoryI->id}}</td>
                <td>{{$categoryI->category_name}}</td>
                <td>{{$categoryI->created_at}}</td>
                <td>{{$categoryI->albums_count}}</td>
                <td>
                    <form method="POST" action="{{route('categories.destroy' , $categoryI->id)}}">
                        {{method_field('DELETE')}}
                        {{csrf_field()}}
                        <button class="btn btn-danger" title="delete"><span class="fa fa-minus"></span></button>
                        <a href="{{route('categories.edit' ,  $categoryI->id)}}" class="btn btn-info" title="update">
                            <span class="fa fa-pencil"></span>
                        </a>
                    </form>
                </td>
            </tr>
            @empty
            <tfoot>
                <tr>
                    <td colspan="5">No Categories</td>
                </tr>
            </tfoot>
            @endforelse
            <tfoot>
                <tr>
                    <td colspan="5">{{$categories->links('vendor.pagination.bootstrap-4')}}</td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="col-4">
        <h4>Add New Category</h4>
        @include('categories.categoryform')
        @include('partials.inputerrors')
    </div>
</div>
@endsection
