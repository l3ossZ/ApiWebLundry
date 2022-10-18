<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ServiceRate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category=Category::get();
        return $category;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $category=new Category();
        $category->clothType=$request->get('clothType');
        $category->addOnPrice=$request->get('addOnPrice');
        $category->service_rate_id=$request->get('service_rate_id');
        ServiceRate::find($category->service_rate_id)->clothList()->save($category);


        if ($category->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Category created with id ' . $category->id,
                'employee_id' =>$category->id
            ],Response::HTTP_CREATED);
        }
        return response()->json([
            'success' => false,
            'message' => 'Category creation failed'
        ], Response::HTTP_BAD_REQUEST);





    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        return $category;
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
        //
        $category->service_rate_id=$request->get('service_rate_id');
        $category->clothType=$request->get('clothType');
        $category->addOnPrice=$request->get('addOnPrice');

        if ($category->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Category updated with id ' . $category->id,
                'employee_id' =>$category->id
            ],Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => 'Category update failed'
        ], Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $clothType=$category->clothType;
        if($category->delete()){
            return response()->json([
                'success' => true,
                'message' => "Category {$clothType} has been deleted"
            ], Response::HTTP_OK);
        }
        return response()->json([
            'success' => false,
            'message' => "Category {$clothType} delete failed"
        ], Response::HTTP_BAD_REQUEST);
    }
    
}
