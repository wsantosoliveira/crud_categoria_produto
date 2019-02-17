<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\ProductRequest;
use CodeShopping\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::paginate(10);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
        $product->refresh();
        return $product;
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();
        return response([], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response([], 200);
    }
}
