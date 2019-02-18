<?php

namespace CodeShopping\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductInputResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "amount" => (int)$this->amount,
            "product_id" => $this->product_id,
            "product" => new ProductResource($this->resource->product)
        ];
    }
}
