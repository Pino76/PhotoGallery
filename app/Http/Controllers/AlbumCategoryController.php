<?php

namespace App\Http\Controllers;


use App\Models\AlbumCategory;
use Illuminate\Http\Request;

class AlbumCategoryController extends Controller{

    public function index(){
        return AlbumCategory::with('albums')->get();
    }


    public function create(){
        //
    }


    public function store(Request $request){
        //
    }


    public function show(AlbumCategory $category){
        return $category;
    }


    public function edit(AlbumCategory $category){
        return $category;
    }


    public function update(Request $request, $id){
        //
    }


    public function destroy($id){
        //
    }
}
