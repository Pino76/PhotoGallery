<div class="form-group">
    <label for="album_name">Thumbnail</label>
    <input type="file" name="album_thumb" id="album_thumb" class="form-control">
</div>

@if($album->album_thumb)
    <div class="form-group">
        <img width="300" src="{{asset($album->path)}}"  title="{{$album->album_name}}" alt="{{$album->album_name}}">
    </div>
@endif
