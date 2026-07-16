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
        ],
        [
            App\Services\TaxService::class,
            App\Services\Impl\TaxServiceImpl::class
        ],
        [
            App\Services\TaxCategoryService::class,
            App\Services\Impl\TaxCategoryServiceImpl::class
        ],
        [
            App\Services\TaxCategoryTaxService::class,
            App\Services\Impl\TaxCategoryTaxServiceImpl::class
        ]
    ]
];
