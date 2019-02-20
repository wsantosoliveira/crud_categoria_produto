<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\ProductInputRequest;
use CodeShopping\Http\Resources\ProductInputResource;
use CodeShopping\Models\Product;

class ProductInputController extends Controller
{
    public function index(Product $product)
    {
        //return ProductInputResource::collection(ProductInput::with("product")->paginate());
        return ProductInputResource::collection($product->inputs()->paginate());
    }

    public function store(ProductInputRequest $request, Product $product)
    {
        //$input = ProductInput::create($request->all());
        $input = $product->inputs()->create($request->all());
        return response()->json(new ProductInputResource($input), 201);
    }

    public function show(Product $product, $id)
    {
        $input = $product->inputs()->findOrFail($id);
        return new ProductInputResource($input);
    }
}
