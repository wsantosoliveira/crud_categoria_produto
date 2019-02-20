<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\CategoryRequest;
use CodeShopping\Http\Resources\CategoryResource;
use CodeShopping\Models\Category;
use Illuminate\Http\Response as Status;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->all());
        $category->refresh();
        return response()->json(new CategoryResource($category), Status::HTTP_CREATED);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        $category->save();
        return response()->json([], Status::HTTP_OK);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([], Status::HTTP_NO_CONTENT);
    }

    public function restore(Category $category)
    {
        $category->restore();
        return response()->json([], Status::HTTP_NO_CONTENT);
    }
}
