<?php

namespace App\Config;

use Cerbero\LaravelDto\Console\DtoQualifierContract;
use Illuminate\Support\Facades\Log;

class CustomDtoQualifier implements DtoQualifierContract
{
    public function qualify(string $model): string
    {
        Log::info("Model name ".$model);
        $segments = explode('\\', $model);
        $baseName = array_pop($segments);
        $segments[] = 'Dtos';
        $segments[] = $baseName . 'Dto';

        $newSegments = ["App", "Dtos", $baseName . 'Dto'];

        return implode('\\', $newSegments);
    }
}