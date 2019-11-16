@extends("templates.layout")

@section('content')

<h1>Create Album</h1>

    <form method="POST" action="{{route('album.save')}}">
        {{csrf_field()}}
        <div class="form-group">
            <label for="nome">Name</label>
            <input type="text" name="name" id="name" value="" class="form-control" placeholder="Album Name">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description"  class="form-control" placeholder="Album Description">

            </textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

@endsection
