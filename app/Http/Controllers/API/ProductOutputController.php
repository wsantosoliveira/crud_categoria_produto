<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\ProductOutputRequest;
use CodeShopping\Http\Resources\ProductOutputResource;
use CodeShopping\Models\Product;

class ProductOutputController extends Controller
{
    public function index(Product $product)
    {
        //return ProductOutputResource::collection(ProductOutput::with("product")->paginate());
        return ProductOutputResource::collection($product->outputs()->paginate());
    }

    public function store(ProductOutputRequest $request, Product $product)
    {
        //$output = ProductOutput::create($request->all());
        $output = $product->outputs()->create($request->all());
        return response(new ProductOutputResource($output), 201);
    }

    public function show(Product $product, $id)
    {
        $output = $product->outputs()->findOrFail($id);
        return new ProductOutputResource($output);
    }
}
