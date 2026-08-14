<?php

namespace App\Services\Impl;

use App\Dtos\AddressDto;
use App\Dtos\ContactDetailDto;
use App\Dtos\SupplierDto;
use App\Dtos\TaxCategoryDto;
use App\Exceptions\ErpException;
use App\Models\Address;
use App\Models\ContactDetail;
use App\Models\NumberSequence;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use App\Models\SupplierContact;
use App\Services\SupplierService;
use Cerbero\Dto\Dto;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SupplierServiceImpl implements SupplierService
{
    private const RELATIONS = [
        'taxCategory',
        'contacts.contactDetail',
        'addresses.address',
    ];

    private const SUPPLIER_SEQUENCE_NAME = 'supplier';
    private const SUPPLIER_CODE_PREFIX = 'SUP';
    private const SUPPLIER_CODE_PAD_LENGTH = 5;

    public function createSupplier(SupplierDto $supplierDto): SupplierDto
    {
        try {
            $supplier = DB::transaction(function () use ($supplierDto) {
                $attributes = $this->mapDtoToAttributes($supplierDto);
                $attributes['created_by'] = Auth::id();

                $supplier = Supplier::create($attributes);
                $this->advanceSupplierSequenceFromCode($supplier->supplier_code);
                $this->createSupplierContacts($supplier, $supplierDto);
                $this->createSupplierAddresses($supplier, $supplierDto);

                return $supplier;
            });

            return $this->toSupplierDto($supplier->load(self::RELATIONS));
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getAllSuppliers(): Collection
    {
        try {
            $suppliers = Supplier::with(self::RELATIONS)->withTrashed()->get();

            return $this->mapSuppliersToDtoCollection($suppliers);
        } catch (QueryException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getActiveSuppliers(): Collection
    {
        try {
            $suppliers = Supplier::with(self::RELATIONS)
                ->where('active', 1)
                ->get();

            return $this->mapSuppliersToDtoCollection($suppliers);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getSupplierById(int $id): SupplierDto
    {
        try {
            $supplier = Supplier::with(self::RELATIONS)
                ->withTrashed()
                ->where('id', $id)
                ->first();

            if ($supplier == null) {
                throw new ErpException("Supplier not found.", 400);
            }

            return $this->toSupplierDto($supplier);
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw new ErpException(trans("messages.erp.sql.exception.message"), 500, $e);
        }
    }

    public function updateSupplier(int $id, SupplierDto $supplierDto): SupplierDto
    {
        try {
            $supplier = DB::transaction(function () use ($id, $supplierDto) {
                $supplier = Supplier::where('id', $id)->withTrashed()->first();

                if ($supplier == null) {
                    throw new ErpException("Supplier not found.", 400);
                }

                $attributes = $this->mapDtoToAttributes($supplierDto, false);
                $attributes['updated_by'] = Auth::id();

                $supplier->fill($attributes);
                $supplier->update();
                $this->syncSupplierContacts($supplier, $supplierDto);
                $this->syncSupplierAddresses($supplier, $supplierDto);

                return $supplier;
            });

            return $this->toSupplierDto($supplier->load(self::RELATIONS));
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (ErpException $e) {
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function deleteSupplier(int $id): void
    {
        try {
            $supplier = Supplier::where('id', $id)->withTrashed()->first();

            if ($supplier == null) {
                throw new ErpException("Supplier not found.", 400);
            }

            $supplier->delete();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function activateSupplier(int $id): void
    {
        try {
            $supplier = Supplier::onlyTrashed()->where('id', $id)->first();

            if ($supplier == null) {
                throw new ErpException("Supplier not found.", 400);
            }

            $supplier->restore();
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    public function getNextSupplierCode(): string
    {
        try {
            return DB::transaction(function () {
                $sequence = $this->lockSupplierSequence();
                $this->syncSupplierSequenceWithExistingCodes($sequence);

                return $this->formatSupplierCode($sequence->last_value + 1);
            });
        } catch (QueryException $e) {
            Log::error("SQL exception thrown ".$e);
            throw $e;
        } catch (Exception $e) {
            Log::error("Unknown exception throws ".$e);
            throw new ErpException($e->getMessage(), 500, $e);
        }
    }

    private function lockSupplierSequence(): NumberSequence
    {
        $sequence = NumberSequence::where('name', self::SUPPLIER_SEQUENCE_NAME)
            ->lockForUpdate()
            ->first();

        if ($sequence == null) {
            throw new ErpException("Supplier number sequence not found.", 500);
        }

        return $sequence;
    }

    private function syncSupplierSequenceWithExistingCodes(NumberSequence $sequence): void
    {
        $maxExisting = $this->getMaxPersistedSupplierSequenceNumber();

        if ($maxExisting > $sequence->last_value) {
            $sequence->last_value = $maxExisting;
            $sequence->save();
        }
    }

    private function getMaxPersistedSupplierSequenceNumber(): int
    {
        $prefixLength = strlen(self::SUPPLIER_CODE_PREFIX) + 1;
        $pattern = '^'.self::SUPPLIER_CODE_PREFIX.'[0-9]{'.self::SUPPLIER_CODE_PAD_LENGTH.'}$';

        $maxExisting = Supplier::withTrashed()
            ->whereRaw('supplier_code REGEXP ?', [$pattern])
            ->selectRaw('MAX(CAST(SUBSTRING(supplier_code, ?) AS UNSIGNED)) as max_num', [$prefixLength])
            ->value('max_num');

        return (int) ($maxExisting ?? 0);
    }

    private function advanceSupplierSequenceFromCode(string $supplierCode): void
    {
        $number = $this->parseSupplierSequenceNumber($supplierCode);
        if ($number === null) {
            return;
        }

        $sequence = $this->lockSupplierSequence();
        if ($number > $sequence->last_value) {
            $sequence->last_value = $number;
            $sequence->save();
        }
    }

    private function parseSupplierSequenceNumber(string $supplierCode): ?int
    {
        $pattern = '/^'.self::SUPPLIER_CODE_PREFIX.'(\d{'.self::SUPPLIER_CODE_PAD_LENGTH.'})$/';
        if (!preg_match($pattern, $supplierCode, $matches)) {
            return null;
        }

        return (int) $matches[1];
    }

    private function formatSupplierCode(int $number): string
    {
        return self::SUPPLIER_CODE_PREFIX.str_pad(
            (string) $number,
            self::SUPPLIER_CODE_PAD_LENGTH,
            '0',
            STR_PAD_LEFT
        );
    }

    private function createSupplierContacts(Supplier $supplier, SupplierDto $supplierDto): void
    {
        $contacts = isset($supplierDto->contacts) ? $supplierDto->contacts : [];

        foreach ($contacts as $contactDto) {
            $contactDetail = ContactDetail::create([
                'contact_name' => $contactDto->contactName,
                'designation' => $contactDto->designation ?? null,
                'email' => $contactDto->email ?? null,
                'phone' => $contactDto->phone ?? '',
                'mobile' => $contactDto->mobile ?? '',
                'is_primary' => $contactDto->isPrimary,
                'created_by' => Auth::id(),
            ]);

            $supplier->contacts()->create([
                'contact_detail_id' => $contactDetail->id,
                'active' => 1,
                'created_by' => Auth::id(),
            ]);
        }
    }

    private function syncSupplierContacts(Supplier $supplier, SupplierDto $supplierDto): void
    {
        if (!isset($supplierDto->contacts)) {
            return;
        }

        $supplier->contacts()->with('contactDetail')->get()->each(function (SupplierContact $supplierContact) {
            if ($supplierContact->contactDetail) {
                $supplierContact->contactDetail->delete();
            }
            $supplierContact->delete();
        });

        $this->createSupplierContacts($supplier, $supplierDto);
    }

    private function createSupplierAddresses(Supplier $supplier, SupplierDto $supplierDto): void
    {
        $addresses = isset($supplierDto->addresses) ? $supplierDto->addresses : [];

        foreach ($addresses as $addressDto) {
            $address = Address::create([
                'address_type' => $addressDto->addressType,
                'address_line_1' => $addressDto->addressLine1,
                'address_line_2' => $addressDto->addressLine2 ?? null,
                'address_line_3' => $addressDto->addressLine3 ?? null,
                'city' => $addressDto->city ?? null,
                'district' => $addressDto->district ?? null,
                'province' => $addressDto->province ?? null,
                'postal_code' => $addressDto->postalCode ?? null,
                'is_primary' => $addressDto->isPrimary ?? null,
                'active' => 1,
                'created_by' => Auth::id(),
            ]);

            $supplier->addresses()->create([
                'address_id' => $address->id,
                'active' => 1,
                'created_by' => Auth::id(),
            ]);
        }
    }

    private function syncSupplierAddresses(Supplier $supplier, SupplierDto $supplierDto): void
    {
        if (!isset($supplierDto->addresses)) {
            return;
        }

        $supplier->addresses()->with('address')->get()->each(function (SupplierAddress $supplierAddress) {
            if ($supplierAddress->address) {
                $supplierAddress->address->delete();
            }
            $supplierAddress->delete();
        });

        $this->createSupplierAddresses($supplier, $supplierDto);
    }

    private function mapDtoToAttributes(SupplierDto $supplierDto, bool $includeSupplierCode = true): array
    {
        $attributes = [
            'supplier_name' => $supplierDto->supplierName,
            'credit_limit' => $supplierDto->creditLimit ?? null,
            'credit_period' => $supplierDto->creditPeriod ?? null,
            'tax_category_id' => $supplierDto->taxCategoryId ?? null,
            'active' => $supplierDto->active,
        ];

        if ($includeSupplierCode) {
            $attributes['supplier_code'] = $supplierDto->supplierCode;
        }

        return $attributes;
    }

    private function toSupplierDto(Supplier $supplier): SupplierDto
    {
        $contacts = $supplier->relationLoaded('contacts')
            ? $supplier->contacts
                ->filter(function (SupplierContact $supplierContact) {
                    return $supplierContact->contactDetail !== null;
                })
                ->map(function (SupplierContact $supplierContact) {
                    return ContactDetailDto::fromModel($supplierContact->contactDetail);
                })
                ->values()
                ->all()
            : [];

        $addresses = $supplier->relationLoaded('addresses')
            ? $supplier->addresses
                ->filter(function (SupplierAddress $supplierAddress) {
                    return $supplierAddress->address !== null;
                })
                ->map(function (SupplierAddress $supplierAddress) {
                    return $this->toAddressDto($supplierAddress->address);
                })
                ->values()
                ->all()
            : [];

        return new SupplierDto([
            'id' => $supplier->id,
            'supplierCode' => $supplier->supplier_code,
            'supplierName' => $supplier->supplier_name,
            'creditLimit' => $supplier->credit_limit !== null ? (float) $supplier->credit_limit : null,
            'creditPeriod' => $supplier->credit_period,
            'taxCategoryId' => $supplier->tax_category_id,
            'active' => $supplier->active,
            'createdBy' => $supplier->created_by,
            'updatedBy' => $supplier->updated_by,
            'deletedBy' => $supplier->deleted_by,
            'createdAt' => $supplier->created_at,
            'updatedAt' => $supplier->updated_at,
            'deletedAt' => $supplier->deleted_at,
            'taxCategory' => $supplier->taxCategory
                ? TaxCategoryDto::fromModel($supplier->taxCategory)
                : null,
            'contacts' => $contacts,
            'addresses' => $addresses,
        ]);
    }

    private function toAddressDto(Address $address): AddressDto
    {
        return new AddressDto([
            'id' => $address->id,
            'addressType' => $address->address_type,
            'addressLine1' => $address->address_line_1,
            'addressLine2' => $address->address_line_2,
            'addressLine3' => $address->address_line_3,
            'city' => $address->city,
            'district' => $address->district,
            'province' => $address->province,
            'postalCode' => $address->postal_code,
            'isPrimary' => $address->is_primary,
            'active' => $address->active,
            'createdBy' => $address->created_by,
            'updatedBy' => $address->updated_by,
            'deletedBy' => $address->deleted_by,
            'createdAt' => $address->created_at,
            'updatedAt' => $address->updated_at,
            'deletedAt' => $address->deleted_at,
        ]);
    }

    private function mapSuppliersToDtoCollection(Collection $suppliers): Collection
    {
        $result = new Collection();
        $suppliers->map(function ($item) use ($result): Dto {
            return $result[] = $this->toSupplierDto($item);
        });

        return collect($result);
    }
}
