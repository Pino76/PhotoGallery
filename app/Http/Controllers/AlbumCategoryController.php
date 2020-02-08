<?php

namespace App\Http\Controllers;


use App\Http\Requests\AlbumCategoryRequest;
use App\Models\AlbumCategory;
use Illuminate\Http\Request;
use Auth;

class AlbumCategoryController extends Controller{

    public function index(){
        #$categories = AlbumCategory::where('user_id', Auth::id())->withCount('albums')->latest()->paginate(env('CATEGORY_PER_PAGE'));
       # $categories = Auth::user()->albumCategories()->withCount('albums')->latest()->paginate(env('CATEGORY_PER_PAGE'));
        $categories = AlbumCategory::getCategoriesByUserId(auth()->user())->paginate(env('CATEGORY_PER_PAGE'));
        $category = new AlbumCategory();
        return view('categories.index' , ['categories' => $categories, 'category' => $category]);
    }


    public function create(){
        $category = new AlbumCategory();

        return view('categories.managecategory', [ 'category' => $category]);
    }


    public function store(AlbumCategoryRequest $request){
        $category = new AlbumCategory();
        $category->category_name = $request->category_name;
        $category->user_id = Auth::id();
        $category->save();
        return redirect()->route('categories.index');
    }


    public function show(AlbumCategory $category){
        return $category;
    }


    public function edit(AlbumCategory $category){
        return view('categories.managecategory', ['category' => $category]);
    }


    public function update(Request $request, AlbumCategory $category){
        $category->category_name = $request->category_name;
        $res =  $category->save();
        return redirect()->route('categories.index');
    }


    public function destroy(AlbumCategory $category){
        $res = $category->delete();
        return redirect()->route('categories.index');
    }
}


