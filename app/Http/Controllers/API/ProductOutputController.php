<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\ProductOutputRequest;
use CodeShopping\Http\Resources\ProductOutputResource;
use CodeShopping\Models\ProductOutput;

class ProductOutputController extends Controller
{
    public function index()
    {
        return ProductOutputResource::collection(ProductOutput::with("product")->paginate());
    }

    public function store(ProductOutputRequest $request)
    {
        $output = ProductOutput::create($request->all());
        return new ProductOutputResource($output);
    }

    public function show(ProductOutput $output)
    {
        return new ProductOutputResource($output);
    }
}
