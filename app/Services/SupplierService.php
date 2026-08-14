<?php

namespace App\Services;

use App\Dtos\SupplierDto;
use Illuminate\Support\Collection;

interface SupplierService
{
    function createSupplier(SupplierDto $supplierDto): SupplierDto;

    function getAllSuppliers(): Collection;

    function getActiveSuppliers(): Collection;

    function getSupplierById(int $id): SupplierDto;

    function updateSupplier(int $id, SupplierDto $supplierDto): SupplierDto;

    function deleteSupplier(int $id): void;

    function activateSupplier(int $id): void;

    function getNextSupplierCode(): string;
}
