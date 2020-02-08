<div class="row">
    <div class="col-md-6">
        <form action="{{!$category->category_name  ? route('categories.store') : route('categories.update', $category->id) }}" method="POST" class="form-inline">
            {{csrf_field()}}
            {{ $category->category_name ? method_field('PATCH') : '' }}
            <div class="form-group">
                <input type="text" value="{{$category->category_name}}" name="category_name" id="category_name" class="form-control">
            </div>
            <div class="form-group">
                <button class="btn btn-primary" title="save"><span class="fa fa-save"></span></button>
            </div>
        </form>
    </div>

        @if($category->category_name)
    <div class="col-md-6">
        <form method="POST" action="{{route('categories.destroy' , $category->id)}}">
            {{method_field('DELETE')}}
            {{csrf_field()}}
            <button class="btn btn-danger" title="delete"><span class="fa fa-minus"></span></button>
        </form>
    </div>
        @endif

</div>
