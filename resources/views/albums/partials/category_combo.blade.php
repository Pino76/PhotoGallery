<div class="form-group">
    <label for="">Categories</label>
    <select name="categories[]" id="categories" class="form-control" multiple>
        @foreach($category AS $cat)
            <option {{in_array($cat->id, $selectedCategories) ? "selected" : ""}} value="{{$cat->id}}">{{$cat->category_name}}</option>
        @endforeach
    </select>
</div>
