<?php
declare(strict_types=1);

use CodeShopping\Models\Product;
use CodeShopping\Models\ProductPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;

class ProdutcPhotosTableSeeder extends Seeder
{
    private $fakerPhotosPath = "app/faker/product_photos";
    private $allFakerPhotos;

    public function run()
    {
        $this->loadFakerPhotos();
        $this->deleteAllPhotosInProductsPath();
        $products = Product::all();

        foreach ($products as $product) {
            $this->createPhotoDir($product);
            $this->createPhotosModels($product);
        }
    }

    private function loadFakerPhotos()
    {
        $path = storage_path($this->fakerPhotosPath);
        $this->allFakerPhotos = collect(\File::allFiles($path));
    }

    private function deleteAllPhotosInProductsPath()
    {
        $path = ProductPhoto::PRODUCTS_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

    private function createPhotoDir(Product $product)
    {
        $path = ProductPhoto::photosPath($product->id);
        \File::makeDirectory($path, 0777, true);
    }

    private function createPhotosModels(Product $product)
    {
        foreach (range(1, 5) as $value) {
            $this->createPhotoModel($product);
        }
    }

    private function createPhotoModel(Product $product)
    {
        $productPhoto = ProductPhoto::create(["product_id" => $product->id, "file_name" => "imagem.jpg"]);
        $productPhoto = $this->generatePhoto($productPhoto);
        $productPhoto->save();
    }

    private function generatePhoto(ProductPhoto $productPhoto): ProductPhoto
    {
        $productPhoto->file_name = $this->uploadPhoto($productPhoto->product_id);
        return $productPhoto;
    }

    private function uploadPhoto($productPhotoId): string
    {
        $photoFile = $this->allFakerPhotos->random();
        $namePhoto = str_random(16) . "." . $photoFile->getExtension();
        $uploadFile = new UploadedFile($photoFile->getRealPath(), $namePhoto);
        ProductPhoto::uploadFiles($productPhotoId, [$uploadFile]);
        return $uploadFile->hashName();
    }
}
