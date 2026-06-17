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
    ],
    "category.update.name.exists" => "Category name already taken.",
    "measure.unit.update.name.exists" => "Measure unit name already taken.",
];