<?php
declare(strict_types=1);

namespace CodeShopping\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Sluggable;

    protected $fillable = ["name", "active", "description", "price"];

    public function sluggable(): array
    {
        return [
            "slug" => [
                "source" => "name"
            ]
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
