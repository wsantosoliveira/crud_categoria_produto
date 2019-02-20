<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Common\OnlyTrashed;
use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\ProductRequest;
use CodeShopping\Http\Resources\ProductResource;
use CodeShopping\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response as Status;

class ProductController extends Controller
{
    use OnlyTrashed;

    public function index(Request $request)
    {
        $query = Product::query();
        $query = $this->onlyTrashedIfRequested($request, $query);
        return ProductResource::collection($query->paginate());
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
        $product->refresh();
        return response()->json(new ProductResource($product), Status::HTTP_CREATED);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->all());
        $product->save();
        return response()->json([], Status::HTTP_OK);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([], Status::HTTP_NO_CONTENT);
    }

    public function restore(Product $product)
    {
        $product->restore();
        return response()->json([], Status::HTTP_NO_CONTENT);
    }
}
