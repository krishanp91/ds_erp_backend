<?php

// return [
//     "category.name.required" => "Category name is required.",
//     "category.name.exceeds.max.characters" => "Category name exceeds maximum %d characters.",
//     "category.name.not.unique" => "Category name already taken",
// ];

return [
    'custom' => [
        'id' => [
            'required' => 'Category id is required.',
        ],
        'categoryName' => [
            'required' => 'Category name is required.',
            'max' => 'Category name exceeds maximum :max characters.',
            'unique' => 'Category name already taken.',
        ],
        'productName' => [
            'required' => 'Product name is required.',
            'max' => 'Product name exceeds maximum :max characters.',
        ],
        'productTypeId' => [
            'required' => 'Product type is required.',
            'integer' => 'Product type must be a valid integer.',
        ],
        'active' => [
            'required' => 'Active status is required.',
            'integer' => 'Active status must be a valid integer.',
            'in' => 'Active status must be 0 or 1.',
        ],
        'itemCode' => [
            'max' => 'Item code exceeds maximum :max characters.',
        ],
        'productDescription' => [
            'max' => 'Product description exceeds maximum :max characters.',
        ],
    ],
    "category.update.name.exists" => "Category name already taken.",
    "measure.unit.update.name.exists" => "Measure unit name already taken.",
    "tax.update.name.exists" => "Tax name already taken.",
    "tax_category.update.name.exists" => "Tax category name already taken.",
];