<?php

namespace CodeShopping\Http\Controllers\API;

use CodeShopping\Http\Controllers\Controller;
use CodeShopping\Http\Requests\ProductPhotoRequest;
use CodeShopping\Http\Resources\ProductPhotoCollection;
use CodeShopping\Http\Resources\ProductPhotoResource;
use CodeShopping\Models\Product;
use CodeShopping\Models\ProductPhoto;
use Illuminate\Http\Response as Status;

class ProductPhotoController extends Controller
{
    public function index(Product $product)
    {
        return new ProductPhotoCollection($product->photos, $product);
    }

    public function store(ProductPhotoRequest $request, Product $product)
    {
        ProductPhoto::createWithPhotosFiles($product->id, $request->photos);
        return response()->json([], Status::HTTP_CREATED);
    }

    public function show(Product $product, $id)
    {
        $photo = $product->photos()->findOrFail($id);
        return new ProductPhotoResource($photo);
    }

    public function update(ProductPhotoRequest $request, Product $product, $id)
    {
        $photo = $product->photos()->findOrFail($id);
        $photo->updateWithPhoto($request->photo);
        return response()->json([], Status::HTTP_OK);
    }

    public function destroy(Product $product, $id)
    {
        $photo = $product->photos()->findOrFail($id);
        $photo->deletePhotoAndFiles();
        return response()->json([], Status::HTTP_NO_CONTENT);
    }
}
