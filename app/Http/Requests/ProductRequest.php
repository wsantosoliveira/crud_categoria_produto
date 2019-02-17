<?php

namespace CodeShopping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" => "required|max:255",
            "description" => "required",
            "price" => "required|numeric|between:0,999999999999999999.99",
            "stock" => "integer",
            "active" => "boolean"
        ];
    }
}
