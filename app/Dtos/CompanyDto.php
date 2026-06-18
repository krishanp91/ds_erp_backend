<?php

namespace App\Dtos;

/**
 * @OA\Schema(
 *     schema="CompanyResponse",
 *     type="object",
 *     title="CompanyResponse",
 *     description="Company details",
 *     @OA\Property(property="id", type="integer", description="Company id"),
 *     @OA\Property(property="company_name", type="string", description="Company name"),
 *     @OA\Property(property="company_address1", type="string", description="Address line 1"),
 *     @OA\Property(property="company_address2", type="string", description="Address line 2"),
 *     @OA\Property(property="company_address3", type="string", description="Address line 3"),
 *     @OA\Property(property="company_tel1", type="string", description="Telephone 1"),
 *     @OA\Property(property="company_tel2", type="string", description="Telephone 2"),
 *     @OA\Property(property="company_fax", type="string", description="Fax number"),
 *     @OA\Property(property="company_email", type="string", description="Company email"),
 *     @OA\Property(property="company_web", type="string", description="Company website")
 * )
 */
class CompanyDto
{
}
