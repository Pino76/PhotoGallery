    @include('partials.inputerrors')

    @if($category->category_name)
        <h2>Modify category</h2>
        <form method="post" action="{{route('categories.update', $category->id)}}" class="row">
            @method('patch')
    @else
        <h2>Create new category</h2>
        <form action="{{route('categories.store')}}" id="manageCategoryForm" method="post" class="row">
    @endif

        @csrf
        <div class="form-group">
            <input type="text" placeholder="category name" value="{{old('category_name' , $category->category_name)}}" name="category_name" class="form-control" id="category_name">
        </div>

        <div class="form-group m-4 d-flex justify-content-center">
            @if($category->category_name)
                <button class="btn btn-success m-2"><i class="bi bi-pen">UPDATE</i></button>
        </form>
                <form action="{{route('categories.destroy', $category->id)}}" method="post">
                    @csrf
                    @method('delete')
                    <button class="btn btn-danger m-2" title="DELETE CATEGORY"><i class="bi bi-trash">DELETE</i></button>
                </form>
            @else
                <button class="btn btn-primary  m-2"><i class="bi bi-save">SAVE</i></button>
            @endif

            </div>
        </form>
