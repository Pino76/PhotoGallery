<div class="form-group">
    <label for="thumbnail">Thumbnail</label>
    <input type="file" name="album_thumb" id="album_thumb"  class="form-control" value="{{$album->album_thumb}}">
</div>

@if($album->album_thumb)
    <div class="form-group">
        <img src="{{asset($album->path)}}" alt="{{$album->album_name}}" title="{{$album->album_name}}" width="200" height="200">
    </div>
@endif
