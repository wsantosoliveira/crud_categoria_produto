<?php
declare(strict_types=1);

namespace CodeShopping\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    const BASE_PATH = "app/public";
    const DIR_PRODUCTS = "products";
    const PRODUCTS_PATH = self::BASE_PATH . "/" . self::DIR_PRODUCTS;

    protected $fillable = ["file_name", "product_id"];

    public static function createWithPhotosFiles(int $productId, array $files): Collection
    {
        try {
            self::uploadFiles($productId, $files);
            \DB::beginTransaction();
            $photos = self::createPhotosModels($productId, $files);
            \DB::commit();
            return new Collection($photos);
        } catch (\Exception $e) {
            \DB::rollBack();
            self::deleteFiles($productId, $files);
            throw $e;
        }
    }

    public static function uploadFiles(int $productId, array $files)
    {
        $dir = self::photosDir($productId);

        foreach ($files as $file) {
            $file->store($dir, ["disk" => "public"]);
        }
    }

    public static function photosDir($productId)
    {
        $dir = self::DIR_PRODUCTS;
        return "{$dir}/{$productId}";
    }

    private static function createPhotosModels(int $productId, array $files)
    {
        $photos = [];
        foreach ($files as $file) {
            $photos[] = self::create([
                "file_name" => $file->hashName(),
                "product_id" => $productId
            ]);
            return $photos;
        }
    }

    private static function deleteFiles(int $productId, array $files)
    {
        $path = self::photosPath($productId);

        foreach ($files as $file) {
            $photoFile = "{$path}/{$file->hashName()}";
            if (file_exists($photoFile))
                \File::delete($photoFile);
        }
    }

    public static function photosPath($productId)
    {
        $path = self::PRODUCTS_PATH;
        return storage_path("{$path}/{$productId}");
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPhotoUrlAttribute()
    {
        $path = self::photosDir($this->product_id);
        return asset("storage/{$path}/{$this->file_name}");
    }
}
