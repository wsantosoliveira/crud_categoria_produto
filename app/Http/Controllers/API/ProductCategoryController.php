<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\ProductCategoryRequest;
use CodeShopping\Models\Category;
use CodeShopping\Models\Product;

class ProductCategoryController extends Controller
{
    public function index(Product $product)
    {
        return $product->categories;
    }

    public function store(ProductCategoryRequest $request, Product $product)
    {
        $product->categories()->sync($request->categories);
        return response([], 200);
    }

    public function destroy(Product $product, Category $category)
    {
        $product->categories()->detach($category->id);
        return response([], 204);
    }
}
