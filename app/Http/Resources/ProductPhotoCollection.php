<?php

namespace CodeShopping\Http\Resources;

use CodeShopping\Models\ProductPhoto;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductPhotoCollection extends ResourceCollection
{
    private $product;

    public function __construct($resource, $product)
    {
        $this->product = $product;
        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            "product" => new ProductResource($this->product),
            "photos" => $this->collection->map(function (ProductPhoto $productPhoto) {
                return new ProductPhotoResource($productPhoto, true);
            })
        ];
    }
}
