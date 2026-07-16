<?php

namespace App\Services;

use App\Dtos\TaxCategoryDto;
use Illuminate\Support\Collection;

interface TaxCategoryService
{
    function createTaxCategory(TaxCategoryDto $taxCategoryDto): TaxCategoryDto;

    function getAllTaxCategories(): Collection;

    function getActiveTaxCategories(): Collection;

    function getTaxCategoryById(int $id): TaxCategoryDto;

    function updateTaxCategory(int $id, TaxCategoryDto $taxCategoryDto): TaxCategoryDto;

    function deleteTaxCategory(int $id): void;

    function activateTaxCategory(int $id): void;
}
