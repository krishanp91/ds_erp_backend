<?php

return [
    "mapping" => [
        [
            App\Services\CategoryService::class,
            App\Services\Impl\CategoryServiceImpl::class
        ],
        [
            App\Services\MeasureUnitService::class,
            App\Services\Impl\MeasureUnitServiceImpl::class
        ]
    ]
];