<?php

namespace App\Services;

use App\Dtos\CategoryDto;
use Illuminate\Support\Collection;

interface CategoryService {
    function createCategory(CategoryDto $categoryDto): CategoryDto;

    function getAllCategories(?string $active = null): Collection;

    function getActiveCategories(): Collection;

    function getCategoryById(int $id): CategoryDto;

    function updateCategory(int $id, CategoryDto $categoryDto): CategoryDto;

    function deleteCategory(int $id): void;

    function activateCatgory(int $id): void;
}