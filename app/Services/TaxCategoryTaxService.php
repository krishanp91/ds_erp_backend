<?php

namespace App\Services;

use App\Dtos\TaxCategoryTaxDto;
use Illuminate\Support\Collection;

interface TaxCategoryTaxService
{
    function createTaxCategoryTax(TaxCategoryTaxDto $taxCategoryTaxDto): TaxCategoryTaxDto;

    function getAllTaxCategoryTaxes(): Collection;

    function getTaxCategoryTaxById(int $id): TaxCategoryTaxDto;

    function updateTaxCategoryTax(int $id, TaxCategoryTaxDto $taxCategoryTaxDto): TaxCategoryTaxDto;

    function deleteTaxCategoryTax(int $id): void;

    function activateTaxCategoryTax(int $id): void;
}
