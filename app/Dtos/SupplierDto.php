<?php

namespace App\Dtos;

/**
 * @OA\Schema(
 *     schema="SupplierRequest",
 *     type="object",
 *     title="SupplierRequest",
 *     description="Supplier creation request body",
 *     required={"first_name"},
 *     @OA\Property(property="first_name", type="string", description="Supplier first name"),
 *     @OA\Property(property="last_name", type="string", description="Supplier last name"),
 *     @OA\Property(property="company_name", type="string", description="Supplier company name"),
 *     @OA\Property(property="contact_person", type="string", description="Contact person name"),
 *     @OA\Property(property="mobile_no", type="string", description="Mobile number"),
 *     @OA\Property(property="active", type="integer", description="Active status")
 * )
 *
 * @OA\Schema(
 *     schema="SupplierResponse",
 *     type="object",
 *     title="SupplierResponse",
 *     description="Supplier response model",
 *     @OA\Property(property="id", type="integer", description="Supplier id"),
 *     @OA\Property(property="first_name", type="string", description="Supplier first name"),
 *     @OA\Property(property="last_name", type="string", description="Supplier last name"),
 *     @OA\Property(property="company_name", type="string", description="Supplier company name"),
 *     @OA\Property(property="contact_person", type="string", description="Contact person name"),
 *     @OA\Property(property="mobile_no", type="string", description="Mobile number"),
 *     @OA\Property(property="contact_detail_id", type="integer", description="Contact detail id"),
 *     @OA\Property(property="active", type="integer", description="Active status")
 * )
 */
class SupplierDto
{
}
