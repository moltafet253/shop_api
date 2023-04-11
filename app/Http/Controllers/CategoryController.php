<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::paginate(2);
        return $this->successResponse([
            'brands' => CategoryResource::collection($categories),
            'links' => CategoryResource::collection($categories)->response()->getData()->links,
            'meta' => CategoryResource::collection($categories)->response()->getData()->meta,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'required|integer',
            'name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        DB::beginTransaction();
        $category = Category::create([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'description' => $request->description
        ]);

        DB::commit();

        return $this->successResponse(new CategoryResource($category), 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $this->successResponse(new CategoryResource($category), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'required|integer',
            'name' => 'required|string'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        DB::beginTransaction();
        $category->update([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'description' => $request->description
        ]);

        DB::commit();

        return $this->successResponse(new CategoryResource($category), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        $category->delete();
        DB::commit();
        return $this->successResponse(new CategoryResource($category), 200);
    }

//    public function children(Category $category)
//    {
//        return $this->successResponse(new CategoryResource($category->load('children')));
//    }
//    public function parent(Category $category)
//    {
//        return $this->successResponse(new CategoryResource($category->load('parent')));
//    }

    public function products(Category $category)
    {
        return $this->successResponse(new CategoryResource($category->load('products')));
    }
}
