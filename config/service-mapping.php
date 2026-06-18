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
        ],
        [
            App\Services\ProductService::class,
            App\Services\Impl\ProductServiceImpl::class
        ]
    ]
];