<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\ProductPhotoRequest;
use CodeShopping\Http\Resources\ProductPhotoCollection;
use CodeShopping\Http\Resources\ProductPhotoResource;
use CodeShopping\Models\Product;
use CodeShopping\Models\ProductPhoto;

class ProductPhotoController extends Controller
{
    public function index(Product $product)
    {
        return new ProductPhotoCollection($product->photos, $product);
    }

    public function store(ProductPhotoRequest $request, Product $product)
    {
        ProductPhoto::createWithPhotosFiles($product->id, $request->photos);
        return response()->json([], 201);
    }

    public function show(Product $product, $id)
    {
        $photo = $product->photos()->findOrFail($id);
        return new ProductPhotoResource($photo);
    }

    public function update(ProductPhotoRequest $request, Product $product)
    {
    }

    public function destroy(Product $product, $id)
    {
        $photo = $product->photos()->findOrFail($id);
        //$photo->deletePhotoAndFiles();
        return response()->json([], 204);
    }
}
