<?php

namespace CodeShopping\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPhotoResource extends JsonResource
{
    private $isCollection;

    public function __construct($resource, $isCollection = false)
    {
        parent::__construct($resource);
        $this->isCollection = $isCollection;
    }

    public function toArray($request)
    {
        $data = [
            "id" => $this->id,
            "file_name" => $this->file_name,
            "photo_url" => $this->photo_url,
            "product_id" => $this->product_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
        if (!$this->isCollection)
            $data["product"] = new ProductResource($this->resource->product);

        return $data;
    }
}
