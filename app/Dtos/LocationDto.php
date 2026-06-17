<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 * The data transfer object for the Location model.
 *
 * @property int $id
 * @property string $locationCode
 * @property string $locationName
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $address3
 * @property string|null $telephone1
 * @property string|null $telephone2
 * @property int $active
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 */
class LocationDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
