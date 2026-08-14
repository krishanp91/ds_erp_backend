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
        'productType' => [
            'required' => 'Product type is required.',
            'string' => 'Product type must be a valid string.',
            'max' => 'Product type exceeds maximum :max characters.',
            'in' => 'Product type must be one of: S, V, P.',
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
        'supplierCode' => [
            'required' => 'Supplier code is required.',
            'max' => 'Supplier code exceeds maximum :max characters.',
            'unique' => 'Supplier code already taken.',
        ],
        'supplierName' => [
            'required' => 'Supplier name is required.',
            'max' => 'Supplier name exceeds maximum :max characters.',
        ],
        'contacts.*.contactName' => [
            'required' => 'Contact name is required.',
            'max' => 'Contact name exceeds maximum :max characters.',
        ],
        'contacts.*.isPrimary' => [
            'required' => 'Contact primary flag is required.',
            'in' => 'Contact primary flag must be 0 or 1.',
        ],
        'addresses.*.addressType' => [
            'required' => 'Address type is required.',
            'max' => 'Address type exceeds maximum :max characters.',
        ],
        'addresses.*.addressLine1' => [
            'required' => 'Address line 1 is required.',
            'max' => 'Address line 1 exceeds maximum :max characters.',
        ],
    ],
    "category.update.name.exists" => "Category name already taken.",
    "measure.unit.update.name.exists" => "Measure unit name already taken.",
    "tax.update.name.exists" => "Tax name already taken.",
    "tax_category.update.name.exists" => "Tax category name already taken.",
];