<?php

namespace App\Dtos;

use Carbon\Carbon;
use Cerbero\LaravelDto\Dto;

use const Cerbero\Dto\PARTIAL;
use const Cerbero\Dto\IGNORE_UNKNOWN_PROPERTIES;

/**
 * The data transfer object for the Module model.
 *
 * @property int $id
 * @property string $moduleCode
 * @property string $moduleName
 * @property string|null $defaultScreen
 * @property int $active
 * @property Carbon|null $createdAt
 * @property Carbon|null $updatedAt
 */
class ModuleDto extends Dto
{
    /**
     * The default flags.
     *
     * @var int
     */
    protected static $defaultFlags = PARTIAL | IGNORE_UNKNOWN_PROPERTIES;
}
