<?php

namespace App\Services;

use App\Dtos\ProductDto;
use Illuminate\Support\Collection;

interface ProductService
{
    function createProduct(ProductDto $productDto): ProductDto;

    function getAllProducts(): Collection;

    function getActiveProducts(): Collection;

    function getProductById(int $id): ProductDto;

    function updateProduct(int $id, ProductDto $productDto): ProductDto;

    function deleteProduct(int $id): void;

    function activateProduct(int $id): void;
}
