<?php

namespace App\Services;

use App\Dtos\TaxDto;
use Illuminate\Support\Collection;

interface TaxService
{
    function createTax(TaxDto $taxDto): TaxDto;

    function getAllTaxes(): Collection;

    function getActiveTaxes(): Collection;

    function getTaxById(int $id): TaxDto;

    function updateTax(int $id, TaxDto $taxDto): TaxDto;

    function deleteTax(int $id): void;

    function activateTax(int $id): void;
}
