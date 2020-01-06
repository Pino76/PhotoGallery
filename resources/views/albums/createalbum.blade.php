@extends("templates.layout")

@section('content')
    <h1>Nuovo Album</h1>
    @include('partials.inputerrors')
    <form action="{{route('albums.save')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="form-group">
            <label for="nome">Name</label>
            <input type="text" name="name" id="name" value="{{old('name')}}" class="form-control" placeholder="Album Name">
        </div>

        @include('albums.partial.fileupload')

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description"  class="form-control" placeholder="Album Description">
                {{old('description')}}
            </textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
