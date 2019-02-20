<?php

namespace CodeShopping\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name" => "required|max:255",
            "email" => "required|email|max:255",
            "password" => "required|min:4|max:16"
        ];
    }
}
