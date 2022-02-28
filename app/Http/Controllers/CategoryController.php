<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    protected $rules = [
            "category_name" => "required"
        ];



    protected $message = [
        "category_name.required" => "Il campo Categoria è obbligatorio"
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        #$categories = auth()->user()->categories()->paginate(5);

        $categories = Category::getCategoriesByUserId(auth()->user())->paginate(5);
        $category = new Category();
        return view('categories.index', ["categories" => $categories , "category" => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        return view('categories.create' , ["category" => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules, $this->message);
       $res = Category::create([
            "category_name" => $request->category_name,
            "user_id" => auth()->id()
        ]);

        $message = $res ? 'Category created' : 'Problem creating category'.$request->category_name;

        if($request->expectsJson()){
            return [
                "message" => $message,
                "success" => (bool)$res,
                "data"=>$res
           ];
       }

        session()->flash('message' , $message);
        return  redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.create' , ["category"=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $this->validate($request, $this->rules, $this->message);
        $category->category_name = $request->category_name;
        $res = $category->save();
        $message = $res ? 'Category updated' : 'Problem updated category';
        session()->flash('message' , $message);
        if($request->expectsJson()){
            return [
                "message" => $message,
                "success" => $res
            ];
        }
        return  redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {
        $res = $category->delete();
        $message = $res ? 'Category deleted' : 'Problem deleted category';

        if($request->expectsJson()){
            return [
                "message" => $message,
                "success" => $res
            ];
        }
        session()->flash('message' , $message);
        return  redirect()->route('categories.index');
    }



}
