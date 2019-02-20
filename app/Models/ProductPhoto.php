<?php
declare(strict_types=1);

namespace CodeShopping\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

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
            throw new \Exception("Teste");
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
        $dir = self::photosDir($productId);
        foreach ($files as $file) {
            \Storage::disk("public")->delete("{$dir}/{$file->hashName()}");
        }
    }

    public static function photosPath($productId)
    {
        $path = self::PRODUCTS_PATH;
        return storage_path("{$path}/{$productId}");
    }

    public function updateWithPhoto(UploadedFile $file)
    {
        try {
            self::uploadFiles($this->product_id, [$file]);
            \DB::beginTransaction();
            $this->deletePhoto($this->product_id, $this->file_name);
            $this->file_name = $file->hashName();
            $this->save();
            \DB::commit();
            return $this;
        } catch (\Exception $e) {
            \DB::rollBack();
            self::deleteFiles($this->product_id, [$file]);
            throw $e;
        }
    }

    private function deletePhoto(int $productId, string $fileName)
    {
        $dir = self::photosDir($productId);
        \Storage::disk("public")->delete("{$dir}/{$fileName}");
    }

    public function deletePhotoAndFiles(): bool
    {
        try {
            \DB::beginTransaction();
            $this->deletePhoto($this->product_id, $this->file_name);
            $result = $this->delete();
            \DB::commit();
            return $result;
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function getPhotoUrlAttribute()
    {
        $path = self::photosDir($this->product_id);
        return asset("storage/{$path}/{$this->file_name}");
    }
}
